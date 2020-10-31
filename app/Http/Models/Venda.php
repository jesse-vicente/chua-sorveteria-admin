<?php

namespace App\Http\Models;

use App\Http\Models\Cliente;
use App\Http\Models\ProdutoVenda;
use App\Http\Models\ContasReceber;
use App\Http\Models\CondicaoPagamento;
use App\Http\Models\Funcionario;

use Illuminate\Support\Carbon;
use stdClass;

class Venda extends TObject
{
    /**
     * @var int
     */
    protected $numeroNota;

    /**
     * @var int
     */
    protected $serie;

    /**
     * @var int
     */
    protected $modelo;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $dataVenda;

    /**
     * @var Cliente
     */
    protected $cliente;

    /**
     * @var ProdutoVenda[]
     */
    protected $produtos;

    /**
     * @var ContasReceber[]
     */
    protected $contasReceber;

    /**
     * @var float
     */
    protected $descontos;

    /**
     * @var float
     */
    protected $totalProdutos;

    /**
     * @var float
     */
    protected $totalVenda;

    /**
     * @var CondicaoPagamento
     */
    protected $condicaoPagamento;

    /**
     * @var Funcionario
     */
    protected $funcionario;

    /**
     * @var string
     */
    protected $dataCancelamento;

    /**
     * @var string
     */
    protected $observacoes;

    /**
     * Get the value of cliente
     *
     * @return  Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set the value of cliente
     *
     * @param  Cliente  $cliente
     *
     */
    public function setCliente(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Get the value of condicaoPagamento
     *
     * @return  CondicaoPagamento
     */
    public function getCondicaoPagamento()
    {
        return $this->condicaoPagamento;
    }

    /**
     * Set the value of condicaoPagamento
     *
     * @param  CondicaoPagamento  $condicaoPagamento
     *
     */
    public function setCondicaoPagamento(CondicaoPagamento $condicaoPagamento)
    {
        $this->condicaoPagamento = $condicaoPagamento;
    }

    /**
     * Get the value of numeroNota
     *
     * @return  int
     */
    public function getNumeroNota()
    {
        return $this->numeroNota;
    }

    /**
     * Set the value of numeroNota
     *
     * @param  int  $numeroNota
     *
     */
    public function setNumeroNota(int $numeroNota)
    {
        $this->numeroNota = $numeroNota;
    }

    /**
     * Get the value of serie
     *
     * @return  int
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set the value of serie
     *
     * @param  int  $serie
     *
     */
    public function setSerie(int $serie)
    {
        $this->serie = $serie;
    }

    /**
     * Get the value of modelo
     *
     * @return  int
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set the value of modelo
     *
     * @param  int  $modelo
     *
     */
    public function setModelo(int $modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * Get the value of dataVenda
     *
     * @return  string
     */
    public function getDataVenda()
    {
        return $this->dataVenda;
    }

    /**
     * Set the value of dataVenda
     *
     * @param  string  $dataVenda
     *
     */
    public function setDataVenda(string $dataVenda)
    {
        $this->dataVenda = $dataVenda;
    }

    /**
     * Get the value of primaryKey
     *
     * @return  string
     */
    public function getPrimaryKeyStr()
    {
        $pkStr = $this->numeroNota . '-' . $this->serie . '-' . $this->modelo ;

        if ($this->getCliente())
            $pkStr .= '-' . $this->getCliente()->getId();

        return $pkStr;
    }

    public function getPrimaryKey() {
        $pk = new stdClass();

        $pk->numero     = $this->numeroNota;
        $pk->serie      = $this->serie;
        $pk->modelo     = $this->modelo;
        $pk->cliente_id = $this->getCliente() ? $this->getCliente()->getId() : null;

        return $pk;
    }

    /**
     * Get the value of produtos
     *
     * @return  ProdutoVenda[]
     */
    public function getProdutos()
    {
        return $this->produtos;
    }

    /**
     * Set the value of produtos
     *
     * @param  ProdutoVenda[]  $produtos
     *
     */
    public function setProdutos(array $produtos)
    {
        $this->produtos = $produtos;
    }

    /**
     * Get the value of descontos
     *
     * @return  float
     */
    public function getDescontos()
    {
        return $this->descontos;
    }

    /**
     * Set the value of descontos
     *
     * @param  float  $descontos
     *
     */
    public function setDescontos(float $descontos)
    {
        $this->descontos = $descontos;
    }

    /**
     * Get the value of totalProdutos
     *
     * @return  float
     */
    public function getTotalProdutos()
    {
        return $this->totalProdutos;
    }

    /**
     * Set the value of totalProdutos
     *
     * @param  float  $totalProdutos
     *
     */
    public function setTotalProdutos(float $totalProdutos)
    {
        $this->totalProdutos = $totalProdutos;
    }

    /**
     * Get the value of totalVenda
     *
     * @return  float
     */
    public function getTotalVenda()
    {
        return $this->totalVenda;
    }

    /**
     * Set the value of totalVenda
     *
     * @param  float  $totalVenda
     *
     */
    public function setTotalVenda(float $totalVenda)
    {
        $this->totalVenda = $totalVenda;
    }

    /**
     * Get the value of contasReceber
     *
     * @return  ContasReceber[]
     */
    public function getContasReceber()
    {
        return $this->contasReceber;
    }

    /**
     * Set the value of contasReceber
     *
     * @param  ContasReceber[]  $contasReceber
     *
     */
    public function setContasReceber(array $contasReceber)
    {
        $this->contasReceber = $contasReceber;
    }

    /**
     * Get the value of funcionario
     *
     * @return  Funcionario
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }

    /**
     * Set the value of funcionario
     *
     * @param  Funcionario  $funcionario
     *
     */
    public function setFuncionario(Funcionario $funcionario)
    {
        $this->funcionario = $funcionario;
    }

    /**
     * Get the value of observacoes
     *
     * @return  string
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * Set the value of observacoes
     *
     * @param  string  $observacoes
     *
     */
    public function setObservacoes(string $observacoes)
    {
        $this->observacoes = $observacoes;
    }

    /**
     * Get the value of status
     *
     * @return  string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  string  $status
     *
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of dataCancelamento
     *
     * @return  string
     */
    public function getDataCancelamento()
    {
        if ($this->dataCancelamento) {
            return Carbon::parse($this->dataCancelamento)->toDate()->format('d/m/Y');
            // $hora = Carbon::parse($this->dataCancelamento)->toTimeString('minute');
        }

        return '-';
    }

    /**
     * Set the value of dataCancelamento
     *
     * @param  string  $dataCancelamento
     *
     */
    public function setDataCancelamento(string $dataCancelamento = null)
    {
        $this->dataCancelamento = $dataCancelamento;
    }
}
