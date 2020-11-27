<?php

namespace App\Http\Models;

use App\Http\Models\FormaPagamento;
use App\Http\Models\CondicaoPagamento;

class Parcela extends TObject
{
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
     * @var FormaPagamento
     */
    protected $formaPagamento;

    public function __construct()
    {
        $this->numero = 0;
        $this->prazo  = 0;
        $this->porcentagem = 0;
        $this->formaPagamento    = new FormaPagamento();
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
}
