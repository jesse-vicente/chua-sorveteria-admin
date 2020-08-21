<?php

namespace App\Http\Dao;

use Illuminate\Http\Request;

interface Dao {

    public function all(bool $model = false);

    public function create(array $dados);

    public function store($obj);

    public function update(Request $request, $obj);

    public function delete($id);

    public function findById(int $id, bool $model = false);

}
