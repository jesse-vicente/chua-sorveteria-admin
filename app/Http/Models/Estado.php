<?php

namespace App\Http\Models;

use App\Http\Models\Pais;

class Estado extends TObject
{
    protected $estado;
    protected $uf;
    protected Pais $pais;

    public function __construct()
    {
        $this->estado = '';
        $this->uf = '';
        $this->pais = new Pais();
    }

    // SETTERS
    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setUF($uf) {
        $this->uf = $uf;
    }

    public function setPais(Pais $pais) {
        $this->pais = $pais;
    }

    // GETTERS
    public function getEstado() {
        return $this->estado;
    }

    public function getUF() {
        return $this->uf;
    }

    public function getPais() {
        return $this->pais;
    }
}
