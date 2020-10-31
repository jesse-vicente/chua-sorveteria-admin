<?php

namespace App\Http\Models;

use App\Http\Models\Produto;

class ProdutoVenda
{
    /**
     * @var Produto
     */
    protected $produto;

    /**
     * @var float
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
     * @return  float
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set the value of quantidade
     *
     * @param  float  $quantidade
     *
     */
    public function setQuantidade(float $quantidade)
    {
        $this->quantidade = $quantidade;
    }
}
