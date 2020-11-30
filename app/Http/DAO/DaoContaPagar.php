<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Http\Dao\DaoFornecedor;
use App\Http\Dao\DaoCompra;
use App\Http\Dao\DaoFuncionario;
use App\Http\Dao\DaoFormaPagamento;

use App\Http\Models\Compra;
use App\Http\Models\ContaPagar;

class DaoContaPagar implements Dao {

    private DaoFornecedor $daoFornecedor;
    private DaoCompra $daoCompra;
    private DaoFuncionario $daoFuncionario;
    private DaoFormaPagamento $daoFormaPagamento;

    public function __construct()
    {
        $this->daoCompra = new DaoCompra();
        $this->daoFornecedor = new DaoFornecedor();
        $this->daoFuncionario = new DaoFuncionario();
        $this->daoFormaPagamento = new DaoFormaPagamento();
    }

    public function all(bool $model = false, $filtro = array()) {
        if ($filtro) {
            if ($filtro['valor'] == 'Em aberto') {
                $total = DB::table('contas_pagar')
                           ->where($filtro['chave'], $filtro['valor'])
                           ->where('data_cadastro', '>=', Carbon::today()->toDateTimeString())
                           ->get()
                           ->count();

                return $total;
            }
        }

        $itens = DB::table('contas_pagar')
                   ->orderBy('data_cadastro', 'desc')
                   ->orderBy('parcela')
                   ->get();

        if (!$model)
            return $itens;

        $contas = array();

        foreach ($itens as $item) {
            $conta = $this->create(get_object_vars($item));
            array_push($contas, $conta);
        }

        return $contas;
    }

    public function create(array $dados) {
        $conta = new ContaPagar();

        if (isset($dados['num_nota'])) {
            $conta->setDataCadastro($dados['data_cadastro'] ?? null);
            $conta->setDataAlteracao($dados['data_alteracao'] ?? null);
        }

        $status = $dados['status'] ?? 'Em aberto';
        $conta->setStatus($status);

        // Dados nota
        $numero = $dados['num_nota'];
        $serie = $dados['serie'];
        $modelo = $dados['modelo'];
        $fornecedorId = $dados['fornecedor_id'];

        $key = "$numero-$serie-$modelo-$fornecedorId";

        $compra = $this->daoCompra->findByPrimaryKey($key, true);

        if ($compra)
            $conta->setCompra($compra);

        $conta->setNumeroNota($numero);
        $conta->setModelo($modelo);
        $conta->setSerie($serie);

        $conta->setDataEmissao($dados['data_emissao']);;

        $juros        = floatval($dados['juros']) ?? null;
        $multa        = floatval($dados['multa']) ?? null;
        $desconto     = floatval($dados['desconto']) ?? null;
        $valorParcela = floatval($dados['valor_parcela']);

        $valorPago = $valorParcela;

        if ($juros) {
            $totalJuros = ($valorPago / 100) * $juros;
            $valorPago += $totalJuros;
        }

        if ($multa)
            $valorPago += $multa;

        if ($desconto)
            $valorPago -= $desconto;

        $conta->setParcela($dados['parcela']);
        $conta->setValorParcela($valorParcela);

        $conta->setDataVencimento($dados['data_vencimento']);
        $conta->setDataPagamento($dados['data_pagamento']);

        $conta->setJuros($juros);
        $conta->setMulta($multa);
        $conta->setDesconto($desconto);
        $conta->setValorPago($valorPago);

        $fornecedor = $this->daoFornecedor->findById($dados['fornecedor_id'], true);
        // $funcionario = $this->daoFornecedor->findById($dados['funcionario_id'], true);
        $formaPagamento = $this->daoFormaPagamento->findById($dados['forma_pagamento_id'], true);

        $conta->setFornecedor($fornecedor);
        // $conta->setFuncionario($funcionario);
        $conta->setFormaPagamento($formaPagamento);

        return $conta;
    }

    public function store($contaPagar) {
        DB::beginTransaction();

        try {
            $dadosContasPagar = $this->getData($contaPagar);

            // dd($dadosContasPagar);

            DB::table('contas_pagar')->insert($dadosContasPagar);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return false;
        }
    }

    public function update(Request $request, $key) {
        DB::beginTransaction();

        try {
            $contaPagar = $this->create($request->all());
            // $contaPagar = $this->findByPrimaryKey($key, true);

            $compra = $contaPagar->getCompra();

            if ($compra) {
                $compraPk = $compra->getPrimaryKey();

                DB::table('compras')
                  ->where('num_nota',      $compraPk->numero)
                  ->where('serie',         $compraPk->serie)
                  ->where('modelo',        $compraPk->modelo)
                  ->where('fornecedor_id', $compraPk->idFornecedor)
                  ->update(['status' => $request->status == 'Pago' ? 'Ativo' : 'Emitido']);
            }

            $dadosContaPagar = $this->getData($contaPagar);

            if ($contaPagar->getStatus() == 'Em aberto') {
                $dadosContaPagar['juros'] = null;
                $dadosContaPagar['multa'] = null;
                $dadosContaPagar['desconto'] = null;
                $dadosContaPagar['valor_pago'] = null;
            }

            DB::table('contas_pagar')
              ->where('num_nota',      $contaPagar->getNumeroNota())
              ->where('serie',         $contaPagar->getSerie())
              ->where('modelo',        $contaPagar->getModelo())
              ->where('fornecedor_id', $contaPagar->getFornecedor()->getId())
              ->where('parcela',       $contaPagar->getParcela())
              ->update($dadosContaPagar);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return false;
        }
    }

