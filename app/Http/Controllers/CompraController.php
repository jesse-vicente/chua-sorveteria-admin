<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompraRequest;
use Illuminate\Http\Request;

use App\Http\Dao\DaoCompra;

class CompraController extends Controller
{
    private DaoCompra $daoCompra;

    public function __construct()
    {
        $this->daoCompra = new DaoCompra();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compras = $this->daoCompra->all(true);
        return view('compras.index', compact('compras'));
    }

    public function all()
    {
        return $this->daoCompra->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('compras.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CompraRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompraRequest $request)
    {
        //
    }

    public function save(CompraRequest $request) {
        $compra = $this->daoCompra->create($request->all());

        $response = $this->daoCompra->store($compra);

        if ($response->getStatusCode() == 200) {
            $request->session()->flash('success', 'Registro inserido com sucesso!');
            return $response;
        }
        else {
            // $request->session()->flash('error', $response->getData()->message);
            return $response;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function show($key)
    {
        $compra = $this->daoCompra->findByPrimaryKey($key, true);

        if ($compra)
            return view('compras.show', compact('compra'));

        return redirect('compras')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for canceling the specified resource.
     *
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function cancel($key)
    {
        $compra = $this->daoCompra->findByPrimaryKey($key, true);

        if ($compra)
            return view('compras.create', compact('compra'));

        return redirect('compras')->with('error', 'Registro não encontrado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CompraRequest  $request
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key)
    {
        $request->validate([
            'num_nota' => "unique:compras,num_nota,$request->num_nota,num_nota"
        ]);

        $update = $this->daoCompra->update($request, $key);

        if ($update)
            return redirect('compras') ->with('success', 'Registro alterado com sucesso!');

        return redirect('compras')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function destroy($key)
    {
        $delete = $this->daoCompra->delete($key);

        if ($delete)
            return redirect('compras')->with('success', 'Registro removido com sucesso!');

        return redirect('compras')->with('error', 'Este registro não pode ser removido.');
    }

    public function findByPrimaryKey(int $key) {
        $compra = $this->daoCompra->findByPrimaryKey($key);

        return [ $compra ];
    }
}
