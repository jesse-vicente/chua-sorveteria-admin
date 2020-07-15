<?php

namespace App\Http\Models;

use App\Http\Models\CondicaoPagamento;

class Cliente extends Pessoa
{

    /**
     * @var string
     */
    protected $apelido;

    /**
     * @var string
     */
    protected $dataNascimento;

    /**
     * @var CondicaoPagamento
     */
    protected $condicaoPagamento;

    /**
     * @var float
     */
    protected $valorCredito;

    public function __construct()
    {
        $this->apelido           = '';
        $this->condicaoPagamento = new CondicaoPagamento();
    }

    /**
     * Get the value of apelido
     *
     * @return  string
     */
    public function getApelido()
    {
        return $this->apelido;
    }

    /**
     * Set the value of apelido
     *
     * @param  string  $apelido
     *
     */
    public function setApelido(string $apelido = null)
    {
        $this->apelido = $apelido;
    }

    /**
     * Get the value of dataNascimento
     *
     * @return  string
     */
    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    /**
     * Set the value of dataNascimento
     *
     * @param  string  $dataNascimento
     *
     */
    public function setDataNascimento(string $dataNascimento)
    {
        $this->dataNascimento = $dataNascimento;
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
}
