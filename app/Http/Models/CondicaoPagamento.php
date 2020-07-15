<?php

namespace App\Http\Models;

use App\Http\Models\Parcela;

class CondicaoPagamento extends TObject
{
    /**
     * @var string
     */
    protected $condicaoPagamento;

    /**
     * @var float
     */
    protected $juros;

    /**
     * @var float
     */
    protected $multa;

    /**
     * @var float
     */
    protected $desconto;

    /**
     * @var Parcela[]
     */
    protected $parcelas;

    /**
     * @var int
     */
    protected $totalParcelas;

    public function __construct()
    {
        $this->condicaoPagamento = '';
        $this->juros             = 0;
        $this->multa             = 0;
        $this->desconto          = 0;
        $this->totalParcelas     = 0;
    }

    /**
     * Get the value of condicaoPagamento
     *
     * @return  string
     */
    public function getCondicaoPagamento()
    {
        return $this->condicaoPagamento;
    }

    /**
     * Set the value of condicaoPagamento
     *
     * @param  string  $condicaoPagamento
     *
     */
    public function setCondicaoPagamento(string $condicaoPagamento)
    {
        $this->condicaoPagamento = $condicaoPagamento;
    }

    /**
     * Get the value of juros
     *
     * @return  float
     */
    public function getJuros()
    {
        return $this->juros;
    }

    /**
     * Set the value of juros
     *
     * @param  float  $juros
     *
     */
    public function setJuros(float $juros)
    {
        $this->juros = $juros;
    }

    /**
     * Get the value of multa
     *
     * @return  float
     */
    public function getMulta()
    {
        return $this->multa;
    }

    /**
     * Set the value of multa
     *
     * @param  float  $multa
     *
     */
    public function setMulta(float $multa)
    {
        $this->multa = $multa;
    }

        /**
     * Get the value of desconto
     *
     * @return  float
     */
    public function getDesconto()
    {
        return $this->desconto;
    }

    /**
     * Set the value of desconto
     *
     * @param  float  $desconto
     *
     */
    public function setDesconto(float $desconto)
    {
        $this->desconto = $desconto;
    }

    /**
     * Get the value of totalParcelas
     *
     * @return  int
     */
    public function getTotalParcelas()
    {
        return $this->totalParcelas;
    }

    /**
     * Set the value of totalParcelas
     *
     * @param  int  $totalParcelas
     *
     */
    public function setTotalParcelas(int $totalParcelas)
    {
        $this->totalParcelas = $totalParcelas;
    }

    /**
     * Get the value of parcelas
     *
     * @return  array
     */
    public function getParcelas()
    {
        // dd($this->parcelas);
        return $this->parcelas;
    }

    /**
     * Set the value of parcelas
     *
     * @param  Parcela[]  $parcelas
     *
     */
    public function setParcelas(array $parcelas)
    {
        $this->parcelas = $parcelas;
    }
}
