<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FornecedorRequest;

use App\Http\Dao\DaoFornecedor;

class FornecedorController extends Controller
{
    private DaoFornecedor $daoFornecedor;

    public function __construct(DaoFornecedor $daoFornecedor)
    {
        $this->daoFornecedor = $daoFornecedor;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fornecedores = $this->daoFornecedor->all();
        return view('fornecedores.index', compact('fornecedores'));
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
        $fornecedor = $this->daoFornecedor->find($id);
        return view('fornecedores.show', compact('fornecedor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fornecedor = $this->daoFornecedor->find($id);
        return view('fornecedores.create', compact('fornecedor'));
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

        return redirect('fornecedores')->with('error', 'Este registro não pode ser removido.');
    }

    /**
     * Search for the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $q = $request->q;

        $fornecedores = $this->daoFornecedor->search($q);

        return view('fornecedores.search', compact('fornecedores'));
    }

    public function find($id) {
        $dados = array();

        if ($id == 0) {
            $fornecedores = $this->daoFornecedor->all();

            foreach ($fornecedores as $fornecedor) {
                $dadosFornecedor = $this->daoFornecedor->fillForModal($fornecedor);
                array_push($dados, $dadosFornecedor);
            }

            return $dados;
        }
        else {
            $fornecedor = $this->daoFornecedor->find($id);

            if ($fornecedor) {
                $dados = $this->daoFornecedor->fillForModal($fornecedor);
                return [$dados];
            }
        }

        return null;
    }
}
