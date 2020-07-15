<?php

namespace App\Http\Models;

use App\Http\Models\CondicaoPagamento;

class Fornecedor extends Pessoa
{
    /**
     * @var string
     */
    protected $razaoSocial;

    /**
     * @var string
     */
    protected $nomeFantasia;

    /**
     * @var string
     */
    protected $webSite;

    /**
     * @var string
     */
    protected $contato;

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
        $this->razaoSocial       = '';
        $this->nomeFantasia      = '';
        $this->webSite           = '';
        $this->contato           = '';
        $this->condicaoPagamento = new CondicaoPagamento();
        $this->valorCredito      = 0;
    }

    /**
     * Get the value of razaoSocial
     *
     * @return  string
     */
    public function getRazaoSocial()
    {
        return $this->razaoSocial;
    }

    /**
     * Set the value of razaoSocial
     *
     * @param  string  $razaoSocial
     *
     */
    public function setRazaoSocial(string $razaoSocial)
    {
        $this->razaoSocial = $razaoSocial;
    }

    /**
     * Get the value of nomeFantasia
     *
     * @return  string
     */
    public function getNomeFantasia()
    {
        return $this->nomeFantasia;
    }

    /**
     * Set the value of nomeFantasia
     *
     * @param  string  $nomeFantasia
     *
     */
    public function setNomeFantasia(string $nomeFantasia = null)
    {
        $this->nomeFantasia = $nomeFantasia;
    }

    /**
     * Get the value of webSite
     *
     * @return  string
     */
    public function getWebSite()
    {
        return $this->webSite;
    }

    /**
     * Set the value of webSite
     *
     * @param  string  $webSite
     *
     */
    public function setWebSite(string $webSite = null)
    {
        $this->webSite = $webSite;
    }

    /**
     * Get the value of contato
     *
     * @return  string
     */
    public function getContato()
    {
        return $this->contato;
    }

    /**
     * Set the value of contato
     *
     * @param  string  $contato
     *
     */
    public function setContato(string $contato = null)
    {
        $this->contato = $contato;
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
     * Get the value of valorCredito
     *
     * @return  float
     */
    public function getValorCredito()
    {
        return $this->valorCredito;
    }

    /**
     * Set the value of valorCredito
     *
     * @param  float  $valorCredito
     *
     */
    public function setValorCredito(float $valorCredito = 0)
    {
        $this->valorCredito = $valorCredito;
    }
}
