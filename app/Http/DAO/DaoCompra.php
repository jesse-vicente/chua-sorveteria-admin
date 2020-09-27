<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Dao\DaoFornecedor;
use App\Http\Dao\DaoProduto;
use App\Http\Dao\DaoFuncionario;
use App\Http\Dao\DaoCondicaoPagamento;

use App\Http\Models\Compra;
use App\Http\Models\ContaPagar;

use App\Http\Models\ProdutoCompra;
use Carbon\Carbon;

class DaoCompra implements Dao {

    private DaoFornecedor $daoFornecedor;
    private DaoProduto $daoProduto;
    private DaoFuncionario $daoFuncionario;
    private DaoCondicaoPagamento $daoCondicaoPagamento;

    public function __construct()
    {
        $this->daoFornecedor = new DaoFornecedor();
        $this->daoProduto = new DaoProduto();
        $this->daoFuncionario = new DaoFuncionario();
        $this->daoCondicaoPagamento = new DaoCondicaoPagamento();
    }

    public function all(bool $model = false) {
        if (!$model)
            return DB::table('compras')->get();

        $dados = DB::table('compras')->orderBy('data_emissao', 'desc')->get();

        $compras = array();

        foreach ($dados as $dado) {
            $compra = $this->create(get_object_vars($dado));
            array_push($compras, $compra);
        }

        return $compras;
    }

    public function create(array $dados) {
        $compra = new Compra();

        if (isset($dados["data_cadastro"]) && isset($dados["data_alteracao"])) {
            $compra->setStatus($dados["status"]);
            $compra->setDataCadastro($dados["data_cadastro"]);
            $compra->setDataAlteracao($dados["data_alteracao"]);
            $compra->setDataCancelamento($dados["data_cancelamento"]);
        }

        // Dados nota
        $compra->setModelo($dados["modelo"]);
        $compra->setSerie($dados["serie"]);
        $compra->setNumeroNota($dados["num_nota"]);
        $compra->setDataEmissao($dados["data_emissao"]);
        $compra->setDataChegada($dados["data_chegada"]);

        $frete    = floatval($dados["frete"]);
        $seguro   = floatval($dados["seguro"]);
        $despesas = floatval($dados["despesas"]);

        $compra->setFrete($frete);
        $compra->setSeguro($seguro);
        $compra->setDespesas($despesas);

        $fornecedor = $this->daoFornecedor->findById($dados["fornecedor_id"], true);
        // $funcionario = $this->daoFornecedor->findById($dados["funcionario_id"], true);
        $condicaoPagamento = $this->daoCondicaoPagamento->findById($dados["condicao_pagamento_id"], true);

        $compra->setFornecedor($fornecedor);
        // $compra->setFuncionario($funcionario);
        $compra->setCondicaoPagamento($condicaoPagamento);

        // Produtos
        if (isset($dados["produto"])) {
            $totalProdutos = 0;
            $produtosCompra = array();

            foreach ($dados["produto"] as $i => $item) {
                $id = $dados["produto_id"][$i];
                $produtoEstoque = $this->daoProduto->findById($id, true);

                $valor = floatval($dados["produto_val"][$i]);

                $produtoEstoque->setPrecoCusto(($valor));

                $produtoCompra = new ProdutoCompra();

                $quantidade = $dados["produto_qtd"][$i];

                $produtoCompra->setQuantidade($quantidade);
                $produtoCompra->setProduto($produtoEstoque);

                array_push($produtosCompra, $produtoCompra);

                $totalProdutos += $valor * $quantidade;
            }

            $totalCompra = $totalProdutos + $frete + $seguro + $despesas;

            $compra->setProdutos($produtosCompra);
            $compra->setTotalProdutos($totalProdutos);
            $compra->setTotalCompra($totalCompra);
        } else {
            $compra->setTotalProdutos(floatval($dados["total_produtos"]));
            $compra->setTotalCompra(floatval($dados["total_compra"]));
        }

        // Contas a pagar
        if (isset($dados["parcela"])) {
            $contasPagar = array();

            foreach ($dados["parcela"] as $i => $item) {
                $parcelas = $condicaoPagamento->getParcelas();

                $duplicata = new ContaPagar();

                $duplicata->setCompra($compra);
                $duplicata->setFornecedor($compra->getFornecedor());
                // $duplicata->setFuncionario($compra->getFuncionario());
                $duplicata->setFormaPagamento($parcelas[$i]->getFormaPagamento());

                $duplicata->setParcela($parcelas[$i]->getNumero());
                $duplicata->setValorParcela(floatval($dados["valor_parcela"][$i]));

                $duplicata->setDataVencimento($dados["vencimento"][$i]);

                $duplicata->setJuros($condicaoPagamento->getJuros());
                $duplicata->setMulta($condicaoPagamento->getMulta());
                $duplicata->setDesconto($condicaoPagamento->getDesconto());

                array_push($contasPagar, $duplicata);
            }

            $compra->setContasPagar($contasPagar);
        } else {
            // $compra->setTotalProdutos($dados["total_produtos"]);
            // $compra->setTotalCompra($dados["total_compra"]);
        }

        // dd($compra);

        return $compra;
    }

