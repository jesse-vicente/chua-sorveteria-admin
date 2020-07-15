<?php

namespace App\Http\Models;

use App\Http\Models\FormaPagamento;
use App\Http\Models\CondicaoPagamento;

class Parcela extends TObject
{
    /**
     * @var FormaPagamento
     */
    protected $formaPagamento;

    /**
     * @var CondicaoPagamento
     */
    protected $condicaoPagamento;

    /**
     * @var int
     */
    protected $numero;

    /**
     * @var int
     */
    protected $prazo;

    /**
     * @var float
     */
    protected $porcentagem;

    /**
     * @var float
     */
    protected $juros;

    /**
     * @var float
     */
    protected $valor;

    public function __construct()
    {
        $this->formaPagamento    = new FormaPagamento();
        $this->condicaoPagamento = new CondicaoPagamento();
        $this->numero            = 0;
        $this->valor             = 0;
    }

    /**
     * Get the value of formaPagamento
     *
     * @return  FormaPagamento
     */
    public function getFormaPagamento()
    {
        return $this->formaPagamento;
    }

    /**
     * Set the value of formaPagamento
     *
     * @param  FormaPagamento  $formaPagamento
     *
     */
    public function setFormaPagamento(FormaPagamento $formaPagamento)
    {
        $this->formaPagamento = $formaPagamento;
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
     * Get the value of numero
     *
     * @return  int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @param  int  $numero
     *
     */
    public function setNumero(int $numero)
    {
        $this->numero = $numero;
    }

        /**
     * Get the value of prazo
     *
     * @return  int
     */
    public function getPrazo()
    {
        return $this->prazo;
    }

    /**
     * Set the value of prazo
     *
     * @param  int  $prazo
     *
     */
    public function setPrazo(int $prazo)
    {
        $this->prazo = $prazo;
    }

    /**
     * Get the value of porcentagem
     *
     * @return  float
     */
    public function getPorcentagem()
    {
        return $this->porcentagem;
    }

    /**
     * Set the value of porcentagem
     *
     * @param  float  $porcentagem
     *
     */
    public function setPorcentagem(float $porcentagem)
    {
        $this->porcentagem = $porcentagem;
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
     * Get the value of valor
     *
     * @return  float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set the value of valor
     *
     * @param  float  $valor
     *
     */
    public function setValor(float $valor)
    {
        $this->valor = $valor;
    }
}
