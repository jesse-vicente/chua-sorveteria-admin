<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CondicaoPagamentoRequest;

use App\Http\Dao\DaoCondicaoPagamento;

use App\Http\Dao\DaoFormaPagamento;

class CondicaoPagamentoController extends Controller
{
    private DaoCondicaoPagamento $daoCondicaoPagamento;
    private DaoFormaPagamento $daoFormaPagamento;

    public function __construct(DaoCondicaoPagamento $daoCondicaoPagamento)
    {
        $this->daoCondicaoPagamento = $daoCondicaoPagamento;
        $this->daoFormaPagamento = new DaoFormaPagamento();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $condicoesPagamento = $this->daoCondicaoPagamento->all();
        return view('condicoes-pagamento.index', compact('condicoesPagamento'));
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $condicaoPagamento = $this->daoCondicaoPagamento->find($id);
        return view('condicoes-pagamento.show', compact('condicaoPagamento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $condicaoPagamento = $this->daoCondicaoPagamento->find($id);
        return view('condicoes-pagamento.create', compact('condicaoPagamento'));
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

    /**
     * Search for the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $q = $request->q;

        $condicoesPagamento = $this->daoCondicaoPagamento->search($q);

        return view('condicoes-pagamento.search', compact('condicoesPagamento'));
    }

    // public function find($id) {
    //     $condicaoPagamento = $this->daoCondicaoPagamento->find($id);

    //     if ($condicaoPagamento != null) {

    //         $parcelas = $condicaoPagamento->getParcelas();
    //         $listaParcelas = array();

    //         foreach ($parcelas as $parcela) {
    //             $dadosParcela = [
    //                 "numero"      => $parcela->getNumero(),
    //                 "prazo"       => $parcela->getPrazo(),
    //                 "porcentagem" => $parcela->getPorcentagem(),
    //             ];

    //             array_push($listaParcelas, $dadosParcela);
    //         }

    //         $dados = [
    //             "id"   => $condicaoPagamento->getId(),
    //             "nome" => $condicaoPagamento->getCondicaoPagamento(),
    //         ];

    //         // dd($dados);

    //         return $dados;
    //     }

    //     return null;
    // }

    public function find($id) {

        $dados = array();

        if ($id == 0) {
            $condicoesPagamento = $this->daoCondicaoPagamento->all();

            foreach ($condicoesPagamento as $condicaoPagamento) {
                $dadosCondicaoPagamento = $this->daoCondicaoPagamento->fillForModal($condicaoPagamento);
                array_push($dados, $dadosCondicaoPagamento);
            }

            return $dados;
        }
        else {
            $condicaoPagamento = $this->daoCondicaoPagamento->find($id);

            if ($condicaoPagamento) {
                $dados = $this->daoCondicaoPagamento->fillForModal($condicaoPagamento);
                return [$dados];
            }
        }

        return null;
    }
}
