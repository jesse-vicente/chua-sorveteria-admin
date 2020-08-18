<?php

namespace App\Http\Dao;

use Illuminate\Http\Request;

interface Dao {

    public function all();

    public function create(array $dados);

    public function store($obj);

    public function update(Request $request, $obj);

    public function delete($id);

    public function find(int $id);

    public function search(string $q = null);

}