    public function delete($id) {
        DB::beginTransaction();

        try {
            DB::table('compras')->delete($id);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function findByPrimaryKey(string $pk, bool $model = false) {
        $key = explode('-', $pk);

        if (count($key) != 5)
            return [];

        $numero     = $key[0];
        $serie      = $key[1];
        $modelo     = $key[2];
        $fornecedor = $key[3];
        $parcela    = $key[4];

        if (!$model) {
            $dados = DB::table('contas_pagar')
                       ->where('num_nota', $numero)
                       ->where('serie', $serie)
                       ->where('modelo', $modelo)
                       ->where('fornecedor_id', $fornecedor)
                       ->where('parcela', $parcela)
                       ->first();

            return $dados;
        }

        $dados = DB::table('contas_pagar')
                         ->where('num_nota', $numero)
                         ->where('serie', $serie)
                         ->where('modelo', $modelo)
                         ->where('fornecedor_id', $fornecedor)
                         ->where('parcela', $parcela)
                         ->first();

        if ($dados) {
            $conta = $this->create(get_object_vars($dados));
            return $conta;
        }

        return [];
    }

    public function findById(int $id, bool $model = false)
    {
        //
    }

    public function getData(ContaPagar $contaPagar) {
        $compra = $contaPagar->getCompra();

        $dados = array(
            'modelo'             => $compra ? $compra->getModelo() : $contaPagar->getModelo(),
            'serie'              => $compra ? $compra->getSerie() : $contaPagar->getSerie(),
            'num_nota'           => $compra ? $compra->getNumeroNota() : $contaPagar->getNumeroNota(),
            'status'             => $contaPagar->getStatus(),
            'fornecedor_id'      => $contaPagar->getFornecedor()->getId(),
            //'funcionario_id'     => $contaPagar->getFuncionario()->getId(),
            'forma_pagamento_id' => $contaPagar->getFormaPagamento()->getId(),
            'parcela'            => $contaPagar->getParcela(),
            'valor_parcela'      => $contaPagar->getValorParcela(),
            'data_emissao'       => $contaPagar->getDataEmissao(),
            'data_vencimento'    => $contaPagar->getDataVencimento(),
            'data_pagamento'     => $contaPagar->getDataPagamento(),
            'juros'              => $contaPagar->getJuros(),
            'multa'              => $contaPagar->getMulta(),
            'desconto'           => $contaPagar->getDesconto(),
            'valor_pago'         => $contaPagar->getValorPago(),
        );

        return $dados;
    }

    public function getProductsData(Compra $compra) {
        $produtos = array();

        foreach ($compra->getProdutos() as $produto) {

            $dadosProduto = array(
                'num_nota'   => $compra->getNumeroNota(),
                'serie'      => $compra->getSerie(),
                'modelo'     => $compra->getModelo(),
                'produto_id' => $produto->getProduto()->getId(),
                'quantidade' => $produto->getQuantidade(),
            );

            array_push($produtos, $dadosProduto);
        }

        return $produtos;
    }

    public function getDuplicatesData(Compra $compra) {
        $duplicatas = array();

        foreach ($compra->getContasPagar() as $i => $duplicata) {
            $dadosDuplicata = array(
                'num_nota'           => $compra->getNumeroNota(),
                'serie'              => $compra->getSerie(),
                'modelo'             => $compra->getModelo(),
                'fornecedor_id'      => $compra->getFornecedor()->getId(),
                /*'funcionario_id'   => $compra->getFuncionario()->getId(),*/
                'forma_pagamento_id' => $duplicata->getFormaPagamento()->getId(),
                'parcela'            => $duplicata->getParcela(),
                'valor_parcela'      => $duplicata->getValorParcela(),
                'data_vencimento'    => date('Y-m-d', strtotime($duplicata->getDataVencimento())),
                'data_pagamento'     => $duplicata->getDataPagamento(),
                'juros'              => $duplicata->getJuros(),
                'multa'              => $duplicata->getMulta(),
                'desconto'           => $duplicata->getDesconto(),
                'valor_pago'         => $duplicata->getValorPago(),
                'status'             => $duplicata->getStatus(),
            );

            array_push($duplicatas, $dadosDuplicata);
        }

        return $duplicatas;
    }
}
