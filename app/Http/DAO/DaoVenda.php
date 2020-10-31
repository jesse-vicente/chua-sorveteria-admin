<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Dao\DaoCliente;
use App\Http\Dao\DaoProduto;
use App\Http\Dao\DaoFuncionario;
use App\Http\Dao\DaoCondicaoPagamento;

use App\Http\Models\Venda;
use App\Http\Models\ContaReceber;

use App\Http\Models\ProdutoVenda;
use Carbon\Carbon;

class DaoVenda implements Dao {

    private DaoCliente $daoCliente;
    private DaoProduto $daoProduto;
    private DaoFuncionario $daoFuncionario;
    private DaoCondicaoPagamento $daoCondicaoPagamento;

    public function __construct()
    {
        $this->daoCliente = new DaoCliente();
        $this->daoProduto = new DaoProduto();
        $this->daoFuncionario = new DaoFuncionario();
        $this->daoCondicaoPagamento = new DaoCondicaoPagamento();
    }

    public function all(bool $model = false) {
        if (!$model)
            return DB::table('vendas')->get();

        $dados = DB::table('vendas')->orderBy('data_cadastro', 'desc')->get();

        $vendas = array();

        foreach ($dados as $dado) {
            $venda = $this->create(get_object_vars($dado));
            array_push($vendas, $venda);
        }

        return $vendas;
    }

    public function create(array $dados) {
        $venda = new Venda();

        if (isset($dados["num_nota"]) && $dados["num_nota"] > 0) {
            $venda->setStatus($dados["status"]);
            $venda->setNumeroNota($dados["num_nota"]);
            $venda->setDataCadastro($dados["data_cadastro"]);
            $venda->setDataAlteracao($dados["data_alteracao"]);
            $venda->setDataCancelamento($dados["data_cancelamento"]);
        }

        // Dados nota
        $venda->setModelo($dados["modelo"]);
        $venda->setSerie($dados["serie"]);
        $venda->setDataVenda($dados["data_venda"]);

        $descontos = floatval($dados["descontos"]);

        $venda->setDescontos($descontos);

        if ($dados["cliente_id"]) {
            $cliente = $this->daoCliente->findById($dados["cliente_id"], true);
            $venda->setCliente($cliente);
        }

        // $funcionario = $this->daoCliente->findById($dados["funcionario_id"], true);
        $condicaoPagamento = $this->daoCondicaoPagamento->findById($dados["condicao_pagamento_id"], true);
        // $venda->setFuncionario($funcionario);
        $venda->setCondicaoPagamento($condicaoPagamento);

        // Produtos
        if (isset($dados["produto"])) {
            $totalProdutos = 0;
            $produtosVenda = array();

            foreach ($dados["produto"] as $i => $item) {
                $id = $dados["produto_id"][$i];
                $produtoEstoque = $this->daoProduto->findById($id, true);

                $valor = floatval($dados["produto_val"][$i]);

                $produtoVenda = new ProdutoVenda();

                $quantidade = $dados["produto_qtd"][$i];

                $produtoVenda->setQuantidade($quantidade);
                $produtoVenda->setProduto($produtoEstoque);

                array_push($produtosVenda, $produtoVenda);

                $totalProdutos += $valor * $quantidade;
            }

            $totalVenda = $totalProdutos - $descontos;

            $venda->setProdutos($produtosVenda);
            $venda->setTotalProdutos($totalProdutos);
            $venda->setTotalVenda($totalVenda);
        } else {
            $venda->setTotalProdutos(floatval($dados["total_produtos"]));
            $venda->setTotalVenda(floatval($dados["total_venda"]));
        }

        // Contas a receber
        if (isset($dados["parcela"])) {
            $contasReceber = array();

            foreach ($dados["parcela"] as $i => $item) {
                $parcelas = $condicaoPagamento->getParcelas();

                $duplicata = new ContaReceber();

                $duplicata->setVenda($venda);

                if ($venda->getCliente())
                    $duplicata->setCliente($venda->getCliente());

                // $duplicata->setFuncionario($venda->getFuncionario());
                $duplicata->setFormaPagamento($parcelas[$i]->getFormaPagamento());

                $duplicata->setParcela($parcelas[$i]->getNumero());
                $duplicata->setValorParcela(floatval($dados["valor_parcela"][$i]));

                $duplicata->setDataVencimento($dados["vencimento"][$i]);

                array_push($contasReceber, $duplicata);
            }

            $venda->setContasReceber($contasReceber);
        } else {
            // $venda->setTotalProdutos($dados["total_produtos"]);
            // $venda->setTotalVenda($dados["total_venda"]);
        }

        return $venda;
    }

