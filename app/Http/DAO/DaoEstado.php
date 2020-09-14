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

    public function all(bool $model = false) {
        if (!$model) {
            return DB::table('estados', 'e')
                ->join('paises as p', 'e.pais_id', '=', 'p.id')
                ->get(['e.id', 'e.estado', 'e.uf', 'p.pais']);
        }

        $itens = DB::table('estados')->get();

        $estados = array();

        foreach ($itens as $item) {
            $estado = $this->create(get_object_vars($item));
            array_push($estados, $estado);
        }

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

        $pais = $this->daoPais->findById($dados["pais_id"], true);

        $estado->setPais($pais);

        return $estado;
    }

    public function store($estado) {
        DB::beginTransaction();

        try {
            $dados = $this->getData($estado);

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

            $dados = $this->getData($estado);

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

    public function findById(int $id, bool $model = false) {
        if (!$model) {
            return DB::table('estados', 'e')
                    ->join('paises as p', 'e.pais_id', '=', 'p.id')
                    ->get(['e.id', 'e.estado', 'e.uf', 'p.pais'])
                    ->where('id', $id)
                    ->first();
        }

        $dados = DB::table('estados')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return $dados;
    }

    public function getData(Estado $estado) {
        $dados = [
            'id'      => $estado->getId(),
            'estado'  => $estado->getEstado(),
            'uf'      => $estado->getUF(),
            'pais_id' => $estado->getPais()->getID(),
        ];

        return $dados;
    }
}
