<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Dao\DaoFornecedor;
use App\Http\Dao\DaoCondicaoPagamento;

use App\Http\Models\Compra;

class DaoCompra implements Dao {

    private DaoFornecedor $daoFornecedor;
    private DaoCondicaoPagamento $daoCondicaoPagamento;

    public function __construct()
    {
        $this->daoFornecedor = new DaoFornecedor();
        $this->daoCondicaoPagamento = new DaoCondicaoPagamento();
    }

    public function all(bool $model = false) {
        if (!$model)
            return DB::table('compras')->get();

        $itens = DB::table('compras')->get();

        $compras = array();

        foreach ($itens as $item) {
            $compra = $this->create(get_object_vars($item));
            array_push($compras, $compra);
        }

        return $compras;
    }

    public function create(array $dados) {
        $compra = new Compra();

        if (isset($dados["id"])) {
            $compra->setId($dados["id"]);
            $compra->setDataCadastro($dados["data_cadastro"] ?? null);
            $compra->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        $fornecedor = $this->daoFornecedor->findById($dados["fornecedor_id"]);
        $condicaoPagamento = $this->daoCondicaoPagamento->findById($dados["condicao_pagamento_id"]);

        $compra->setFornecedor($fornecedor);
        $compra->setCondicaoPagamento($condicaoPagamento);

        return $compra;
    }

    public function store($compra) {
        DB::beginTransaction();

        try {
            $dados = $this->getData($compra);

            DB::table('compras')->insert($dados);
            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return false;
        }
    }

    public function update(Request $request, $id) {
        DB::beginTransaction();

        try {
            $compra = $this->create($request->all());

            $dados = $this->getData($compra);

            DB::table('compras')->where('id', $id)->update($dados);

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

    public function findById(int $id, bool $model = false) {
        if (!$model)
            return DB::table('compras')->get(['id', 'compra'])->where('id', $id)->first();

        $dados = DB::table('compras')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return $dados;
    }

    public function getData(Compra $compra) {
        // TODO ...
        $dados = [
            'id' => $compra->getId(),
        ];

        return $dados;
    }
}
