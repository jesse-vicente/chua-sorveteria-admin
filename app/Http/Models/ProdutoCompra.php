<?php

namespace App\Http\Models;

use App\Http\Models\Produto;

class ProdutoCompra
{
    /**
     * @var Produto
     */
    protected $produto;

    /**
     * @var int
     */
    protected $quantidade;

    /**
     * Get the value of produto
     *
     * @return  Produto
     */
    public function getProduto()
    {
        return $this->produto;
    }

    /**
     * Set the value of produto
     *
     * @param  Produto  $produto
     *
     */
    public function setProduto(Produto $produto)
    {
        $this->produto = $produto;
    }

    /**
     * Get the value of quantidade
     *
     * @return  int
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set the value of quantidade
     *
     * @param  int  $quantidade
     *
     */
    public function setQuantidade(int $quantidade)
    {
        $this->quantidade = $quantidade;
    }
}
