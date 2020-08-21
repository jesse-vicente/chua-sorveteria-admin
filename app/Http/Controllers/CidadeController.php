<?php

namespace App\Http\Controllers;

use App\Http\Requests\CidadeRequest;

use App\Http\Dao\DaoCidade;

class CidadeController extends Controller
{
    private DaoCidade $daoCidade;

    public function __construct()
    {
        $this->daoCidade = new DaoCidade();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cidades = $this->daoCidade->all(true);
        return view('cidades.index', compact('cidades'));
    }

    public function all()
    {
        $cidades = $this->daoCidade->all();
        return $cidades;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cidades.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CidadeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CidadeRequest $request)
    {
        $cidade = $this->daoCidade->create($request->all());

        $store = $this->daoCidade->store($cidade);

        if ($store)
            return redirect('cidades') ->with('success', 'Registro inserido com sucesso!');

        return redirect('cidades')->with('error', 'Erro ao inserir registro.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cidade = $this->daoCidade->findById($id, true);

        if ($cidade)
            return view('cidades.show', compact('cidade'));

        return redirect('cidades')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cidade = $this->daoCidade->findById($id, true);

        if ($cidade)
            return view('cidades.create', compact('cidade'));

        return redirect('cidades')->with('error', 'Registro não encontrado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CidadeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CidadeRequest $request, $id)
    {
        $update = $this->daoCidade->update($request, $id);

        if ($update)
            return redirect('cidades') ->with('success', 'Registro alterado com sucesso!');

        return redirect('cidades')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->daoCidade->delete($id);

        if ($delete)
            return redirect('cidades')->with('success', 'Registro removido com sucesso!');

        return redirect('cidades')->with('error', 'Este registro não pode ser removido.');
    }

    public function findById(int $id) {
        $cidade = $this->daoCidade->findById($id);

        return [ $cidade ];
    }
}
