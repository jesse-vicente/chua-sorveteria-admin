<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendaRequest;
use Illuminate\Http\Request;

use App\Http\Dao\DaoVenda;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Response as HttpResponse;

class VendaController extends Controller
{
    private DaoVenda $daoVenda;

    public function __construct()
    {
        $this->daoVenda = new DaoVenda();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendas = $this->daoVenda->all(true);
        return view('vendas.index', compact('vendas'));
    }

    public function all()
    {
        return $this->daoVenda->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\VendaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendaRequest $request)
    {
        //
    }

    public function save(VendaRequest $request) {
        $venda = $this->daoVenda->create($request->all());

        $response = $this->daoVenda->store($venda);

        if ($response->getStatusCode() == 200) {
            $request->session()->flash('success', 'Registro inserido com sucesso!');
            return $response;
        }
        else {
            $request->session()->flash('error', $response->getData()->message);
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
        // $venda = $this->daoVenda->findByPrimaryKey($key, true);

        // if ($venda)
        //     return view('vendas.show', compact('venda'));

        // return redirect('vendas')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for canceling the specified resource.
     *
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function cancel($key)
    {
        $venda = $this->daoVenda->findByPrimaryKey($key, true);

        if ($venda)
            return view('vendas.create', compact('venda'));

        return redirect('vendas')->with('error', 'Registro não encontrado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\VendaRequest  $request
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key)
    {
        $request->validate([
            'num_nota' => "unique:vendas,num_nota,$request->num_nota,num_nota"
        ]);

        $update = $this->daoVenda->update($request, $key);

        if ($update)
            return redirect('vendas') ->with('success', 'Registro alterado com sucesso!');

        return redirect('vendas')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $key
     * @return \Illuminate\Http\Response
     */
    public function destroy($key)
    {
        $delete = $this->daoVenda->delete($key);

        if ($delete)
            return redirect('vendas')->with('success', 'Registro removido com sucesso!');

        return redirect('vendas')->with('error', 'Este registro não pode ser removido.');
    }

    public function findByPrimaryKey(int $key) {
        $venda = $this->daoVenda->findByPrimaryKey($key);

        return [ $venda ];
    }
}
