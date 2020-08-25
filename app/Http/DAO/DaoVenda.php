<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Dao\DaoCliente;
use App\Http\Dao\DaoCondicaoPagamento;

use App\Http\Models\Venda;

class DaoVenda implements Dao {

    private DaoCliente $daoCliente;
    private DaoCondicaoPagamento $daoCondicaoPagamento;

    public function __construct()
    {
        $this->daoCliente = new DaoCliente();
        $this->daoCondicaoPagamento = new DaoCondicaoPagamento();
    }

    public function all(bool $model = false) {
        if (!$model)
            return DB::table('vendas')->get();

        $itens = DB::table('vendas')->get();

        $vendas = array();

        foreach ($itens as $item) {
            $venda = $this->create(get_object_vars($item));
            array_push($vendas, $venda);
        }

        return $vendas;
    }

    public function create(array $dados) {
        $venda = new Venda();

        if (isset($dados["id"])) {
            $venda->setId($dados["id"]);
            $venda->setDataCadastro($dados["data_cadastro"] ?? null);
            $venda->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        $fornecedor = $this->daoCliente->findById($dados["fornecedor_id"]);
        $condicaoPagamento = $this->daoCondicaoPagamento->findById($dados["condicao_pagamento_id"]);

        $venda->setCliente($fornecedor);
        $venda->setCondicaoPagamento($condicaoPagamento);

        return $venda;
    }

    public function store($venda) {
        DB::beginTransaction();

        try {
            $dados = $this->getData($venda);

            DB::table('vendas')->insert($dados);
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
            $venda = $this->create($request->all());

            $dados = $this->getData($venda);

            DB::table('vendas')->where('id', $id)->update($dados);

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

    public function findById(int $id, bool $model = false) {
        if (!$model)
            return DB::table('vendas')->get(['id', 'venda'])->where('id', $id)->first();

        $dados = DB::table('vendas')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return $dados;
    }

    public function getData(Venda $venda) {
        // TODO ...
        $dados = [
            'id' => $venda->getId(),
        ];

        return $dados;
    }
}
