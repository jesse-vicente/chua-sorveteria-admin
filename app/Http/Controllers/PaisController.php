<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PaisRequest;

use Illuminate\Support\Facades\Session;

use App\Http\Dao\DaoPais;

class PaisController extends Controller
{
    private DaoPais $daoPais;

    public function __construct(DaoPais $daoPais)
    {
        $this->daoPais = $daoPais;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paises = $this->daoPais->all();
        return view('paises.index', compact('paises'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paises.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PaisRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaisRequest $request)
    {
        $pais = $this->daoPais->create($request->all());

        $store = $this->daoPais->store($pais);

        if ($store)
            return redirect('paises') ->with('success', 'Registro inserido com sucesso!');

        return redirect('paises')->with('error', 'Erro ao inserir registro.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pais = $this->daoPais->find($id);
        return view('paises.show', compact('pais'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pais = $this->daoPais->find($id);
        return view('paises.create', compact('pais'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PaisRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaisRequest $request, $id)
    {
        $update = $this->daoPais->update($request, $id);

        if ($update)
            return redirect('paises') ->with('success', 'Registro alterado com sucesso!');

        return redirect('paises')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->daoPais->delete($id);

        if ($delete)
            return redirect('paises')->with('success', 'Registro removido com sucesso!');

        return redirect()->back()->with('error', 'Este registro não pode ser removido!');
    }

    /**
     * Search for the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $paises = $this->daoPais->search($request->q);

        return view('paises.search', compact('paises'));
    }

    public function find($id) {
        $pais = $this->daoPais->find($id);

        if ($pais != null)
            return ["nome" => $pais->getPais()];  

        return null;
    }
}
