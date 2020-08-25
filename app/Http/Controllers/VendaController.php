<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendaRequest;

use App\Http\Dao\DaoVenda;

class VendaController extends Controller
{
    private DaoVenda $daoVenda;

    public function __construct()
    {
        $this->daoVenda = new DaoVenda();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendas = $this->daoVenda->all(true);
        return view('vendas.index', compact('vendas'));
    }

    public function all()
    {
        return $this->daoVenda->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\VendaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendaRequest $request)
    {
        $venda = $this->daoVenda->create($request->all());

        $store = $this->daoVenda->store($venda);

        if ($store)
            return redirect('vendas') ->with('success', 'Registro inserido com sucesso!');

        return redirect('vendas')->with('error', 'Erro ao inserir registro.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venda = $this->daoVenda->findById($id, true);

        if ($venda)
            return view('vendas.show', compact('venda'));

        return redirect('vendas')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venda = $this->daoVenda->findById($id, true);

        if ($venda)
            return view('vendas.create', compact('venda'));

        return redirect('vendas')->with('error', 'Registro não encontrado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\VendaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendaRequest $request, $id)
    {
        $update = $this->daoVenda->update($request, $id);

        if ($update)
            return redirect('vendas') ->with('success', 'Registro alterado com sucesso!');

        return redirect('vendas')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->daoVenda->delete($id);

        if ($delete)
            return redirect('vendas')->with('success', 'Registro removido com sucesso!');

        return redirect('vendas')->with('error', 'Este registro não pode ser removido.');
    }

    public function findById(int $id) {
        $venda = $this->daoVenda->findById($id);

        return [ $venda ];
    }
}
