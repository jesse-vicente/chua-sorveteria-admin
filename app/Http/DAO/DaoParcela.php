<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Models\Parcela;

class DaoParcela implements Dao {

    private DaoFormaPagamento $daoFormaPagamento;

    public function __construct()
    {
        $this->daoFormaPagamento = new DaoFormaPagamento();
    }

    public function all(bool $model = false) {
        $parcelas = DB::table('parcelas')->get();
        return $parcelas;
    }

    public function create(array $dados) {
        $parcela = new Parcela();

        if (isset($dados["id"]))
            $parcela->setId($dados["id"]);

        $parcela->setNumero($dados["numero"]);
        $parcela->setPrazo($dados["prazo"]);
        $parcela->setPorcentagem((float) $dados["porcentagem"]);

        $formaPagamento = $this->daoFormaPagamento->findById($dados["forma_pagamento_id"], true);

        $parcela->setFormaPagamento($formaPagamento);

        return $parcela;
    }

    public function store($parcela) {
        DB::beginTransaction();

        try {
            $dados = $this->getData($parcela);

            DB::table('parcelas')->insert($dados);
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
            $parcela = $this->create($request->all());

            $dados = $this->getData($parcela);

            DB::table('parcelas')->where('id', $id)->update($dados);

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
            $idCondicaoPagamento =  DB::table('parcelas')->where('id', $id)->value('condicao_pagamento_id');

            $totalParcelas = DB::table('condicoes_pagamento')->where('id', $idCondicaoPagamento)->value('total_parcelas');

            DB::table('parcelas')->delete($id);

            DB::table('condicoes_pagamento')->update(['total_parcelas' => --$totalParcelas]);

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            return false;
        }
    }

    public function findById(int $id, bool $model = false) {
        if (!$model)
            return DB::table('parcelas')->get()->where('id', $id)->first();

        $dados = DB::table('parcelas')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return $dados;
    }

    public function getData(Parcela $parcela) {

        $dados = [
            'numero'             => $parcela->getNumero(),
            'prazo'              => $parcela->getPrazo(),
            'porcentagem'        => $parcela->getPorcentagem(),
            'forma_pagamento_id' => $parcela->getFormaPagamento()->getId(),
        ];

        return $dados;
    }

    public function fillForModal(Parcela $parcela) {

        $dados = [
            'numero'          => $parcela->getNumero(),
            'prazo'           => $parcela->getPrazo(),
            'porcentagem'     => $parcela->getPorcentagem(),
            'forma_pagamento' => $parcela->getFormaPagamento()->getFormaPagamento(),
        ];

        return $dados;
    }
}
