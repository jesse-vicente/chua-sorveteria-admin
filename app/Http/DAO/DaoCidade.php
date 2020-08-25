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

    public function all(bool $model = false) {
        if (!$model) {
            return DB::table('cidades', 'c')
                ->join('estados as e', 'c.estado_id', '=', 'e.id')
                ->get(['c.id', 'c.cidade', 'c.ddd', 'e.estado']);
        }

        $itens = DB::table('cidades')->get();

        $cidades = array();

        foreach ($itens as $item) {
            $cidade = $this->create(get_object_vars($item));
            array_push($cidades, $cidade);
        }

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

        $estado = $this->daoEstado->findById($dados["estado_id"], true);

        $cidade->setEstado($estado);

        return $cidade;
    }

    public function store($cidade) {
        DB::beginTransaction();

        try {
            $dados = $this->getData($cidade);

            DB::table('cidades')->insert($dados);
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
            $cidade = $this->create($request->all());

            $dados = $this->getData($cidade);

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

    public function findById(int $id, bool $model = false) {
        if (!$model) {
            return DB::table('cidades', 'c')
                    ->join('estados as e', 'c.estado_id', '=', 'e.id')
                    ->get(['c.id', 'c.cidade', 'c.ddd', 'e.estado'])
                    ->where('id', $id)
                    ->first();
        }

        $dados = DB::table('cidades')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return $dados;
    }

    public function getData(Cidade $cidade) {

        $dados = [
            "id"        => $cidade->getId(),
            "cidade"    => $cidade->getCidade(),
            "ddd"       => $cidade->getDDD(),
            "estado_id" => $cidade->getEstado()->getID(),
        ];

        return $dados;
    }
}
