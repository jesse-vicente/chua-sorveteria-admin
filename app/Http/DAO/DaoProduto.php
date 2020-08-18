<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Models\Produto;

use App\Http\Dao\DaoCategoria;
use App\Http\Dao\DaoFornecedor;

class DaoProduto implements Dao {

    private DaoCategoria  $daoCategoria;
    private DaoFornecedor $daoFornecedor;

    public function __construct()
    {
        $this->daoCategoria  = new DaoCategoria();
        $this->daoFornecedor = new DaoFornecedor();
    }

    public function all() {
        $produtos = $this->search();
        return $produtos;
    }

    public function create(array $dados) {
        $produto = new Produto();

        if (isset($dados["id"])) {
            $produto->setId($dados["id"]);
            $produto->setDataCadastro($dados["data_cadastro"] ?? null);
            $produto->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        $produto->setProduto($dados["produto"]);
        $produto->setUnidade($dados["unidade"]);
        $produto->setEstoque($dados["estoque"]);
        $produto->setPrecoCusto($dados["preco_custo"]);
        $produto->setPrecoVenda($dados["preco_venda"]);
        $produto->setCustoUltimaCompra($dados["custo_ultima_compra"]);
        $produto->setDataUltimaCompra($dados["data_ultima_compra"]);
        $produto->setDataUltimaVenda($dados["data_ultima_venda"]);

        $categoria  = $this->daoCategoria->find($dados["categoria_id"]);
        $fornecedor = $this->daoFornecedor->find($dados["fornecedor_id"]);

        $produto->setCategoria($categoria);
        $produto->setFornecedor($fornecedor);

        return $produto;
    }

    public function store($produto) {
        DB::beginTransaction();

        try {
            $dados = $this->fillData($produto);

            DB::table('produtos')->insert($dados);
            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function update(Request $request, $id) {
        DB::beginTransaction();

        try {
            $produto = $this->create($request->all());

            $dados = $this->fillData($produto);

            DB::table('produtos')->where('id', $id)->update($dados);

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function delete($id) {
        DB::beginTransaction();

        try {
            DB::table('produtos')->delete($id);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function find(int $id) {
        $dados = DB::table('produtos')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return null;
    }

    public function search($q = null)
    {
        $produtos = array();

        if (!is_null($q)) {
            $dados = DB::table('produtos')->where('id', '=', $q)->orWhere('produto', 'like', '$q')->first();

            if ($dados)
                $produtos[0] = $this->create(get_object_vars($dados));
        }
        else {
            $dados = DB::table('produtos')->limit(10)->get();

            foreach ($dados as $obj) {
                $produto = $this->create(get_object_vars($obj));
                array_push($produtos, $produto);
            }
        }

        return $produtos;
    }

    public function fillData(Produto $produto) {

        $dados = [
            'id'                  => $produto->getId(),
            'produto'             => $produto->getProduto(),
            'categoria_id'        => $produto->getCategoria()->getId(),
            'fornecedor_id'       => $produto->getFornecedor()->getId(),
            'unidade'             => $produto->getUnidade(),
            'estoque'             => $produto->getEstoque(),
            'preco_custo'         => $produto->getPrecoCusto(),
            'preco_venda'         => $produto->getPrecoVenda(),
            'custo_ultima_compra' => $produto->getCustoUltimaCompra(),
            'data_ultima_compra'  => $produto->getDataUltimaCompra(),
            'data_ultima_venda'   => $produto->getDataUltimaVenda(),
        ];

        return $dados;
    }

    public function fillForModal(Produto $produto) {

        $dados = [
            'id'          => $produto->getId(),
            'nome'        => $produto->getProduto(),
            'unidade'     => $produto->getUnidade(),
            'categoria'   => $produto->getCategoria()->getCategoria(),
            'preco_custo' => $produto->getPrecoCusto() ?? '-',
            'fornecedor'  => $produto->getFornecedor()->getRazaoSocial(),
        ];

        return $dados;
    }
}
