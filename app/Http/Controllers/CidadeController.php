<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CidadeRequest;

use App\Http\Dao\DaoCidade;
use App\Http\Dao\DaoEstado;

class CidadeController extends Controller
{
    private DaoCidade $daoCidade;

    public function __construct()
    {
        $this->daoCidade = new DaoCidade();
        $this->daoEstado = new DaoEstado();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cidades = $this->daoCidade->all();
        return view('cidades.index', compact('cidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cidades.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CidadeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CidadeRequest $request)
    {
        $cidade = $this->daoCidade->create($request->all());

        $store = $this->daoCidade->store($cidade);

        if ($store)
            return redirect('cidades') ->with('success', 'Registro inserido com sucesso!');

        return redirect('cidades')->with('error', 'Erro ao inserir registro.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cidade = $this->daoCidade->find($id);
        return view('cidades.show', compact('cidade'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cidade = $this->daoCidade->find($id);
        return view('cidades.create', compact('cidade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CidadeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CidadeRequest $request, $id)
    {
        $update = $this->daoCidade->update($request, $id);

        if ($update)
            return redirect('cidades') ->with('success', 'Registro alterado com sucesso!');

        return redirect('cidades')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->daoCidade->delete($id);

        if ($delete)
            return redirect('cidades')->with('success', 'Registro removido com sucesso!');

        return redirect('cidades')->with('error', 'Este registro não pode ser removido.');
    }

    /**
     * Search for the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $q = $request->q;

        $cidades = $this->daoCidade->search($q);

        return view('cidades.search', compact('cidades'));
    }

    public function find($id) {
        $dados = array();

        if ($id == 0) {
            $cidades = $this->daoCidade->all();

            foreach ($cidades as $cidade) {
                $dadosCidade = $this->daoCidade->fillForModal($cidade);
                array_push($dados, $dadosCidade);
            }

            return $dados;
        }
        else {
            $cidade = $this->daoCidade->find($id);

            if ($cidade) {
                $dados = $this->daoCidade->fillForModal($cidade);
                return [$dados];
            }
        }

        return null;
    }
}
