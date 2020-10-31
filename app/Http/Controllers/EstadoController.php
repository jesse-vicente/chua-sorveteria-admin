<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadoRequest;

use App\Http\Dao\DaoEstado;

class EstadoController extends Controller
{
    private $daoEstado;

    public function __construct()
    {
        $this->daoEstado = new DaoEstado();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estados = $this->daoEstado->all(true);
        return view('estados.index', compact('estados'));
    }

    public function all()
    {
        $estados = $this->daoEstado->all();
        return $estados;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('estados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\EstadoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstadoRequest $request)
    {
        $estado = $this->daoEstado->create($request->all());

        $store = $this->daoEstado->store($estado);

        if ($store)
            return redirect('estados') ->with('success', 'Registro inserido com sucesso!');

        return redirect('estados')->with('error', 'Erro ao inserir registro.');
    }

    public function save(EstadoRequest $request)
    {
        $estado = $this->daoEstado->create($request->all());

        $store = $this->daoEstado->store($estado);

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
        $estado = $this->daoEstado->findById($id, true);

        if ($estado)
            return view('estados.show', compact('estado'));

        return redirect('estados')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estado = $this->daoEstado->findById($id, true);

        if ($estado)
            return view('estados.create', compact('estado'));

        return redirect('estados')->with('error', 'Registro não encontrado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\EstadoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EstadoRequest $request, $id)
    {
        $update = $this->daoEstado->update($request, $id);

        if ($update)
            return redirect('estados') ->with('success', 'Registro alterado com sucesso!');

        return redirect('estados')->with('error', 'Erro ao alterar registro.');
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->daoEstado->delete($id);

        if ($delete)
            return redirect('estados')->with('success', 'Registro removido com sucesso!');

        return redirect('estados')->with('error', 'Este registro não pode ser removido.');
    }

    public function findById(int $id) {
        $estado = $this->daoEstado->findById($id);

        return [ $estado ];
    }
}
