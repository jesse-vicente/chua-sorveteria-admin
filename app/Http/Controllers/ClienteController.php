<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;

use App\Http\Dao\DaoCliente;

class ClienteController extends Controller
{
    private DaoCliente $daoCliente;

    public function __construct()
    {
        $this->daoCliente = new DaoCliente();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = $this->daoCliente->all(true);
        return view('clientes.index', compact('clientes'));
    }

    public function all()
    {
        $clientes = $this->daoCliente->all();
        return $clientes;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ClienteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteRequest $request)
    {
        $cliente = $this->daoCliente->create($request->all());

        $store = $this->daoCliente->store($cliente);

        if ($store)
            return redirect('clientes') ->with('success', 'Registro inserido com sucesso!');

        return redirect('clientes')->with('error', 'Erro ao inserir registro.');
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = $this->daoCliente->findById($id, true);

        if ($cliente)
            return view('clientes.show', compact('cliente'));

        return redirect('clientes')->with('error', 'Registro não encontrado.');
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = $this->daoCliente->findById($id, true);

        if ($cliente)
            return view('clientes.create', compact('cliente'));

        return redirect('clientes')->with('error', 'Registro não encontrado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ClienteRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteRequest $request, $id)
    {
        $update = $this->daoCliente->update($request, $id);

        if ($update)
            return redirect('clientes') ->with('success', 'Registro alterado com sucesso!');

        return redirect('clientes')->with('error', 'Erro ao alterar registro.');
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->daoCliente->delete($id);

        if ($delete)
            return redirect('clientes')->with('success', 'Registro removido com sucesso!');

        return redirect('clientes')->with('error', 'Este registro não pode ser removido.');
    }

    public function findById(int $id) {
        $cliente = $this->daoCliente->findById($id);

        return [ $cliente ];
    }
}
