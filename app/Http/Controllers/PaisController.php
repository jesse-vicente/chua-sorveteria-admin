<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaisRequest;
use Illuminate\Http\Request;

use App\Http\Dao\DaoPais;

class PaisController extends Controller
{
    private DaoPais $daoPais;

    public function __construct()
    {
        $this->daoPais = new DaoPais();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paises = $this->daoPais->all(true);
        return view('paises.index', compact('paises'));
    }

    public function all()
    {
        $paises = $this->daoPais->all();
        return $paises;
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
            return redirect('paises')->with('success', 'Registro inserido com sucesso!');

        return redirect('paises')->with('error', 'Erro ao inserir registro.');
    }

    public function save(PaisRequest $request)
    {
        $pais = $this->daoPais->create($request->all());

        $store = $this->daoPais->store($pais);

        if ($store) {
            return response()->json([
                'success' => true,
                'message' => 'Registro inserido com sucesso!'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Erro ao inserir registro!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pais = $this->daoPais->findById($id, true);

        if ($pais)
            return view('paises.show', compact('pais'));

        return redirect('paises')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pais = $this->daoPais->findById($id, true);

        if ($pais)
            return view('paises.create', compact('pais'));

        return redirect('paises')->with('error', 'Registro não encontrado.');
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

    public function findById(int $id) {
        $pais = $this->daoPais->findById($id);

        return [ $pais ];
    }
}
