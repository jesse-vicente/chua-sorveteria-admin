<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContaPagarRequest;

use App\Http\Dao\DaoContaPagar;

class ContaPagarController extends Controller
{
    private DaoContaPagar $daoContaPagar;

    public function __construct()
    {
        $this->daoContaPagar = new DaoContaPagar();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contas = $this->daoContaPagar->all(true);
        return view('contas-a-pagar.index', compact('contas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contas-a-pagar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ContaPagarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContaPagarRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $key
     * @return \Illuminate\Http\Response
     */
    public function show($key)
    {
        $contaPagar = $this->daoContaPagar->findByPrimaryKey($key, true);

        if ($contaPagar)
            return view('contas-a-pagar.show', compact('contaPagar'));

        return redirect('contas-a-pagar')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $key
     * @return \Illuminate\Http\Response
     */
    public function edit($key)
    {
        $contaPagar = $this->daoContaPagar->findByPrimaryKey($key, true);

        if ($contaPagar)
            return view('contas-a-pagar.create', compact('contaPagar'));

        return redirect('contas-a-pagar')->with('error', 'Registro não encontrado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ContaPagarRequest  $request
     * @param  int  $key
     * @return \Illuminate\Http\Response
     */
    public function update(ContaPagarRequest $request, $key)
    {
        $update = $this->daoContaPagar->update($request, $key);

        if ($update)
            return redirect('contas-a-pagar') ->with('success', 'Registro alterado com sucesso!');

        return redirect('contas-a-pagar')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
