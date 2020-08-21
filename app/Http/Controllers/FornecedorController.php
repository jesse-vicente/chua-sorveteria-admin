<?php

namespace App\Http\Controllers;

use App\Http\Requests\FornecedorRequest;

use App\Http\Dao\DaoFornecedor;

class FornecedorController extends Controller
{
    private DaoFornecedor $daoFornecedor;

    public function __construct()
    {
        $this->daoFornecedor = new DaoFornecedor();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fornecedores = $this->daoFornecedor->all(true);
        return view('fornecedores.index', compact('fornecedores'));
    }

    public function all()
    {
        $fornecedores = $this->daoFornecedor->all();
        return $fornecedores;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fornecedores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\FornecedorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FornecedorRequest $request)
    {
        $fornecedor = $this->daoFornecedor->create($request->all());

        $store = $this->daoFornecedor->store($fornecedor);

        if ($store)
            return redirect('fornecedores') ->with('success', 'Registro inserido com sucesso!');

        return redirect('fornecedores')->with('error', 'Erro ao inserir registro.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fornecedor = $this->daoFornecedor->findById($id, true);

        if ($fornecedor)
            return view('fornecedores.show', compact('fornecedor'));

        return redirect('fornecedores')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fornecedor = $this->daoFornecedor->findById($id, true);

        if ($fornecedor)
            return view('fornecedores.create', compact('fornecedor'));

        return redirect('fornecedores')->with('error', 'Registro não encontrado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\FornecedorRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FornecedorRequest $request, $id)
    {
        $update = $this->daoFornecedor->update($request, $id);

        if ($update)
            return redirect('fornecedores') ->with('success', 'Registro alterado com sucesso!');

        return redirect('fornecedores')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->daoFornecedor->delete($id);

        if ($delete)
            return redirect('fornecedores')->with('success', 'Registro removido com sucesso!');

        return back()->with('error', 'Este registro não pode ser removido.');
    }

    public function findById(int $id) {
        $fornecedor = $this->daoFornecedor->findById($id);

        return [ $fornecedor ];
    }
}
