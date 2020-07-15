<?php

namespace App\Http\Models;

class Pais extends TObject
{
    /**
     * @var string
     */
    protected $pais;

    /**
     * @var string
     */
    protected $sigla;

    /**
     * @var string
     */
    protected $ddi;

    public function __construct()
    {
        $this->pais = '';
        $this->sigla = '';
        $this->ddi = '';
    }

    /**
     * Get the value of pais
     *
     * @return  string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set the value of pais
     *
     * @param  string  $pais
     *
     */
    public function setPais(string $pais)
    {
        $this->pais = $pais;
    }

    /**
     * Get the value of sigla
     *
     * @return  string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set the value of sigla
     *
     * @param  string  $sigla
     *
     */
    public function setSigla(string $sigla)
    {
        $this->sigla = $sigla;
    }

    /**
     * Get the value of ddi
     *
     * @return  string
     */
    public function getDDI()
    {
        return $this->ddi;
    }

    /**
     * Set the value of ddi
     *
     * @param  string  $ddi
     *
     */
    public function setDDI(string $ddi)
    {
        $this->ddi = $ddi;
    }
}