    public function store($venda) {
        DB::beginTransaction();

        try {
            $dadosVenda = $this->getData($venda);

            DB::table('vendas')->insert($dadosVenda);

            $numNota = DB::getPdo()->lastInsertId();

            $venda->setNumeroNota($numNota);

            $dadosProdutos = $this->getProductsData($venda);
            $dadosContasReceber = $this->getDuplicatesData($venda);

            DB::table('produtos_venda')->insert($dadosProdutos);
            DB::table('contas_receber')->insert($dadosContasReceber);

            // Atualizar produtos em estoque
            foreach ($venda->getProdutos() as $produtoVenda) {

                $id = $produtoVenda->getProduto()->getId();

                $produtoEstoque = $this->daoProduto->findById($id, true);

                $estoque = $produtoEstoque->getEstoque();

                if ($estoque == 0) {
                    return response()->json([
                        'errors' => ['Produto indisponível no estoque!']
                    ], 422);
                }

                $estoque -= $produtoVenda->getQuantidade();

                $produtoEstoque->setEstoque($estoque);
                $produtoEstoque->setDataUltimaVenda(date('Y-m-d'));

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
            $venda = $this->findByPrimaryKey($key, true);

            if ($venda->getStatus() == "Emitido") {
                $pk = $venda->getPrimaryKey();

                DB::table('vendas')
                    ->where('num_nota', $pk->numero)
                    ->where('serie', $pk->serie)
                    ->where('modelo', $pk->modelo)
                    ->where('cliente_id', $pk->cliente_id)
                    ->update(['status' => 'Cancelado', 'data_cancelamento' => date('Y-m-d H:i:s')]);

                DB::table('contas_receber')
                    ->where('num_nota', $pk->numero)
                    ->where('serie', $pk->serie)
                    ->where('modelo', $pk->modelo)
                    ->where('cliente_id', $pk->cliente_id)
                    ->update(['status' => 'Cancelado']);

                $produtosVenda = $venda->getProdutos();

                foreach ($produtosVenda as $produtoVenda) {
                    $produto = $produtoVenda->getProduto();

                    $qtdEstoque = $produto->getEstoque();
                    $qtdVenda   = $produtoVenda->getQuantidade();

                    DB::table('produtos')->where('id',  $produto->getId())->update(['estoque' => $qtdEstoque + $qtdVenda]);
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
        $cliente_id = $key[3] ?? null;

        if (!$model) {
            return DB::table('vendas')
                     ->where('num_nota', $numero)
                     ->where('serie', $serie)
                     ->where('modelo', $modelo)
                     ->where('cliente_id', $cliente_id)
                     ->first();
        }

        $dadosVenda = DB::table('vendas')
                        ->where('num_nota', $numero)
                        ->where('serie', $serie)
                        ->where('modelo', $modelo)
                        ->where('cliente_id', $cliente_id)
                        ->first();

        if ($dadosVenda) {
            $venda = $this->create(get_object_vars($dadosVenda));

            // Buscar produtos
            $dadosProdutos =  DB::table('produtos_venda')
                                ->where('num_nota', $numero)
                                ->where('serie', $serie)
                                ->where('modelo', $modelo)
                                ->get(['produto_id', 'quantidade']);

            $produtos = array();

            foreach ($dadosProdutos as $dadosProduto) {
                $idProduto = $dadosProduto->produto_id;
                $produto = $this->daoProduto->findById($idProduto, true);

                $produtoVenda = new ProdutoVenda();

                $produtoVenda->setProduto($produto);
                $produtoVenda->setQuantidade($dadosProduto->quantidade);

                array_push($produtos, $produtoVenda);
            }

            // Buscar parcelas
            $dadosParcelas =  DB::table('contas_receber')
                                ->where('num_nota', $numero)
                                ->where('serie', $serie)
                                ->where('modelo', $modelo)
                                ->where('cliente_id', $cliente_id)
                                ->get();

            $contasReceber = array();
            $condicaoPagamento = $venda->getCondicaoPagamento();
            $parcelas = $condicaoPagamento->getParcelas();

            foreach ($dadosParcelas as $i => $dadosParcela) {
                $duplicata = new ContaReceber();

                $duplicata->setVenda($venda);

                if ($venda->getCliente())
                    $duplicata->setCliente($venda->getCliente());

                $duplicata->setParcela($dadosParcela->parcela);
                $duplicata->setValorParcela($dadosParcela->valor_parcela);
                $duplicata->setDataVencimento($dadosParcela->data_vencimento);

                $duplicata->setFormaPagamento($parcelas[$i]->getFormaPagamento());

                array_push($contasReceber, $duplicata);
            }

            $venda->setProdutos($produtos);
            $venda->setContasReceber($contasReceber);

            return $venda;
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
            'data_venda'            => $venda->getDataVenda(),
            'descontos'             => $venda->getDescontos(),
            'condicao_pagamento_id' => $venda->getCondicaoPagamento()->getId(),
            'total_produtos'        => $venda->getTotalProdutos(),
            'total_venda'           => $venda->getTotalVenda(),
        );

        if ($venda->getCliente())
            $dados['cliente_id'] = $venda->getCliente()->getId();

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
                /*'funcionario_id'   => $venda->getFuncionario()->getId(),*/
                'forma_pagamento_id' => $duplicata->getFormaPagamento()->getId(),
                'parcela'            => $duplicata->getParcela(),
                'valor_parcela'      => $duplicata->getValorParcela(),
                'data_vencimento'    => Carbon::createFromFormat('d/m/Y', $duplicata->getDataVencimento())->format('Y-m-d'),
                'data_pagamento'     => $duplicata->getDataPagamento(),
                'valor_pago'         => $duplicata->getValorPago(),
            );

            if ($venda->getCliente())
                $dadosDuplicata['cliente_id'] = $venda->getCliente()->getId();

            array_push($duplicatas, $dadosDuplicata);
        }

        return $duplicatas;
    }
}
