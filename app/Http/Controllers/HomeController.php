<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Dao\DaoVenda;
use App\Http\Dao\DaoCliente;
use App\Http\Dao\DaoContaPagar;
use App\Http\Dao\DaoContaReceber;

class HomeController extends Controller
{
    private DaoVenda $daoVenda;
    private DaoCliente $daoCliente;
    private DaoContaPagar $daoContaPagar;
    private DaoContaReceber $daoContaReceber;

    public function __construct()
    {
        $this->daoVenda = new DaoVenda();
        $this->daoCliente = new DaoCliente();
        $this->daoContaPagar = new DaoContaPagar();
        $this->daoContaReceber = new DaoContaReceber();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pendentes = array('chave' => 'status', 'valor' => 'Em aberto');

        $contasPagar = $this->daoContaPagar->all(false, $pendentes);
        $contasReceber = $this->daoContaReceber->all(false, $pendentes);

        $totalRecebido = $this->daoContaReceber->all(false, array('chave' => 'status', 'valor' => 'Recebido'));

        $totalClientes = count($this->daoCliente->all());

        return view('home', compact('contasPagar', 'contasReceber', 'totalRecebido', 'totalClientes'));
    }
}
