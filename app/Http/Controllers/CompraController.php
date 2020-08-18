<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CompraRequest;

use App\Http\Dao\DaoCompra;

class CompraController extends Controller
{
    private DaoCompra $daoCompra;

    public function __construct()
    {
        $this->daoCompra = new DaoCompra();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compras = $this->daoCompra->all();
        return view('compras.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('compras.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CompraRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompraRequest $request)
    {
        $compra = $this->daoCompra->create($request->all());

        $store = $this->daoCompra->store($compra);

        if ($store)
            return redirect('compras') ->with('success', 'Registro inserido com sucesso!');

        return redirect('compras')->with('error', 'Erro ao inserir registro.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $compra = $this->daoCompra->find($id);
        return view('compras.show', compact('compra'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $compra = $this->daoCompra->find($id);
        return view('compras.create', compact('compra'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CompraRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompraRequest $request, $id)
    {
        $update = $this->daoCompra->update($request, $id);

        if ($update)
            return redirect('compras') ->with('success', 'Registro alterado com sucesso!');

        return redirect('compras')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->daoCompra->delete($id);

        if ($delete)
            return redirect('compras')->with('success', 'Registro removido com sucesso!');

        return redirect('compras')->with('error', 'Este registro não pode ser removido.');
    }

    /**
     * Search for the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $q = $request->q;

        $compras = $this->daoCompra->search($q);

        return view('compras.search', compact('compras'));
    }
}
