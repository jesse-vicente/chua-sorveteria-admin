<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContaReceberRequest;

use App\Http\Dao\DaoContaReceber;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ContaReceberController extends Controller
{
    private DaoContaReceber $daoContaReceber;

    public function __construct()
    {
        $this->daoContaReceber = new DaoContaReceber();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contas = $this->daoContaReceber->all(true);
        return view('contas-a-receber.index', compact('contas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ContaReceberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContaReceberRequest $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $key
     * @return \Illuminate\Http\Response
     */
    public function show($key)
    {
        $contaReceber = $this->daoContaReceber->findByPrimaryKey($key, true);

        if ($contaReceber)
            return view('contas-a-receber.show', compact('contaReceber'));

        return redirect('contas-a-receber')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $key
     * @return \Illuminate\Http\Response
     */
    public function edit($key)
    {
        $contaReceber = $this->daoContaReceber->findByPrimaryKey($key, true);

        if ($contaReceber)
            return view('contas-a-receber.create', compact('contaReceber'));

        return redirect('contas-a-receber')->with('error', 'Registro não encontrado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ContaReceberRequest  $request
     * @param  int  $key
     * @return \Illuminate\Http\Response
     */
    public function update(ContaReceberRequest $request, $key)
    {
        // Cancelamento
        if ($request->senha) {
            $user = Auth::user();

            if (Hash::check($request->senha, $user->password)) {
                $update = $this->daoContaReceber->update($request, $key);

                if ($update)
                    return redirect('contas-a-receber') ->with('success', 'Registro cancelado com sucesso!');

                return redirect('contas-a-receber')->with('error', 'Erro ao cancelar registro.');
            }

            return redirect()->back()->with('error', 'Senha inválida.');
        }

        // Recebimento
        $update = $this->daoContaReceber->update($request, $key);

        if ($update)
            return redirect('contas-a-receber') ->with('success', 'Registro alterado com sucesso!');

        return redirect('contas-a-receber')->with('error', 'Erro ao alterar registro.');
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
