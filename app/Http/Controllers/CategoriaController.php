<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;

use App\Http\Dao\DaoCategoria;

class CategoriaController extends Controller
{
    private DaoCategoria $daoCategoria;

    public function __construct()
    {
        $this->daoCategoria = new DaoCategoria();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = $this->daoCategoria->all(true);
        return view('categorias.index', compact('categorias'));
    }

    public function all()
    {
        return $this->daoCategoria->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CategoriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaRequest $request)
    {
        $categoria = $this->daoCategoria->create($request->all());

        $store = $this->daoCategoria->store($categoria);

        if ($store)
            return redirect('categorias') ->with('success', 'Registro inserido com sucesso!');

        return redirect('categorias')->with('error', 'Erro ao inserir registro.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = $this->daoCategoria->findById($id, true);

        if ($categoria)
            return view('categorias.show', compact('categoria'));

        return redirect('categorias')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = $this->daoCategoria->findById($id, true);

        if ($categoria)
            return view('categorias.create', compact('categoria'));

        return redirect('categorias')->with('error', 'Registro não encontrado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CategoriaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaRequest $request, $id)
    {
        $update = $this->daoCategoria->update($request, $id);

        if ($update)
            return redirect('categorias') ->with('success', 'Registro alterado com sucesso!');

        return redirect('categorias')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->daoCategoria->delete($id);

        if ($delete)
            return redirect('categorias')->with('success', 'Registro removido com sucesso!');

        return redirect('categorias')->with('error', 'Este registro não pode ser removido.');
    }

    public function findById(int $id) {
        $categoria = $this->daoCategoria->findById($id);

        return [ $categoria ];
    }
}
