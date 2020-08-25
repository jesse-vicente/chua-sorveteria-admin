<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Models\FormaPagamento;

class DaoFormaPagamento implements Dao {

    public function all(bool $model = false) {
        if (!$model)
            return DB::table('formas_pagamento')->get();

        $itens = DB::table('formas_pagamento')->get();

        $formasPagamento = array();

        foreach ($itens as $item) {
            $formaPagamento = $this->create(get_object_vars($item));
            array_push($formasPagamento, $formaPagamento);
        }

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
            $dados = $this->getData($formaPagamento);

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

            $dados = $this->getData($formaPagamento);

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

    public function findById(int $id, bool $model = false) {
        if (!$model)
            return DB::table('formas_pagamento')->get()->where('id', $id)->first();

        $dados = DB::table('formas_pagamento')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return $dados;
    }

    public function getData($formaPagamento) {
        $dados = [
            'id'              => $formaPagamento->getId(),
            'forma_pagamento' => $formaPagamento->getFormaPagamento(),
        ];

        return $dados;
    }
}
