<?php

namespace App\Http\Models;

class FormaPagamento extends TObject
{
    /**
     * @var string
     */
    protected $formaPagamento;

    /**
     * Get the value of formaPagamento
     *
     * @return  string
     */
    public function getFormaPagamento()
    {
        return $this->formaPagamento;
    }

    /**
     * Set the value of formaPagamento
     *
     * @param  string  $formaPagamento
     *
     */
    public function setFormaPagamento(string $formaPagamento)
    {
        $this->formaPagamento = $formaPagamento;
    }
}
