<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CondicaoPagamentoRequest;

use App\Http\Dao\DaoCondicaoPagamento;

use App\Http\Dao\DaoFormaPagamento;

class CondicaoPagamentoController extends Controller
{
    private DaoCondicaoPagamento $daoCondicaoPagamento;
    private DaoFormaPagamento $daoFormaPagamento;

    public function __construct()
    {
        $this->daoCondicaoPagamento = new DaoCondicaoPagamento();
        $this->daoFormaPagamento = new DaoFormaPagamento();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $condicoesPagamento = $this->daoCondicaoPagamento->all(true);
        return view('condicoes-pagamento.index', compact('condicoesPagamento'));
    }

    public function all()
    {
        $condicoes = $this->daoCondicaoPagamento->all(true);

        $condicoesPagamento = array();

        foreach ($condicoes as $condicao) {
            $condicaoPagamento = $this->daoCondicaoPagamento->fillForModal($condicao);
            array_push($condicoesPagamento, $condicaoPagamento);
        }

        return $condicoesPagamento;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formasPagamento = $this->daoFormaPagamento->all();
        return view('condicoes-pagamento.create', compact('formasPagamento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CondicaoPagamentoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CondicaoPagamentoRequest $request)
    {
        $condicaoPagamento = $this->daoCondicaoPagamento->create($request->all());

        $store = $this->daoCondicaoPagamento->store($condicaoPagamento);

        if ($store)
            return redirect('condicoes-pagamento')->with('success', 'Registro inserido com sucesso!');

        return redirect('condicoes-pagamento')->with('error', 'Erro ao inserir registro.');
    }

    public function save(CondicaoPagamentoRequest $request)
    {
        $condicaoPagamento = $this->daoCidade->create($request->all());

        $store = $this->daoCidade->store($condicaoPagamento);

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
        $dados = $this->daoCondicaoPagamento->findById($id);

        if ($dados) {
            $condicaoPagamento = $this->daoCondicaoPagamento->create(get_object_vars($dados));
            return view('condicoes-pagamento.show', compact('condicaoPagamento'));
        }

        return redirect('condicoes-pagamento')->with('error', 'Registro não encontrado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados = $this->daoCondicaoPagamento->findById($id);

        if ($dados) {
            $condicaoPagamento = $this->daoCondicaoPagamento->create(get_object_vars($dados));
            return view('condicoes-pagamento.create', compact('condicaoPagamento'));
        }

        return redirect('condicoes-pagamento')->with('error', 'Registro não encontrado.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CondicaoPagamentoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CondicaoPagamentoRequest $request, $id)
    {
        $update = $this->daoCondicaoPagamento->update($request, $id);

        if ($update)
            return redirect('condicoes-pagamento') ->with('success', 'Registro alterado com sucesso!');

        return redirect('condicoes-pagamento')->with('error', 'Erro ao alterar registro.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->daoCondicaoPagamento->delete($id);

        if ($delete)
            return redirect('condicoes-pagamento')->with('success', 'Registro removido com sucesso!');

        return redirect('condicoes-pagamento')->with('error', 'Este registro não pode ser removido.');
    }

    public function findById(int $id) {
        $condicaoPagamento = $this->daoCondicaoPagamento->findById($id);

        return [ $condicaoPagamento ];
    }
}
