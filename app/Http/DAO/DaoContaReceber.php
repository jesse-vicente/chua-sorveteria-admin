<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Dao\DaoCliente;
use App\Http\Dao\DaoVenda;
use App\Http\Dao\DaoFuncionario;
use App\Http\Dao\DaoFormaPagamento;

use App\Http\Models\Venda;
use App\Http\Models\ContaReceber;

use App\Http\Models\ProdutoVenda;

class DaoContaReceber implements Dao {

    private DaoCliente $daoCliente;
    private DaoVenda $daoVenda;
    private DaoFuncionario $daoFuncionario;
    private DaoFormaPagamento $daoFormaPagamento;

    public function __construct()
    {
        $this->daoVenda = new DaoVenda();
        $this->daoCliente = new DaoCliente();
        $this->daoFuncionario = new DaoFuncionario();
        $this->daoFormaPagamento = new DaoFormaPagamento();
    }

    public function all(bool $model = false) {
        if (!$model)
            return DB::table('contas_receber')->get();

        $dados = DB::table('contas_receber')->get();

        $contas = array();

        foreach ($dados as $dado) {
            $conta = $this->create(get_object_vars($dado));
            array_push($contas, $conta);
        }

        return $contas;
    }

    public function create(array $dados) {
        $conta = new ContaReceber();

        if (isset($dados["num_nota"])) {
            $conta->setDataCadastro($dados["data_cadastro"] ?? null);
            $conta->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        if (isset($dados["status"]))
            $conta->setStatus($dados["status"]);

        // Dados nota
        $key = $dados["num_nota"] . "-" . $dados["serie"] . "-" . $dados["modelo"] . "-" . $dados["cliente_id"];

        $venda = $this->daoVenda->findByPrimaryKey($key, true);

        $conta->setVenda($venda);

        $conta->setParcela($dados["parcela"]);
        $conta->setValorParcela(floatval($dados["valor_parcela"]));

        $conta->setDataVencimento($dados["data_vencimento"]);
        $conta->setDataPagamento($dados["data_pagamento"]);

        $cliente = $this->daoCliente->findById($dados["cliente_id"], true);
        // $funcionario = $this->daoCliente->findById($dados["funcionario_id"], true);
        $formaPagamento = $this->daoFormaPagamento->findById($dados["forma_pagamento_id"], true);

        $conta->setCliente($cliente);
        // $conta->setFuncionario($funcionario);
        $conta->setFormaPagamento($formaPagamento);

        return $conta;
    }

    public function store($venda) {
        DB::beginTransaction();

        try {
            $dadosVenda   = $this->getData($venda);
            $dadosProdutos = $this->getProductsData($venda);
            $dadosContasReceber = $this->getDuplicatesData($venda);

            // dd($dadosProdutos);

            DB::table('vendas')->insert($dadosVenda);
            DB::table('produtos_venda')->insert($dadosProdutos);
            DB::table('contas_receber')->insert($dadosContasReceber);

            // Atualizar produtos em estoque
            foreach ($venda->getProdutos() as $produtoVenda) {

                $id = $produtoVenda->getProduto()->getId();

                $produtoEstoque = $this->daoProduto->findById($id, true);

                $estoque    = $produtoEstoque->getEstoque();
                $precoCusto = $produtoVenda->getProduto()->getPrecoCusto();

                ($estoque != 0)
                    ? $estoque += $produtoVenda->getQuantidade()
                    : $estoque  = $produtoVenda->getQuantidade();

                $produtoEstoque->setEstoque($estoque);
                $produtoEstoque->setPrecoCusto($precoCusto);

                $produtoEstoque->setCustoUltimaVenda($precoCusto);
                $produtoEstoque->setDataUltimaVenda(date('Y-m-d'));

                $dadosProduto = $this->daoProduto->getData($produtoEstoque);

                DB::table('produtos')->where('id', $id)->update($dadosProduto);
            }

            DB::commit();
            return true;

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return false;
        }
    }

    public function update(Request $request, $key) {
        DB::beginTransaction();

        try {
            $contaReceber = $this->findByPrimaryKey($key, true);
            $venda = $contaReceber->getVenda();

            $numero = $venda->getNumeroNota();
            $serie  = $venda->getSerie();
            $modelo = $venda->getModelo();
            $idCliente = $venda->getCliente()->getId();

            DB::table('vendas')
                ->where('num_nota', $numero)
                ->where('serie', $serie)
                ->where('modelo', $modelo)
                ->where('cliente_id', $idCliente)
                ->update(['status' => 'Ativo']);

            DB::table('contas_receber')
                ->where('num_nota', $numero)
                ->where('serie', $serie)
                ->where('modelo', $modelo)
                ->where('parcela', $contaReceber->getParcela())
                ->where('cliente_id', $idCliente)
                ->update(['status' => 'Liquidado']);

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return false;
        }
    }

    public function delete($id) {
        DB::beginTransaction();

        try {
            DB::table('vendas')->delete($id);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function findByPrimaryKey(string $pk, bool $model = false) {
        $key = explode('-', $pk);

        $numero     = $key[0];
        $serie      = $key[1];
        $modelo     = $key[2];
        $cliente    = $key[3];

        if (!$model) {
            $dados = DB::table('contas_receber')
                       ->where('num_nota', $numero)
                       ->where('serie', $serie)
                       ->where('modelo', $modelo)
                       ->where('cliente_id', $cliente)
                       ->first();

            return $dados;
        }

        $dados = DB::table('contas_receber')
                         ->where('num_nota', $numero)
                         ->where('serie', $serie)
                         ->where('modelo', $modelo)
                         ->where('modelo', $modelo)
                         ->where('cliente_id', $cliente)
                         ->first();

        if ($dados) {
            $conta = $this->create(get_object_vars($dados));
            return $conta;
        }

        return [];
    }

    public function findById(int $id, bool $model = false)
    {
        //
    }

    public function getData(Venda $venda) {
        $dados = array(
            'modelo'                => $venda->getModelo(),
            'serie'                 => $venda->getSerie(),
            'num_nota'              => $venda->getNumeroNota(),
            'data_venda'            => $venda->getDataVenda(),
            'cliente_id'            => $venda->getCliente()->getId(),
            'descontos'             => $venda->getDescontos(),
            'condicao_pagamento_id' => $venda->getCondicaoPagamento()->getId(),
            'total_produtos'        => $venda->getTotalProdutos(),
            'total_venda'           => $venda->getTotalVenda(),
        );

        return $dados;
    }

    public function getProductsData(Venda $venda) {
        $produtos = array();

        foreach ($venda->getProdutos() as $produto) {

            $dadosProduto = array(
                'num_nota'   => $venda->getNumeroNota(),
                'serie'      => $venda->getSerie(),
                'modelo'     => $venda->getModelo(),
                'produto_id' => $produto->getProduto()->getId(),
                'quantidade' => $produto->getQuantidade(),
            );

            array_push($produtos, $dadosProduto);
        }

        return $produtos;
    }

    public function getDuplicatesData(Venda $venda) {
        $duplicatas = array();

        // dd($venda);

        foreach ($venda->getContasReceber() as $i => $duplicata) {
            $dadosDuplicata = array(
                'num_nota'           => $venda->getNumeroNota(),
                'serie'              => $venda->getSerie(),
                'modelo'             => $venda->getModelo(),
                'cliente_id'         => $venda->getCliente()->getId(),
                /*'funcionario_id'   => $venda->getFuncionario()->getId(),*/
                'forma_pagamento_id' => $duplicata->getFormaPagamento()->getId(),
                'parcela'            => $duplicata->getParcela(),
                'valor_parcela'      => $duplicata->getValorParcela(),
                'data_vencimento'    => date('Y-m-d', strtotime($duplicata->getDataVencimento())),
                'data_pagamento'     => $duplicata->getDataPagamento(),
                'desconto'           => $duplicata->getDesconto(),
                'valor_pago'         => $duplicata->getValorPago(),
            );

            array_push($duplicatas, $dadosDuplicata);
        }

        return $duplicatas;
    }
}