    public function store($compra) {
        DB::beginTransaction();

        try {
            $dadosCompra   = $this->getData($compra);
            $dadosProdutos = $this->getProductsData($compra);
            $dadosContasPagar = $this->getDuplicatesData($compra);

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

            return response()->json([
                'success' => true,
                'message' => 'Registro inserido com sucesso!'
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return false;
        }
    }

    public function update(Request $request, $key) {
        DB::beginTransaction();

        try {
            $compra = $this->findByPrimaryKey($key, true);

            if ($compra->getStatus() != "Cancelado") {
                $numero = $compra->getNumeroNota();
                $serie  = $compra->getSerie();
                $modelo = $compra->getModelo();
                $idFornecedor = $compra->getFornecedor()->getId();

                DB::table('compras')
                    ->where('num_nota', $numero)
                    ->where('serie', $serie)
                    ->where('modelo', $modelo)
                    ->where('fornecedor_id', $idFornecedor)
                    ->update(['status' => 'Cancelado']);

                DB::table('contas_pagar')
                    ->where('num_nota', $numero)
                    ->where('serie', $serie)
                    ->where('modelo', $modelo)
                    ->where('fornecedor_id', $idFornecedor)
                    ->update(['status' => 'Cancelado']);

                $produtosCompra = $compra->getProdutos();

                foreach ($produtosCompra as $produtoCompra) {
                    $produto = $produtoCompra->getProduto();

                    $qtdEstoque = $produto->getEstoque();
                    $qtdCompra  = $produtoCompra->getQuantidade();

                    DB::table('produtos')->where('id',  $produto->getId())->update(['estoque' => $qtdEstoque - $qtdCompra]);
                }

                DB::commit();

                return true;
            }

            return false;
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
            $dados = DB::table('compras')
                       ->where('num_nota', $numero)
                       ->where('serie', $serie)
                       ->where('modelo', $modelo)
                       ->where('fornecedor_id', $idFornecedor)
                       ->first();

            return $dados;
        }

        $dadosCompra = DB::table('compras')
                         ->where('num_nota', $numero)
                         ->where('serie', $serie)
                         ->where('modelo', $modelo)
                         ->where('fornecedor_id', $idFornecedor)
                         ->first();

        if ($dadosCompra) {
            $compra = $this->create(get_object_vars($dadosCompra));

            // Buscar produtos
            $dadosProdutos =  DB::table('produtos_compra')
                                ->where('num_nota', $numero)
                                ->where('serie', $serie)
                                ->where('modelo', $modelo)
                                ->get(['produto_id', 'quantidade']);

            $produtos = array();

            foreach ($dadosProdutos as $dadosProduto) {
                $idProduto = $dadosProduto->produto_id;
                $produto = $this->daoProduto->findById($idProduto, true);

                $produtoCompra = new ProdutoCompra();

                $produtoCompra->setProduto($produto);
                $produtoCompra->setQuantidade($dadosProduto->quantidade);

                array_push($produtos, $produtoCompra);
            }

            // Buscar parcelas
            $dadosParcelas =  DB::table('contas_pagar')
                                ->where('num_nota', $numero)
                                ->where('serie', $serie)
                                ->where('modelo', $modelo)
                                ->where('fornecedor_id', $idFornecedor)
                                ->get(['data_vencimento', 'valor_parcela']);

            $contasPagar = array();
            $condicaoPagamento = $compra->getCondicaoPagamento();
            $parcelas = $condicaoPagamento->getParcelas();

            foreach ($dadosParcelas as $i => $dadosParcela) {
                $duplicata = new ContaPagar();
                $duplicata->setCompra($compra);
                $duplicata->setFornecedor($compra->getFornecedor());

                $duplicata->setFormaPagamento($parcelas[$i]->getFormaPagamento());

                $duplicata->setParcela($parcelas[$i]->getNumero());
                $duplicata->setDataVencimento($dadosParcela->data_vencimento);
                $duplicata->setValorParcela($dadosParcela->valor_parcela);

                $duplicata->setJuros($condicaoPagamento->getJuros());
                $duplicata->setMulta($condicaoPagamento->getMulta());
                $duplicata->setDesconto($condicaoPagamento->getDesconto());

                array_push($contasPagar, $duplicata);
            }

            $compra->setProdutos($produtos);
            $compra->setContasPagar($contasPagar);

            return $compra;
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
                'data_vencimento'    => Carbon::createFromFormat('d/m/Y', $duplicata->getDataVencimento())->format('Y-m-d'),
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
