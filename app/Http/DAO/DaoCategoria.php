<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Models\Categoria;

class DaoCategoria implements Dao {

    public function all(bool $model = false) {
        if (!$model)
            return DB::table('categorias')->get();

        $itens = DB::table('categorias')->get();

        $categorias = array();

        foreach ($itens as $item) {
            $categoria = $this->create(get_object_vars($item));
            array_push($categorias, $categoria);
        }

        return $categorias;
    }

    public function create(array $dados) {
        $categoria = new Categoria();

        if (isset($dados["id"])) {
            $categoria->setId($dados["id"]);

            $categoria->setDataCadastro($dados["data_cadastro"] ?? null);
            $categoria->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        $categoria->setCategoria($dados["categoria"]);

        return $categoria;
    }

    public function store($categoria) {
        DB::beginTransaction();

        try {
            $dados = $this->getData($categoria);

            DB::table('categorias')->insert($dados);
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
            $categoria = $this->create($request->all());

            $dados = $this->getData($categoria);

            DB::table('categorias')->where('id', $id)->update($dados);

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
            DB::table('categorias')->delete($id);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function findById(int $id, bool $model = false) {
        if (!$model)
            return DB::table('categorias')->get(['id', 'categoria'])->where('id', $id)->first();

        $dados = DB::table('categorias')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return $dados;
    }

    public function getData(Categoria $categoria) {
        $dados = [
            'id'        => $categoria->getId(),
            'categoria' => $categoria->getCategoria(),
        ];

        return $dados;
    }
}
