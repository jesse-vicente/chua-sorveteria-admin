<?php

namespace App\Http\Models;

use App\Http\Models\Fornecedor;
use App\Http\Models\ProdutoCompra;
use App\Http\Models\ContasPagar;
use App\Http\Models\CondicaoPagamento;
use App\Http\Models\Funcionario;

use Illuminate\Support\Carbon;
use stdClass;

class Compra extends TObject
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
    protected $dataEmissao;

    /**
     * @var string
     */
    protected $dataChegada;

    /**
     * @var Fornecedor
     */
    protected $fornecedor;

    /**
     * @var ProdutoCompra[]
     */
    protected $produtos;

    /**
     * @var ContasPagar[]
     */
    protected $contasPagar;

    /**
     * @var float
     */
    protected $frete;

    /**
     * @var float
     */
    protected $seguro;

    /**
     * @var float
     */
    protected $despesas;

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
    protected $totalCompra;

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
     * Get the value of fornecedor
     *
     * @return  Fornecedor
     */
    public function getFornecedor()
    {
        return $this->fornecedor;
    }

    /**
     * Set the value of fornecedor
     *
     * @param  Fornecedor  $fornecedor
     *
     */
    public function setFornecedor(Fornecedor $fornecedor)
    {
        $this->fornecedor = $fornecedor;
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
     * Get the value of dataEmissao
     *
     * @return  string
     */
    public function getDataEmissao()
    {
        return $this->dataEmissao;
    }

    /**
     * Set the value of dataEmissao
     *
     * @param  string  $dataEmissao
     *
     */
    public function setDataEmissao(string $dataEmissao)
    {
        $this->dataEmissao = $dataEmissao;
    }

    /**
     * Get the value of dataChegada
     *
     * @return  string
     */
    public function getDataChegada()
    {
        return $this->dataChegada;
    }

    /**
     * Set the value of dataChegada
     *
     * @param  string  $dataChegada
     *
     */
    public function setDataChegada(string $dataChegada)
    {
        $this->dataChegada = $dataChegada;
    }

    /**
     * Get the value of primaryKey
     *
     * @return  string
     */
    public function getPrimaryKeyStr()
    {
        return $this->numeroNota . '-' . $this->serie . '-' . $this->modelo . '-' . $this->getFornecedor()->getId();
    }

    public function getPrimaryKey() {
        $pk = new stdClass();

        $pk->numero       = $this->numeroNota;
        $pk->serie        = $this->serie;
        $pk->modelo       = $this->modelo;
        $pk->idFornecedor = $this->getFornecedor()->getId();

        return $pk;
    }

    /**
     * Get the value of produtos
     *
     * @return  ProdutoCompra[]
     */
    public function getProdutos()
    {
        return $this->produtos;
    }

    /**
     * Set the value of produtos
     *
     * @param  ProdutoCompra[]  $produtos
     *
     */
    public function setProdutos(array $produtos)
    {
        $this->produtos = $produtos;
    }

    /**
     * Get the value of frete
     *
     * @return  float
     */
    public function getFrete()
    {
        return $this->frete;
    }

    /**
     * Set the value of frete
     *
     * @param  float  $frete
     *
     */
    public function setFrete(float $frete)
    {
        $this->frete = $frete;
    }

    /**
     * Get the value of seguro
     *
     * @return  float
     */
    public function getSeguro()
    {
        return $this->seguro;
    }

    /**
     * Set the value of seguro
     *
     * @param  float  $seguro
     *
     */
    public function setSeguro(float $seguro)
    {
        $this->seguro = $seguro;
    }

    /**
     * Get the value of despesas
     *
     * @return  float
     */
    public function getDespesas()
    {
        return $this->despesas;
    }

    /**
     * Set the value of despesas
     *
     * @param  float  $despesas
     *
     */
    public function setDespesas(float $despesas)
    {
        $this->despesas = $despesas;
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
     * Get the value of totalCompra
     *
     * @return  float
     */
    public function getTotalCompra()
    {
        return $this->totalCompra;
    }

    /**
     * Set the value of totalCompra
     *
     * @param  float  $totalCompra
     *
     */
    public function setTotalCompra(float $totalCompra)
    {
        $this->totalCompra = $totalCompra;
    }

    /**
     * Get the value of contasPagar
     *
     * @return  ContasPagar[]
     */
    public function getContasPagar()
    {
        return $this->contasPagar;
    }

    /**
     * Set the value of contasPagar
     *
     * @param  ContasPagar[]  $contasPagar
     *
     */
    public function setContasPagar(array $contasPagar)
    {
        $this->contasPagar = $contasPagar;
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
