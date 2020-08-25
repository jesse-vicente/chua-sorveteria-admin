<?php

namespace App\Http\Controllers;

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
        $compras = $this->daoCompra->all(true);
        return view('compras.index', compact('compras'));
    }

    public function all()
    {
        return $this->daoCompra->all();
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
        $compra = $this->daoCompra->findById($id, true);

        if ($compra)
            return view('compras.show', compact('compra'));

        return redirect('compras')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $compra = $this->daoCompra->findById($id, true);

        if ($compra)
            return view('compras.create', compact('compra'));

        return redirect('compras')->with('error', 'Registro não encontrado.');
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

    public function findById(int $id) {
        $compra = $this->daoCompra->findById($id);

        return [ $compra ];
    }
}
