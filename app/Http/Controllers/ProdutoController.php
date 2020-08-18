<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProdutoRequest;

use App\Http\Dao\DaoProduto;

class ProdutoController extends Controller
{
    private DaoProduto $daoProduto;

    public function __construct()
    {
        $this->daoProduto = new DaoProduto();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = $this->daoProduto->all();
        return view('produtos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produtos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ProdutoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdutoRequest $request)
    {
        $produto = $this->daoProduto->create($request->all());

        $store = $this->daoProduto->store($produto);

        if ($store)
            return redirect('produtos') ->with('success', 'Registro inserido com sucesso!');

        return redirect('produtos')->with('error', 'Erro ao inserir registro.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = $this->daoProduto->find($id);
        return view('produtos.show', compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produto = $this->daoProduto->find($id);
        return view('produtos.create', compact('produto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ProdutoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProdutoRequest $request, $id)
    {
        $update = $this->daoProduto->update($request, $id);

        if ($update)
            return redirect('produtos') ->with('success', 'Registro alterado com sucesso!');

        return redirect('produtos')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->daoProduto->delete($id);

        if ($delete)
            return redirect('produtos')->with('success', 'Registro removido com sucesso!');

        return redirect('produtos')->with('error', 'Este registro não pode ser removido.');
    }

    /**
     * Search for the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $q = $request->q;

        $produtos = $this->daoProduto->search($q);

        return view('produtos.search', compact('produtos'));
    }

    public function find($id) {
        $dados = array();

        if ($id == 0) {
            $produtos = $this->daoProduto->all();

            foreach ($produtos as $produto) {
                $dadosProduto = $this->daoProduto->fillForModal($produto);
                array_push($dados, $dadosProduto);
            }

            return $dados;
        }
        else {
            $produto = $this->daoProduto->find($id);

            if ($produto) {
                $dados = $this->daoProduto->fillForModal($produto);
                return [$dados];
            }
        }

        return null;
    }
}
