<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Models\Categoria;

class DaoCategoria implements Dao {

    public function all() {
        $categorias = $this->search();
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
            $dados = $this->fillData($categoria);

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

            $dados = $this->fillData($categoria);

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

    public function find(int $id) {
        $dados = DB::table('categorias')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return null;
    }

    public function search($q = null)
    {
        $categorias = array();

        if (!is_null($q)) {
            $dados = DB::table('categorias')->where('id', $q)->orWhere('categoria', 'like', '$q')->first();

            if ($dados)
                $categorias[0] = $this->create(get_object_vars($dados));

            return $categorias;
        }
        else {
            $dados = DB::table('categorias')->limit(10)->get();

            foreach ($dados as $obj) {
                $categoria = $this->create(get_object_vars($obj));
                array_push($categorias, $categoria);
            }

            return $categorias;
        }
    }

    public function fillData(Categoria $categoria) {
        $dados = [
            'id'        => $categoria->getId(),
            'categoria' => $categoria->getCategoria(),
        ];

        return $dados;
    }

    public function fillForModal(Categoria $categoria) {
        $dados = [
            'id'   => $categoria->getId(),
            'nome' => $categoria->getCategoria(),
        ];

        return $dados;
    }
}
