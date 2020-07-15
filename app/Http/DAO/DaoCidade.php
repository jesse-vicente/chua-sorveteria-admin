<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Dao\DaoEstado;
use App\Http\Models\Cidade;

class DaoCidade implements Dao {

    private DaoEstado $daoEstado;

    public function __construct()
    {
        $this->daoEstado = new DaoEstado();
    }

    public function all() {
        $cidades = $this->search();
        return $cidades;
    }

    public function create(array $dados) {
        $cidade = new Cidade();

        if (isset($dados["id"])) {
            $cidade->setId($dados["id"]);
            $cidade->setDataCadastro($dados["data_cadastro"] ?? null);
            $cidade->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        $cidade->setCidade($dados["cidade"]);
        $cidade->setDDD($dados["ddd"]);
        $cidade->setEstado($this->daoEstado->find($dados["estado_id"]));

        return $cidade;
    }

    public function store($cidade) {
        DB::beginTransaction();

        try {
            $dados = $this->fillData($cidade);

            DB::table('cidades')->insert($dados);
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
            $cidade = $this->create($request->all());

            $dados = $this->fillData($cidade);

            DB::table('cidades')->where('id', $id)->update($dados);

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
            DB::table('cidades')->delete($id);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function find($id) {
        $dados = DB::table('cidades')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return null;
    }

    public function search($q = null)
    {
        $cidades = array();

        if (!is_null($q)) {
            $dados = DB::table('cidades')->where('id', $q)->orWhere('cidade', 'like', '$q')->first();

            if ($dados)
                $cidades[0] = $this->create(get_object_vars($dados));

            return $cidades;
        }
        else {
            $dados = DB::table('cidades')->limit(10)->get();

            foreach ($dados as $obj) {
                $cidade = $this->create(get_object_vars($obj));
                array_push($cidades, $cidade);
            }

            return $cidades;
        }
    }

    public function fillData($cidade) {
        $dados = [
            'id'        => $cidade->getId(),
            'cidade'    => $cidade->getCidade(),
            'ddd'       => $cidade->getDDD(),
            'estado_id' => $cidade->getEstado()->getID(),
        ];

        return $dados;
    }
}
