<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Dao\DaoCidade;
use App\Http\Dao\DaoCondicaoPagamento;

use App\Http\Models\Cliente;

class DaoCliente implements Dao {

    private DaoCidade $daoCidade;
    private DaoCondicaoPagamento $daoCondicaoPagamento;

    public function __construct()
    {
        $this->daoCidade = new DaoCidade();
        $this->daoCondicaoPagamento = new DaoCondicaoPagamento();
    }

    public function all(bool $model = false) {
        if (!$model)
            return DB::table('clientes')->get(['id', 'cliente', 'cpf']);

        $itens = DB::table('clientes')->get();

        $clientes = array();

        foreach ($itens as $item) {
            $cliente = $this->create(get_object_vars($item));
            array_push($clientes, $cliente);
        }

        return $clientes;
    }

    public function create(array $dados) {
        $cliente = new Cliente();

        if (isset($dados["id"])) {
            $cliente->setId($dados["id"]);
            $cliente->setDataCadastro($dados["data_cadastro"] ?? null);
            $cliente->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        $cliente->setNome($dados["cliente"]);
        $cliente->setApelido($dados["apelido"]);
        $cliente->setDataNascimento($dados["data_nascimento"]);
        $cliente->setEndereco($dados["endereco"]);
        $cliente->setNumero((int) $dados["numero"]);
        $cliente->setComplemento($dados["complemento"]);
        $cliente->setBairro($dados["bairro"]);
        $cliente->setCEP($dados["cep"]);
        $cliente->setTelefone($dados["telefone"]);
        $cliente->setWhatsapp($dados["whatsapp"]);
        $cliente->setEmail($dados["email"]);
        $cliente->setCpfCnpj($dados["cpf"]);
        $cliente->setRgInscricaoEstadual($dados["rg"]);
        $cliente->setObservacoes($dados["observacoes"]);

        $cidade = $this->daoCidade->findById($dados["cidade_id"], true);
        $condicaoPagamento = $this->daoCondicaoPagamento->findById($dados["condicao_pagamento_id"], true);

        $cliente->setCidade($cidade);
        $cliente->setCondicaoPagamento($condicaoPagamento);

        return $cliente;
    }

    public function store($cliente) {
        DB::beginTransaction();

        try {
            $dados = $this->getData($cliente);

            DB::table('clientes')->insert($dados);
            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return false;
        }
    }

    public function update(Request $request, $id) {
        DB::beginTransaction();

        try {
            $cliente = $this->create($request->all());

            $dados = $this->getData($cliente);

            DB::table('clientes')->where('id', $id)->update($dados);

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
            DB::table('clientes')->delete($id);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function findById(int $id, bool $model = false) {
        if (!$model)
            return DB::table('clientes')->get(['id', 'cliente', 'whatsapp'])->where('id', $id)->first();

        $dados = DB::table('clientes')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return $dados;
    }

    public function getData($cliente) {
        $dados = [
            'id'                    => $cliente->getId(),
            'cliente'               => $cliente->getNome(),
            'apelido'               => $cliente->getApelido(),
            'data_nascimento'       => $cliente->getDataNascimento(),
            'cpf'                   => $cliente->getCpfCnpj(),
            'rg'                    => $cliente->getRgInscricaoEstadual(),
            'cep'                   => $cliente->getCEP(),
            'endereco'              => $cliente->getEndereco(),
            'numero'                => $cliente->getNumero(),
            'complemento'           => $cliente->getComplemento(),
            'bairro'                => $cliente->getBairro(),
            'cidade_id'             => $cliente->getCidade()->getId(),
            'condicao_pagamento_id' => $cliente->getCondicaoPagamento()->getId(),
            'telefone'              => $cliente->getTelefone(),
            'whatsapp'              => $cliente->getWhatsapp(),
            'email'                 => $cliente->getEmail(),
            'observacoes'           => $cliente->getObservacoes(),
        ];

        return $dados;
    }
}
