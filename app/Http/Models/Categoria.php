<?php

namespace App\Http\Models;

class Categoria extends TObject
{
    /**
     * @var string
     */
    protected $categoria;

    /**
     * Get the value of categoria
     *
     * @return  string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set the value of categoria
     *
     * @param  string  $categoria
     *
     */
    public function setCategoria(string $categoria)
    {
        $this->categoria = $categoria;
    }
}
