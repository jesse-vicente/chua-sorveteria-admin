<?php

namespace App\Http\Models;

class Produto extends TObject
{
    /**
     * @var string
     */
    protected $produto;

    /**
     * @var string
     */
    protected $unidade;

    /**
     * @var Fornecedor $fornecedor
     */
    protected $fornecedor;

    /**
     * @var Categoria $categoria
     */
    protected $categoria;

    /**
     * @var int
     */
    protected $estoque;

    /**
     * @var float
     */
    protected $precoCusto;

    /**
     * @var float
     */
    protected $precoVenda;

    /**
     * @var float
     */
    protected $custoUltimaCompra;

    /**
     * @var string
     */
    protected $dataUltimaCompra;

    /**
     * @var string
     */
    protected $dataUltimaVenda;

    public function __construct()
    {
        $this->produto           = '';
        $this->unidade           = '';
        $this->estoque           = null;
        $this->precoCusto        = null;
        $this->precoVenda        = null;
        $this->custoUltimaCompra = null;
        $this->dataUltimaCompra  = '';
        $this->dataUltimaVenda   = '';
        $this->fornecedor = new Fornecedor();
        $this->categoria  = new Categoria();
    }

    /**
     * Get the value of produto
     *
     * @return  string
     */
    public function getProduto()
    {
        return $this->produto;
    }

    /**
     * Set the value of produto
     *
     * @param  string  $produto
     *
     */
    public function setProduto(string $produto)
    {
        $this->produto = $produto;
    }

    /**
     * Get the value of unidade
     *
     * @return  string
     */
    public function getUnidade()
    {
        return $this->unidade;
    }

    /**
     * Set the value of unidade
     *
     * @param  string  $unidade
     *
     */
    public function setUnidade(string $unidade)
    {
        $this->unidade = $unidade;
    }

    /**
     * Get $fornecedor
     *
     * @return  Fornecedor
     */
    public function getFornecedor()
    {
        return $this->fornecedor;
    }

    /**
     * Set $fornecedor
     *
     * @param  Fornecedor  $fornecedor  $fornecedor
     *
     */
    public function setFornecedor(Fornecedor $fornecedor)
    {
        $this->fornecedor = $fornecedor;
    }

    /**
     * Get $categoria
     *
     * @return  Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set $categoria
     *
     * @param  Categoria  $categoria  $categoria
     *
     */
    public function setCategoria(Categoria $categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * Get the value of estoque
     *
     * @return  int
     */
    public function getEstoque()
    {
        return $this->estoque;
    }

    /**
     * Set the value of estoque
     *
     * @param  int  $estoque
     *
     */
    public function setEstoque(int $estoque = null)
    {
        $this->estoque = $estoque;
    }

    /**
     * Get the value of precoCusto
     *
     * @return  float
     */
    public function getPrecoCusto()
    {
        return $this->precoCusto;
    }

    /**
     * Set the value of precoCusto
     *
     * @param  float  $precoCusto
     *
     */
    public function setPrecoCusto(float $precoCusto = null)
    {
        $this->precoCusto = $precoCusto;
    }

    /**
     * Get the value of precoVenda
     *
     * @return  float
     */
    public function getPrecoVenda()
    {
        return $this->precoVenda;
    }

    /**
     * Set the value of precoVenda
     *
     * @param  float  $precoVenda
     *
     */
    public function setPrecoVenda(float $precoVenda)
    {
        $this->precoVenda = $precoVenda;
    }

    /**
     * Get the value of custoUltimaCompra
     *
     * @return  float
     */
    public function getCustoUltimaCompra()
    {
        return $this->custoUltimaCompra;
    }

    /**
     * Set the value of custoUltimaCompra
     *
     * @param  float  $custoUltimaCompra
     *
     */
    public function setCustoUltimaCompra(float $custoUltimaCompra = null)
    {
        $this->custoUltimaCompra = $custoUltimaCompra;
    }

    /**
     * Get the value of dataUltimaCompra
     *
     * @return  string
     */
    public function getDataUltimaCompra()
    {
        return $this->dataUltimaCompra;
    }

    /**
     * Set the value of dataUltimaCompra
     *
     * @param  string  $dataUltimaCompra
     *
     */
    public function setDataUltimaCompra(string $dataUltimaCompra = null)
    {
        $this->dataUltimaCompra = $dataUltimaCompra;
    }

    /**
     * Get the value of dataUltimaVenda
     *
     * @return  string
     */
    public function getDataUltimaVenda()
    {
        return $this->dataUltimaVenda;
    }

    /**
     * Set the value of dataUltimaVenda
     *
     * @param  string  $dataUltimaVenda
     *
     */
    public function setDataUltimaVenda(string $dataUltimaVenda = null)
    {
        $this->dataUltimaVenda = $dataUltimaVenda;
    }
}
