<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Estado;
use App\Models\Pais;

use Illuminate\Support\Facades\DB;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estados = Estado::all();
        return view('estados.index', compact('estados'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Estado::create($request->all());

        return redirect('estados')->withSuccess('Estado cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estado = Estado::find($id);
        $pais = Pais::find($estado->getAttribute('pais_id'));

        $estado->setAttribute('pais', $pais->getAttribute('pais'));

        return view('estados.create', compact('estado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Estado::destroy($id);
        return redirect('estados')->withSuccess('Estado excluído com sucesso!');
    }

    /**
     * Search for the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $q = $request->q;

        $estados = (!is_null($q))
            ? DB::select(DB::raw("SELECT id, estado, uf, pais_id FROM estados WHERE id LIKE '$q' OR estado LIKE '$q%'"))
            : DB::select(DB::raw("SELECT id, estado, uf, pais_id FROM estados LIMIT 10"));

        return view('estados.search', compact('estados'));
    }
}
