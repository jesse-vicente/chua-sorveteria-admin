<?php

namespace App\Http\Models;

use App\Http\Models\Compra;
use App\Http\Models\Fornecedor;
use App\Http\Models\FormaPagamento;

use App\Http\Models\Funcionario;

class ContaPagar extends TObject
{
    /**
     * @var Compra
     */
    protected $compra;

    /**
     * @var Fornecedor
     */
    protected $fornecedor;

    /**
     * @var Funcionario
     */
    protected $funcionario;

    /**
     * @var FormaPagamento
     */
    protected $formaPagamento;

    /**
     * @var int
     */
    protected $parcela;

    /**
     * @var float
     */
    protected $valorParcela;

    /**
     * @var string
     */
    protected $dataVencimento;

    /**
     * @var string
     */
    protected $dataPagamento;

    /**
     * @var float
     */
    protected $juros;

    /**
     * @var float
     */
    protected $multa;

    /**
     * @var float
     */
    protected $desconto;

    /**
     * @var float
     */
    protected $valorPago;

    /**
     * @var string
     */
    protected $status;

    /**
     * Get the value of compra
     *
     * @return  Compra
     */
    public function getCompra()
    {
        return $this->compra;
    }

    /**
     * Set the value of compra
     *
     * @param  Compra  $compra
     *
     */
    public function setCompra(Compra $compra)
    {
        $this->compra = $compra;
    }

    /**
     * Get the value of fornecedor
     *
     * @return  Fornecedor
     */
    public function getFornecedor()
    {
        return $this->fornecedor;
    }

    /**
     * Set the value of fornecedor
     *
     * @param  Fornecedor  $fornecedor
     *
     */
    public function setFornecedor(Fornecedor $fornecedor)
    {
        $this->fornecedor = $fornecedor;
    }

    /**
     * Get the value of funcionario
     *
     * @return  Funcionario
     */
    public function getFuncionario()
    {
        return $this->funcionario;
    }

    /**
     * Set the value of funcionario
     *
     * @param  Funcionario  $funcionario
     *
     */
    public function setFuncionario(Funcionario $funcionario)
    {
        $this->funcionario = $funcionario;
    }

    /**
     * Get the value of formaPagamento
     *
     * @return  FormaPagamento
     */
    public function getFormaPagamento()
    {
        return $this->formaPagamento;
    }

    /**
     * Set the value of formaPagamento
     *
     * @param  FormaPagamento  $formaPagamento
     *
     */
    public function setFormaPagamento(FormaPagamento $formaPagamento)
    {
        $this->formaPagamento = $formaPagamento;
    }

    /**
     * Get the value of parcela
     *
     * @return  int
     */
    public function getParcela()
    {
        return $this->parcela;
    }

    /**
     * Set the value of parcela
     *
     * @param  int  $parcela
     *
     */
    public function setParcela(int $parcela)
    {
        $this->parcela = $parcela;
    }

    /**
     * Get the value of valorParcela
     *
     * @return  float
     */
    public function getValorParcela()
    {
        return $this->valorParcela;
    }

    /**
     * Set the value of valorParcela
     *
     * @param  float  $valorParcela
     *
     */
    public function setValorParcela(float $valorParcela)
    {
        $this->valorParcela = $valorParcela;
    }

    /**
     * Get the value of dataVencimento
     *
     * @return  string
     */
    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    /**
     * Set the value of dataVencimento
     *
     * @param  string  $dataVencimento
     *
     */
    public function setDataVencimento(string $dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;
    }

    /**
     * Get the value of dataPagamento
     *
     * @return  string
     */
    public function getDataPagamento()
    {
        return $this->dataPagamento ?? date('Y-m-d');
    }

    /**
     * Set the value of dataPagamento
     *
     * @param  string  $dataPagamento
     *
     */
    public function setDataPagamento(string $dataPagamento = null)
    {
        $this->dataPagamento = $dataPagamento;
    }

    /**
     * Get the value of juros
     *
     * @return  float
     */
    public function getJuros()
    {
        return $this->juros;
    }

    /**
     * Set the value of juros
     *
     * @param  float  $juros
     *
     */
    public function setJuros(float $juros = null)
    {
        $this->juros = $juros;
    }

    /**
     * Get the value of multa
     *
     * @return  float
     */
    public function getMulta()
    {
        return $this->multa;
    }

    /**
     * Set the value of multa
     *
     * @param  float  $multa
     *
     */
    public function setMulta(float $multa = null)
    {
        $this->multa = $multa;
    }

    /**
     * Get the value of desconto
     *
     * @return  float
     */
    public function getDesconto()
    {
        return $this->desconto;
    }

    /**
     * Set the value of desconto
     *
     * @param  float  $desconto
     *
     */
    public function setDesconto(float $desconto = null)
    {
        $this->desconto = $desconto;
    }

    /**
     * Get the value of valorPago
     *
     * @return  float
     */
    public function getValorPago()
    {
        return $this->valorPago;
    }

    /**
     * Set the value of valorPago
     *
     * @param  float  $valorPago
     *
     */
    public function setValorPago(float $valorPago)
    {
        $this->valorPago = $valorPago;
    }

    /**
     * Get the value of status
     *
     * @return  string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  string  $status
     *
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of primaryKey
     *
     * @return  string
     */
    public function getPrimaryKey()
    {
        return $this->compra->getPrimaryKey() . '-' . $this->getParcela();
    }
}
