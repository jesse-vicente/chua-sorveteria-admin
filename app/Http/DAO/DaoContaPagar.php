<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Dao\DaoFornecedor;
use App\Http\Dao\DaoCompra;
use App\Http\Dao\DaoFuncionario;
use App\Http\Dao\DaoFormaPagamento;

use App\Http\Models\Compra;
use App\Http\Models\ContaPagar;

use App\Http\Models\ProdutoCompra;

class DaoContaPagar implements Dao {

    private DaoFornecedor $daoFornecedor;
    private DaoCompra $daoCompra;
    private DaoFuncionario $daoFuncionario;
    private DaoFormaPagamento $daoFormaPagamento;

    public function __construct()
    {
        $this->daoCompra = new DaoCompra();
        $this->daoFornecedor = new DaoFornecedor();
        $this->daoFuncionario = new DaoFuncionario();
        $this->daoFormaPagamento = new DaoFormaPagamento();
    }

    public function all(bool $model = false) {
        if (!$model)
            return DB::table('contas_pagar')->get();

        $dados = DB::table('contas_pagar')->get();

        $contas = array();

        foreach ($dados as $dado) {
            $conta = $this->create(get_object_vars($dado));
            array_push($contas, $conta);
        }

        return $contas;
    }

    public function create(array $dados) {
        $conta = new ContaPagar();

        if (isset($dados["num_nota"])) {
            $conta->setDataCadastro($dados["data_cadastro"] ?? null);
            $conta->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        if (isset($dados["status"]))
            $conta->setStatus($dados["status"]);

        // Dados nota
        $key = $dados["num_nota"] . "-" . $dados["serie"] . "-" . $dados["modelo"] . "-" . $dados["fornecedor_id"];

        $compra = $this->daoCompra->findByPrimaryKey($key, true);

        $conta->setCompra($compra);

        $conta->setParcela($dados["parcela"]);
        $conta->setValorParcela(floatval($dados["valor_parcela"]));

        $conta->setDataVencimento($dados["data_vencimento"]);
        $conta->setDataPagamento($dados["data_pagamento"]);

        $conta->setJuros(floatval($dados["juros"]));
        $conta->setMulta(floatval($dados["multa"]));
        $conta->setDesconto(floatval($dados["desconto"]));

        $fornecedor = $this->daoFornecedor->findById($dados["fornecedor_id"], true);
        // $funcionario = $this->daoFornecedor->findById($dados["funcionario_id"], true);
        $formaPagamento = $this->daoFormaPagamento->findById($dados["forma_pagamento_id"], true);

        $conta->setFornecedor($fornecedor);
        // $conta->setFuncionario($funcionario);
        $conta->setFormaPagamento($formaPagamento);

        return $conta;
    }

    public function store($compra) {
        DB::beginTransaction();

        try {
            $dadosCompra   = $this->getData($compra);
            $dadosProdutos = $this->getProductsData($compra);
            $dadosContasPagar = $this->getDuplicatesData($compra);

            // dd($dadosProdutos);

            DB::table('compras')->insert($dadosCompra);
            DB::table('produtos_compra')->insert($dadosProdutos);
            DB::table('contas_pagar')->insert($dadosContasPagar);

            // Atualizar produtos em estoque
            foreach ($compra->getProdutos() as $produtoCompra) {

                $id = $produtoCompra->getProduto()->getId();

                $produtoEstoque = $this->daoProduto->findById($id, true);

                $estoque    = $produtoEstoque->getEstoque();
                $precoCusto = $produtoCompra->getProduto()->getPrecoCusto();

                ($estoque != 0)
                    ? $estoque += $produtoCompra->getQuantidade()
                    : $estoque  = $produtoCompra->getQuantidade();

                $produtoEstoque->setEstoque($estoque);
                $produtoEstoque->setPrecoCusto($precoCusto);

                $produtoEstoque->setCustoUltimaCompra($precoCusto);
                $produtoEstoque->setDataUltimaCompra(date('Y-m-d'));

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
            $contaPagar = $this->findByPrimaryKey($key, true);
            $compra = $contaPagar->getCompra();

            // $numero = $compra->getNumeroNota();
            // $serie  = $compra->getSerie();
            // $modelo = $compra->getModelo();

            // DB::table('compras')
            //     ->where('num_nota', $numero)
            //     ->where('serie', $serie)
            //     ->where('modelo', $modelo)
            //     ->where('fornecedor_id', $compra->getFornecedor()->getId())
            //     ->update(['status' => 'Cancelado']);

            DB::table('contas_pagar')
                ->where('num_nota', $compra->getNumeroNota())
                ->where('serie', $compra->getSerie())
                ->where('modelo', $compra->getModelo())
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
            DB::table('compras')->delete($id);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function findByPrimaryKey(string $pk, bool $model = false) {
        $key = explode('-', $pk);

        $numero       = $key[0];
        $serie        = $key[1];
        $modelo       = $key[2];
        $idFornecedor = $key[3];

        if (!$model) {
            $dados = DB::table('contas_pagar')
                       ->where('num_nota', $numero)
                       ->where('serie', $serie)
                       ->where('modelo', $modelo)
                       ->where('fornecedor_id', $idFornecedor)
                       ->first();

            return $dados;
        }

        $dados = DB::table('contas_pagar')
                         ->where('num_nota', $numero)
                         ->where('serie', $serie)
                         ->where('modelo', $modelo)
                         ->where('fornecedor_id', $idFornecedor)
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

    public function getData(Compra $compra) {
        $dados = array(
            'modelo'                => $compra->getModelo(),
            'serie'                 => $compra->getSerie(),
            'num_nota'              => $compra->getNumeroNota(),
            'data_emissao'          => $compra->getDataEmissao(),
            'data_chegada'          => $compra->getDataChegada(),
            'fornecedor_id'         => $compra->getFornecedor()->getId(),
            'frete'                 => $compra->getFrete(),
            'seguro'                => $compra->getSeguro(),
            'despesas'              => $compra->getDespesas(),
            'descontos'             => $compra->getDescontos(),
            'condicao_pagamento_id' => $compra->getCondicaoPagamento()->getId(),
            'total_produtos'        => $compra->getTotalProdutos(),
            'total_compra'          => $compra->getTotalCompra(),
        );

        return $dados;
    }

    public function getProductsData(Compra $compra) {
        $produtos = array();

        foreach ($compra->getProdutos() as $produto) {

            $dadosProduto = array(
                'num_nota'   => $compra->getNumeroNota(),
                'serie'      => $compra->getSerie(),
                'modelo'     => $compra->getModelo(),
                'produto_id' => $produto->getProduto()->getId(),
                'quantidade' => $produto->getQuantidade(),
            );

            array_push($produtos, $dadosProduto);
        }

        return $produtos;
    }

    public function getDuplicatesData(Compra $compra) {
        $duplicatas = array();

        // dd($compra);

        foreach ($compra->getContasPagar() as $i => $duplicata) {
            $dadosDuplicata = array(
                'num_nota'           => $compra->getNumeroNota(),
                'serie'              => $compra->getSerie(),
                'modelo'             => $compra->getModelo(),
                'fornecedor_id'      => $compra->getFornecedor()->getId(),
                /*'funcionario_id'   => $compra->getFuncionario()->getId(),*/
                'forma_pagamento_id' => $duplicata->getFormaPagamento()->getId(),
                'parcela'            => $duplicata->getParcela(),
                'valor_parcela'      => $duplicata->getValorParcela(),
                'data_vencimento'    => date('Y-m-d', strtotime($duplicata->getDataVencimento())),
                'data_pagamento'     => $duplicata->getDataPagamento(),
                'juros'              => $duplicata->getJuros(),
                'multa'              => $duplicata->getMulta(),
                'desconto'           => $duplicata->getDesconto(),
                'valor_pago'         => $duplicata->getValorPago(),
            );

            array_push($duplicatas, $dadosDuplicata);
        }

        return $duplicatas;
    }
}
