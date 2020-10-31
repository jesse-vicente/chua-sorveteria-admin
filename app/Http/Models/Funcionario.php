<?php

namespace App\Http\Models;

class Funcionario extends Pessoa
{
    /**
     * @var string
     */
    protected $apelido;

    /**
     * @var string
     */
    protected $sexo;

    /**
     * @var string
     */
    protected $dataNascimento;

    /**
     * @var string
     */
    protected $cargo;

    /**
     * @var float
     */
    protected $salario;

    /**
     * @var string
     */
    protected $dataAdmissao;

    /**
     * @var string
     */
    protected $dataDemissao;

    public function __construct()
    {
        $this->apelido        = '';
        $this->sexo           = '';
        $this->cargo          = '';
        $this->salario        = 0.00;
        $this->dataNascimento = '';
        $this->dataAdmissao   = null;
        $this->dataDemissao   = null;
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
     * Get the value of sexo
     *
     * @return  string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set the value of sexo
     *
     * @param  string  $sexo
     *
     */
    public function setSexo(string $sexo)
    {
        $this->sexo = $sexo;
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
     * Get the value of cargo
     *
     * @return  string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set the value of cargo
     *
     * @param  string  $cargo
     *
     */
    public function setCargo(string $cargo)
    {
        $this->cargo = $cargo;
    }

    /**
     * Get the value of salario
     *
     * @return  float
     */
    public function getSalario()
    {
        return $this->salario;
    }

    /**
     * Set the value of salario
     *
     * @param  float  $salario
     *
     */
    public function setSalario(float $salario)
    {
        $this->salario = $salario;
    }

    /**
     * Get the value of dataAdmissao
     *
     * @return  string
     */
    public function getDataAdmissao()
    {
        return $this->dataAdmissao;
    }

    /**
     * Set the value of dataAdmissao
     *
     * @param  string  $dataAdmissao
     *
     */
    public function setDataAdmissao(string $dataAdmissao)
    {
        $this->dataAdmissao = $dataAdmissao;
    }

    /**
     * Get the value of dataDemissao
     *
     * @return  string
     */
    public function getDataDemissao()
    {
        return $this->dataDemissao ?? NULL;
    }

    /**
     * Set the value of dataDemissao
     *
     * @param  string  $dataDemissao
     *
     */
    public function setDataDemissao(string $dataDemissao = null)
    {
        $this->dataDemissao = $dataDemissao;
    }
}
