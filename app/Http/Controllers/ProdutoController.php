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
        $produtos = $this->daoProduto->all(true);
        return view('produtos.index', compact('produtos'));
    }

    public function all()
    {
        return $this->daoProduto->all();
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
        $dados = $this->daoProduto->findById($id);

        if ($dados) {
            $produto = $this->daoProduto->create(get_object_vars($dados));
            return view('produtos.show', compact('produto'));
        }

        return redirect('produtos')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados = $this->daoProduto->findById($id);

        if ($dados) {
            $produto = $this->daoProduto->create(get_object_vars($dados));
            return view('produtos.create', compact('produto'));
        }

        return redirect('produtos')->with('error', 'Registro não encontrado.');
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

    public function findById(int $id) {
        $produto = $this->daoProduto->findById($id);

        return [ $produto ];
    }
}
