<?php

namespace App\Http\Models;

class Venda extends TObject
{
    /**
     * @var Cliente
     */
    protected $cliente;

    /**
     * @var CondicaoPagamento
     */
    protected $condicaoPagamento;

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
     * @return  self
     */
    public function setCliente(Cliente $cliente)
    {
        $this->cliente = $cliente;

        return $this;
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
     * @return  self
     */
    public function setCondicaoPagamento(CondicaoPagamento $condicaoPagamento)
    {
        $this->condicaoPagamento = $condicaoPagamento;

        return $this;
    }
}
