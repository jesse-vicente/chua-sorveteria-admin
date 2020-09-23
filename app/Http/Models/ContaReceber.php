<?php

namespace App\Http\Models;

use App\Http\Models\Venda;
use App\Http\Models\Cliente;
use App\Http\Models\FormaPagamento;

use App\Http\Models\Funcionario;

class ContaReceber extends TObject
{
    /**
     * @var Venda
     */
    protected $venda;

    /**
     * @var Cliente
     */
    protected $cliente;

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
    protected $valorPago;

    /**
     * @var string
     */
    protected $status;

    /**
     * Get the value of venda
     *
     * @return  Venda
     */
    public function getVenda()
    {
        return $this->venda;
    }

    /**
     * Set the value of venda
     *
     * @param  Venda  $venda
     *
     */
    public function setVenda(Venda $venda)
    {
        $this->venda = $venda;
    }

    /**
     * Get the value of cliente
     *
     * @return  Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set the value of cliente
     *
     * @param  Cliente  $cliente
     *
     */
    public function setCliente(Cliente $cliente)
    {
        $this->cliente = $cliente;
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
        return $this->venda->getPrimaryKey();
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
}
