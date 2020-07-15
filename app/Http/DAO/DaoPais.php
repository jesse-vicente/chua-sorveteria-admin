<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

use App\Http\Models\Pais;

class DaoPais implements Dao {

    public function all() {
        $paises = $this->search();
        return $paises;
    }

    public function create(array $dados) {
        $pais = new Pais();

        if (isset($dados["id"])) {
            $pais->setId($dados["id"]);
            $pais->setDataCadastro($dados["data_cadastro"] ?? null);
            $pais->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        $pais->setPais($dados["pais"]);
        $pais->setSigla($dados["sigla"]);
        $pais->setDDI($dados["ddi"]);

        return $pais;
    }

    public function store($pais) {
        DB::beginTransaction();

        try {
            $dados = $this->fillData($pais);

            DB::table('paises')->insert($dados);
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
            $pais = $this->create($request->all());

            $dados = $this->fillData($pais);

            DB::table('paises')->where('id', $id)->update($dados);

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
            DB::table('paises')->delete($id);
            DB::commit();
            return true;
        } catch (QueryException $e) {
            DB::rollBack();
            return false;
        }
    }

    public function find($id) {
        $dados = DB::table('paises')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return null;
    }

    public function search($q = null)
    {
        $paises = array();

        if (!is_null($q)) {
            $dados = DB::table('paises')->where('id', $q)->orWhere('pais', 'like', '$q')->first();

            if ($dados)
                $paises[0] = $this->create(get_object_vars($dados));
        }
        else {
            $dados = DB::table('paises')->limit(10)->get();

            foreach ($dados as $obj) {
                $pais = $this->create(get_object_vars($obj));
                array_push($paises, $pais);
            }
        }

        return $paises;
    }

    public function fillData($pais) {
        $dados = [
            'id'             => $pais->getId(),
            'pais'           => $pais->getPais(),
            'sigla'          => $pais->getSigla(),
            'ddi'            => $pais->getDDI(),
        ];

        return $dados;
    }
}
