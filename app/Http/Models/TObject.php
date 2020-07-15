<?php

namespace App\Http\Models;

use Illuminate\Support\Carbon;

class TObject
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $dataCadastro;

    /**
     * @var string
     */
    protected $dataAlteracao;

    public function __construct()
    {
        $this->id            = 0;
        $this->dataCadastro  = null;
        $this->dataAlteracao = null;
    }

    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of dataCadastro
     *
     * @return  string
     */
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    /**
     * Set the value of dataCadastro
     *
     * @param  string  $dataCadastro
     *
     */
    public function setDataCadastro(string $dataCadastro = null)
    {
        $data = Carbon::parse($dataCadastro)->toDate()->format('d/M/Y');
        $hora = Carbon::parse($dataCadastro)->toTimeString('minute');

        $this->dataCadastro = $data . ' às ' . $hora;
    }

    /**
     * Get the value of dataAlteracao
     *
     * @return  string
     */
    public function getDataAlteracao()
    {
        return $this->dataAlteracao;
    }

    /**
     * Set the value of dataAlteracao
     *
     * @param  string  $dataAlteracao
     *
     */
    public function setDataAlteracao(string $dataAlteracao = null)
    {
        $data = Carbon::parse($dataAlteracao)->toDate()->format('d/M/Y');
        $hora = Carbon::parse($dataAlteracao)->toTimeString('minute');

        $this->dataAlteracao = $data . ' às ' . $hora;
    }
}
