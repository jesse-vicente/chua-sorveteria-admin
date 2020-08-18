<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Dao\DaoPais;
use App\Http\Models\Estado;

class DaoEstado implements Dao {

    private DaoPais $daoPais;

    public function __construct()
    {
        $this->daoPais = new DaoPais();
    }

    public function all() {
        $estados = $this->search();
        return $estados;
    }

    public function create(array $dados) {
        $estado = new Estado();

        if (isset($dados["id"])) {
            $estado->setId($dados["id"]);
            $estado->setDataCadastro($dados["data_cadastro"] ?? null);
            $estado->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        $estado->setEstado($dados["estado"]);
        $estado->setUF($dados["uf"]);

        $pais = $this->daoPais->find($dados["pais_id"]);

        $estado->setPais($pais);

        return $estado;
    }

    public function store($estado) {
        DB::beginTransaction();

        try {
            $dados = $this->fillData($estado);

            DB::table('estados')->insert($dados);
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
            $estado = $this->create($request->all());

            $dados = $this->fillData($estado);

            DB::table('estados')->where('id', $id)->update($dados);

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
            DB::table('estados')->delete($id);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function find(int $id) {
        $dados = DB::table('estados')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return null;
    }

    public function search($q = null)
    {
        $estados = array();

        if (!is_null($q)) {
            $dados = DB::table('estados')->where('id', '=', $q)->orWhere('estado', 'like', '$q')->first();

            if ($dados)
                $estados[0] = $this->create(get_object_vars($dados));
        }
        else {
            $dados = DB::table('estados')->limit(10)->get();

            foreach ($dados as $obj) {
                $estado = $this->create(get_object_vars($obj));
                array_push($estados, $estado);
            }
        }

        return $estados;
    }

    public function fillData(Estado $estado) {
        $dados = [
            'id'      => $estado->getId(),
            'estado'  => $estado->getEstado(),
            'uf'      => $estado->getUF(),
            'pais_id' => $estado->getPais()->getID(),
        ];

        return $dados;
    }

    public function fillForModal(Estado $estado) {
        $dados = [
            'id'      => $estado->getId(),
            'nome'    => $estado->getEstado(),
            'uf'      => $estado->getUF(),
            'pais'    => $estado->getPais()->getPais(),
        ];

        return $dados;
    }
}
