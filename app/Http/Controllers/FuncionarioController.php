<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FuncionarioRequest;

use App\Http\Dao\DaoFuncionario;

class FuncionarioController extends Controller
{
    private DaoFuncionario $daoFuncionario;

    public function __construct()
    {
        $this->daoFuncionario = new DaoFuncionario();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funcionarios = $this->daoFuncionario->all(true);
        return view('funcionarios.index', compact('funcionarios'));
    }

    public function all()
    {
        $funcionarios =$this->daoFuncionario->all();
        return $funcionarios;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('funcionarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\FuncionarioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FuncionarioRequest $request)
    {
        $funcionario = $this->daoFuncionario->create($request->all());

        $store = $this->daoFuncionario->store($funcionario);

        if ($store)
            return redirect('funcionarios') ->with('success', 'Registro inserido com sucesso!');

        return redirect('funcionarios')->with('error', 'Erro ao inserir registro.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $funcionario = $this->daoFuncionario->findById($id, true);

        if ($funcionario)
            return view('funcionarios.show', compact('funcionario'));

        return redirect('funcionarios')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $funcionario = $this->daoFuncionario->findById($id, true);

        if ($funcionario)
            return view('funcionarios.create', compact('funcionario'));

        return redirect('funcionarios')->with('error', 'Registro não encontrado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\FuncionarioRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FuncionarioRequest $request, $id)
    {
        $update = $this->daoFuncionario->update($request, $id);

        if ($update)
            return redirect('funcionarios') ->with('success', 'Registro alterado com sucesso!');

        return redirect('funcionarios')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->daoFuncionario->delete($id);

        if ($delete)
            return redirect('funcionarios')->with('success', 'Registro removido com sucesso!');

        return back()->with('error', 'Este registro não pode ser removido.');
    }

    public function findById(int $id) {
        $funcionario = $this->daoFuncionario->findById($id);

        return [ $funcionario ];
    }
}
