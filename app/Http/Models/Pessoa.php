<?php

namespace App\Http\Models;

use App\Http\Models\Cidade;

class Pessoa extends TObject
{
    /**
     * @var string
     */
    protected $nome;

    /**
     * @var string
     */
    protected $tipo;

    /**
     * @var string
     */
    protected $endereco;

    /**
     * @var int
     */
    protected $numero;

    /**
     * @var string
     */
    protected $complemento;

    /**
     * @var string
     */
    protected $bairro;

    /**
     * @var string
     */
    protected $cep;

    /**
     * @var string
     */
    protected $telefone;

    /**
     * @var string
     */
    protected $whatsapp;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $cpfCnpj;

    /**
     * @var string
     */
    protected $rgInscricaoEstadual;

    /**
     * @var string
     */
    protected $observacoes;

    /**
     * @var Cidade
     */
    protected $cidade;

    public function __construct()
    {
        $this->nome                = '';
        $this->tipo                = '';
        $this->numero              = 0;
        $this->complemento         = '';
        $this->bairro              = '';
        $this->cep                 = '';
        $this->telefone            = '';
        $this->whatsapp            = '';
        $this->email               = '';
        $this->cpfCnpj             = '';
        $this->rgInscricaoEstadual = '';
        $this->observacoes         = '';
        $this->cidade              = new Cidade();
    }

    /**
     * Get the value of nome
     *
     * @return  string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     *
     * @param  string  $nome
     *
     */
    public function setNome(string $nome)
    {
        $this->nome = $nome;
    }

    /**
     * Get the value of tipo
     *
     * @return  string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @param  string  $tipo
     *
     */
    public function setTipo(string $tipo = null)
    {
        $this->tipo = $tipo;
    }

    /**
     * Get the value of endereco
     *
     * @return  string
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set the value of endereco
     *
     * @param  string  $endereco
     *
     */
    public function setEndereco(string $endereco)
    {
        $this->endereco = $endereco;
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
     * Get the value of complemento
     *
     * @return  string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set the value of complemento
     *
     * @param  string  $complemento
     *
     */
    public function setComplemento(string $complemento = null)
    {
        $this->complemento = $complemento;
    }

    /**
     * Get the value of bairro
     *
     * @return  string
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * Set the value of bairro
     *
     * @param  string  $bairro
     *
     */
    public function setBairro(string $bairro)
    {
        $this->bairro = $bairro;
    }

    /**
     * Get the value of cep
     *
     * @return  string
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set the value of cep
     *
     * @param  string  $cep
     *
     */
    public function setCep(string $cep = null)
    {
        $this->cep = $cep;
    }

    /**
     * Get the value of telefone
     *
     * @return  string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set the value of telefone
     *
     * @param  string  $telefone
     *
     */
    public function setTelefone(string $telefone = null)
    {
        $this->telefone = $telefone;
    }

    /**
     * Get the value of whatsapp
     *
     * @return  string
     */
    public function getWhatsapp()
    {
        return $this->whatsapp;
    }

    /**
     * Set the value of whatsapp
     *
     * @param  string  $whatsapp
     *
     */
    public function setWhatsapp(string $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function getTelefonesContato()
    {
        $contatos = $this->telefone ? $this->telefone . ' / ' : '';
        $contatos .= $this->whatsapp;

        return $contatos;
    }

    /**
     * Get the value of email
     *
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     *
     */
    public function setEmail(string $email = null)
    {
        $this->email = $email;
    }

    /**
     * Get the value of cpfCnpj
     *
     * @return  string
     */
    public function getCpfCnpj()
    {
        return $this->cpfCnpj;
    }

    /**
     * Set the value of cpfCnpj
     *
     * @param  string  $cpfCnpj
     *
     */
    public function setCpfCnpj(string $cpfCnpj)
    {
        $this->cpfCnpj = $cpfCnpj;
    }

    /**
     * Get the value of rgInscricaoEstadual
     *
     * @return  string
     */
    public function getRgInscricaoEstadual()
    {
        return $this->rgInscricaoEstadual;
    }

    /**
     * Set the value of rgInscricaoEstadual
     *
     * @param  string  $rgInscricaoEstadual
     *
     */
    public function setRgInscricaoEstadual(string $rgInscricaoEstadual = null)
    {
        $this->rgInscricaoEstadual = $rgInscricaoEstadual;
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
    public function setObservacoes(string $observacoes = null)
    {
        $this->observacoes = $observacoes;
    }

    /**
     * Get the value of cidade
     *
     * @return  Cidade
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set the value of cidade
     *
     * @param  Cidade  $cidade
     *
     */
    public function setCidade(Cidade $cidade)
    {
        $this->cidade = $cidade;
    }
}
