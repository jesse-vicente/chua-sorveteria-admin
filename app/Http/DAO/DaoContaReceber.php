<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Http\Dao\DaoCliente;
use App\Http\Dao\DaoVenda;
use App\Http\Dao\DaoFuncionario;
use App\Http\Dao\DaoFormaPagamento;

use App\Http\Models\Venda;
use App\Http\Models\ContaReceber;

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

    public function all(bool $model = false, $filtro = array()) {
        if ($filtro) {
            $chave = $filtro['chave'];
            $valor = $filtro['valor'];

            if ($valor == 'Em aberto') {
                return DB::table('contas_receber')
                         ->where($chave, $valor)
                         ->where('data_cadastro', '>=', Carbon::today()->toDateTimeString())
                         ->get()
                         ->count();
            } else if ($valor == 'Recebido') {
                return DB::table('contas_receber')
                         ->where($filtro['chave'], $filtro['valor'])
                         ->where('data_cadastro', '>=', Carbon::today()->toDateTimeString())
                         ->get()
                         ->sum('valor_parcela');
            }
        }

        $itens = DB::table('contas_receber')
                   ->orderBy('data_cadastro', 'desc')
                   ->get();

        if (!$model)
            return $itens;

        $contas = array();

        foreach ($itens as $item) {
            $conta = $this->create(get_object_vars($item));
            array_push($contas, $conta);
        }

        return $contas;
    }

    public function create(array $dados) {
        $conta = new ContaReceber();

        if (isset($dados['num_nota'])) {
            $conta->setDataCadastro($dados['data_cadastro'] ?? null);
            $conta->setDataAlteracao($dados['data_alteracao'] ?? null);
        }

        if (isset($dados['status']))
            $conta->setStatus($dados['status']);

        // Dados nota
        $cliente_id = $dados['cliente_id'] ?? null;

        $key = $dados['num_nota'] . '-' . $dados['serie'] . '-' . $dados['modelo'];

        if ($cliente_id)
            $key .= '-' . $cliente_id;

        $venda = $this->daoVenda->findByPrimaryKey($key, true);

        $conta->setVenda($venda);

        $conta->setParcela($dados['parcela']);
        $conta->setValorParcela(floatval($dados['valor_parcela']));

        $conta->setDataVencimento($dados['data_vencimento']);
        $conta->setDataPagamento($dados['data_pagamento']);

        if ($cliente_id) {
            $cliente = $this->daoCliente->findById($cliente_id, true);
            $conta->setCliente($cliente);
        }

        // $funcionario = $this->daoCliente->findById($dados['funcionario_id'], true);
        $formaPagamento = $this->daoFormaPagamento->findById($dados['forma_pagamento_id'], true);

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
            $contaReceber = $this->create($request->all());
            $venda = $contaReceber->getVenda();

            $pk = $venda->getPrimaryKey();

            DB::table('vendas')
              ->where('num_nota',   $pk->numero)
              ->where('serie',      $pk->serie)
              ->where('modelo',     $pk->modelo)
              ->where('cliente_id', $pk->cliente_id)
              ->update(['status' => $request->status == 'Recebido' ? 'Ativo' : 'Emitido']);

            $dadosContaReceber = $this->getData($contaReceber);

            if ($contaReceber->getStatus() == 'Em aberto')
                $dadosContaReceber['valor_pago'] = null;

            DB::table('contas_receber')
              ->where('num_nota',   $pk->numero)
              ->where('serie',      $pk->serie)
              ->where('modelo',     $pk->modelo)
              ->where('cliente_id', $pk->cliente_id)
              ->where('parcela',    $contaReceber->getParcela())
              ->update($dadosContaReceber);

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

        $dadosPk = count($key);

        if ($dadosPk > 5)
            return array();

        if ($dadosPk == 4) {
            $dados = DB::table('contas_receber')
                       ->where('num_nota', $key[0])
                       ->where('serie', $key[1])
                       ->where('modelo', $key[2])
                       ->where('parcela', $key[3])
                       ->first();
        } else {
            $dados = DB::table('contas_receber')
                       ->where('num_nota', $key[0])
                       ->where('serie', $key[1])
                       ->where('modelo', $key[2])
                       ->where('cliente_id', $key[3])
                       ->where('parcela', $key[4])
                       ->first();
        }

        if ($dados) {
            if ($model) {
                $conta = $this->create(get_object_vars($dados));
                return $conta;
            }

            return $dados;
        }

        return [];
    }

    public function findById(int $id, bool $model = false)
    {
        //
    }

    public function getData(ContaReceber $contaReceber) {
        $dados = array(
            'modelo'             => $contaReceber->getVenda()->getModelo(),
            'serie'              => $contaReceber->getVenda()->getSerie(),
            'num_nota'           => $contaReceber->getVenda()->getNumeroNota(),
            'status'             => $contaReceber->getStatus(),
            //'funcionario_id'   => $contaReceber->getFuncionario()->getId(),
            'forma_pagamento_id' => $contaReceber->getFormaPagamento()->getId(),
            'parcela'            => $contaReceber->getParcela(),
            'valor_parcela'      => $contaReceber->getValorParcela(),
            'data_vencimento'    => $contaReceber->getDataVencimento(),
            'data_pagamento'     => $contaReceber->getDataPagamento(),
            'valor_pago'         => $contaReceber->getValorPago(),
        );

        if ($contaReceber->getCliente())
            $dados['cliente_id'] = $contaReceber->getCliente()->getId();

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
