<?php

namespace App\Http\Models;

use App\Http\Models\Estado;

class Cidade extends TObject
{
    protected $cidade;
    protected $ddd;
    protected Estado $estado;

    public function __construct()
    {
        $this->cidade = '';
        $this->ddd = '';
        $this->estado = new Estado();
    }

    // SETTERS
    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function setDDD($ddd) {
        $this->ddd = $ddd;
    }

    public function setEstado(Estado $estado) {
        $this->estado = $estado;
    }

    // GETTERS
    public function getCidade() {
        return $this->cidade;
    }

    public function getDDD() {
        return $this->ddd;
    }

    public function getEstado() {
        return $this->estado;
    }
}
