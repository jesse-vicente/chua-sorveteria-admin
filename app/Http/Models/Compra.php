<?php

namespace App\Http\Models;

class Compra extends TObject
{
    /**
     * @var Fornecedor
     */
    protected $fornecedor;

    /**
     * @var CondicaoPagamento
     */
    protected $condicaoPagamento;

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
     * @return  self
     */
    public function setFornecedor(Fornecedor $fornecedor)
    {
        $this->fornecedor = $fornecedor;

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
