<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Dao\DaoCategoria;
use App\Http\Dao\DaoFornecedor;

use App\Http\Models\Produto;

class DaoProduto implements Dao {

    private DaoCategoria  $daoCategoria;
    private DaoFornecedor $daoFornecedor;

    public function __construct()
    {
        $this->daoCategoria  = new DaoCategoria();
        $this->daoFornecedor = new DaoFornecedor();
    }

    public function all(bool $model = false, string $action = '') {
        if (!$model) {
            $itens = DB::table('produtos', 'p')
                       ->join('categorias as c', 'p.categoria_id', '=', 'c.id')
                       ->join('fornecedores as f', 'p.fornecedor_id', '=', 'f.id')
                       ->get([
                           'p.id',
                           'p.produto',
                           'p.unidade',
                           'c.categoria',
                           'f.fornecedor',
                           $action == 'compra' ? 'p.preco_custo' : 'p.preco_venda',
                           'p.estoque'
                        ]);

            foreach ($itens as $item) {
                if ($item->estoque == round($item->estoque))
                    $item->estoque = intval($item->estoque);
            }

            return $itens;
        }

        $itens = DB::table('produtos')->get();

        $produtos = array();

        foreach ($itens as $item) {
            $produto = $this->create(get_object_vars($item));
            array_push($produtos, $produto);
        }

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

        $categoria  = $this->daoCategoria->findById($dados["categoria_id"], true);
        $fornecedor = $this->daoFornecedor->findById($dados["fornecedor_id"], true);

        $produto->setCategoria($categoria);
        $produto->setFornecedor($fornecedor);

        return $produto;
    }

    public function store($produto) {
        DB::beginTransaction();

        try {
            $dados = $this->getData($produto);

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

            $dados = $this->getData($produto);

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

    public function findById(int $id, bool $model = false, string $action = '') {
        if (!$model) {
            if ($action == 'compra') {
                $item = DB::table('produtos', 'p')
                          ->join('categorias as c', 'p.categoria_id', '=', 'c.id')
                          ->join('fornecedores as f', 'p.fornecedor_id', '=', 'f.id')
                          ->get(['p.id', 'p.produto', 'p.unidade', 'c.categoria', 'f.fornecedor', 'p.preco_custo'])
                          ->where('id', $id)
                          ->first();
            } else {
                $item = DB::table('produtos', 'p')
                          ->join('categorias as c', 'p.categoria_id', '=', 'c.id')
                          ->join('fornecedores as f', 'p.fornecedor_id', '=', 'f.id')
                          ->get(['p.id', 'p.produto', 'p.unidade', 'c.categoria', 'f.fornecedor', 'p.preco_venda', 'p.estoque'])
                          ->where('id', $id)
                          ->first();

                if ($item->estoque == round($item->estoque))
                    $item->estoque = intval($item->estoque);
            }

            return $item;
        }

        $item = DB::table('produtos')->where('id', $id)->first();

        if ($item)
            return $this->create(get_object_vars($item));

        return $item;
    }

    public function getData(Produto $produto) {

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
}
