<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Models\FormaPagamento;

class DaoFormaPagamento implements Dao {

    public function all() {
        $formasPagamento = $this->search();
        return $formasPagamento;
    }

    public function create(array $dados) {
        $formaPagamento = new FormaPagamento();

        if (isset($dados["id"])) {
            $formaPagamento->setId($dados["id"]);
            $formaPagamento->setDataCadastro($dados["data_cadastro"] ?? null);
            $formaPagamento->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        $formaPagamento->setFormaPagamento($dados["forma_pagamento"]);

        return $formaPagamento;
    }

    public function store($formaPagamento) {
        DB::beginTransaction();

        try {
            $dados = $this->fillData($formaPagamento);

            DB::table('formas_pagamento')->insert($dados);
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
            $formaPagamento = $this->create($request->all());

            $dados = $this->fillData($formaPagamento);

            DB::table('formas_pagamento')->where('id', $id)->update($dados);

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
            DB::table('formas_pagamento')->delete($id);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function find($id) {
        $dados = DB::table('formas_pagamento')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return null;
    }

    public function search($q = null)
    {
        $formasPagamento = array();

        if (!is_null($q)) {
            $dados = DB::table('formas_pagamento')->where('id', $q)->orWhere('forma_pagamento', 'like', '$q')->first();

            if ($dados)
                $formasPagamento[0] = $this->create(get_object_vars($dados));
        }
        else {
            $dados = DB::table('formas_pagamento')->limit(10)->get();

            foreach ($dados as $obj) {
                $formaPagamento = $this->create(get_object_vars($obj));
                array_push($formasPagamento, $formaPagamento);
            }
        }

        return $formasPagamento;
    }

    public function fillData($formaPagamento) {
        $dados = [
            'id'              => $formaPagamento->getId(),
            'forma_pagamento' => $formaPagamento->getFormaPagamento(),
        ];

        return $dados;
    }
}
