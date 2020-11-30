<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContaPagarRequest;

use App\Http\Dao\DaoContaPagar;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $contaPagar = $this->daoContaPagar->create($request->all());

        $store = $this->daoContaPagar->store($contaPagar);

        if ($store)
            return redirect('contas-a-pagar') ->with('success', 'Registro inserido com sucesso!');

        return redirect('contas-a-pagar')->with('error', 'Erro ao inserir registro.');
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

        if ($contaPagar) {
            $compra = $contaPagar->getCompra();
            return view('contas-a-pagar.create', compact('contaPagar', 'compra'));
        }

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
        // Cancelamento
        if ($request->senha) {
            $user = Auth::user();

            if (Hash::check($request->senha, $user->password)) {
                $update = $this->daoContaPagar->update($request, $key);

                if ($update)
                    return redirect('contas-a-pagar') ->with('success', 'Registro cancelado com sucesso!');

                return redirect('contas-a-pagar')->with('error', 'Erro ao cancelar registro.');
            } else {
                return redirect()->back()->with('error', 'Senha inválida.');
            }
        }

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
