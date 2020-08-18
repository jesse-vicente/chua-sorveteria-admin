<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Models\Fornecedor;

use App\Http\Dao\DaoCidade;
use App\Http\Dao\DaoCondicaoPagamento;

class DaoFornecedor implements Dao {

    private DaoCidade $daoCidade;
    private DaoCondicaoPagamento $daoCondicaoPagamento;

    public function __construct()
    {
        $this->daoCidade = new DaoCidade();
        $this->daoCondicaoPagamento = new DaoCondicaoPagamento();
    }

    public function all() {
        $fornecedores = $this->search();
        return $fornecedores;
    }

    public function create(array $dados) {
        $fornecedor = new Fornecedor();

        if (isset($dados["id"])) {
            $fornecedor->setId($dados["id"]);
            $fornecedor->setDataCadastro($dados["data_cadastro"] ?? null);
            $fornecedor->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        if (isset($dados["tipo_pessoa"]))
            $fornecedor->setTipo($dados["tipo_pessoa"]);

        $fornecedor->setRazaoSocial($dados["fornecedor"]);
        $fornecedor->setNomeFantasia($dados["nome_fantasia"]);
        $fornecedor->setEndereco($dados["endereco"]);
        $fornecedor->setNumero((int) $dados["numero"]);
        $fornecedor->setComplemento($dados["complemento"]);
        $fornecedor->setBairro($dados["bairro"]);
        $fornecedor->setCEP($dados["cep"]);
        $fornecedor->setTelefone($dados["telefone"]);
        $fornecedor->setWhatsapp($dados["whatsapp"]);
        $fornecedor->setEmail($dados["email"]);
        $fornecedor->setWebSite($dados["website"]);
        $fornecedor->setContato($dados["contato"]);
        $fornecedor->setCpfCnpj($dados["cpf_cnpj"]);
        $fornecedor->setRgInscricaoEstadual($dados["rg_inscricao_estadual"]);
        $fornecedor->setValorCredito((float) $dados["valor_credito"]);
        $fornecedor->setObservacoes($dados["observacoes"]);

        $cidade = $this->daoCidade->find($dados["cidade_id"]);
        $condicaoPagamento = $this->daoCondicaoPagamento->find($dados["condicao_pagamento_id"]);

        $fornecedor->setCidade($cidade);
        $fornecedor->setCondicaoPagamento($condicaoPagamento);

        return $fornecedor;
    }

    public function store($fornecedor) {
        DB::beginTransaction();

        try {
            $dados = $this->fillData($fornecedor);

            DB::table('fornecedores')->insert($dados);
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
            $fornecedor = $this->create($request->all());

            $dados = $this->fillData($fornecedor);

            DB::table('fornecedores')->where('id', $id)->update($dados);

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function delete($id) {
        DB::beginTransaction();

        try {
            DB::table('fornecedores')->delete($id);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function find(int $id) {
        $dados = DB::table('fornecedores')->where('id', $id)->first();

        if ($dados)
            return $this->create(get_object_vars($dados));

        return null;
    }

    public function search($q = null)
    {
        $fornecedores = array();

        if (!is_null($q)) {
            $dados = DB::table('fornecedores')->where('id', $q)->orWhere('fornecedor', 'like', '$q')->first();

            if ($dados)
                $fornecedores[0] = $this->create(get_object_vars($dados));
        }
        else {
            $dados = DB::table('fornecedores')->limit(10)->get();

            foreach ($dados as $obj) {
                $fornecedor = $this->create(get_object_vars($obj));
                array_push($fornecedores, $fornecedor);
            }
        }

        return $fornecedores;
    }

    public function fillData(Fornecedor $fornecedor) {

        $dados = [
            'id'                    => $fornecedor->getId(),
            'fornecedor'            => $fornecedor->getRazaoSocial(),
            'nome_fantasia'         => $fornecedor->getNomeFantasia(),
            'cep'                   => $fornecedor->getCEP(),
            'endereco'              => $fornecedor->getEndereco(),
            'numero'                => $fornecedor->getNumero(),
            'complemento'           => $fornecedor->getComplemento(),
            'bairro'                => $fornecedor->getBairro(),
            'cidade_id'             => $fornecedor->getCidade()->getId(),
            'telefone'              => $fornecedor->getTelefone(),
            'whatsapp'              => $fornecedor->getWhatsapp(),
            'email'                 => $fornecedor->getEmail(),
            'website'               => $fornecedor->getWebSite(),
            'contato'               => $fornecedor->getContato(),
            'cpf_cnpj'              => $fornecedor->getCpfCnpj(),
            'rg_inscricao_estadual' => $fornecedor->getRgInscricaoEstadual(),
            'condicao_pagamento_id' => $fornecedor->getCondicaoPagamento()->getId(),
            'valor_credito'         => $fornecedor->getValorCredito(),
            'observacoes'           => $fornecedor->getObservacoes(),
        ];

        if ($fornecedor->getTipo())
            $dados['tipo_pessoa'] = $fornecedor->getTipo();

        return $dados;
    }

    public function fillForModal(Fornecedor $fornecedor) {

        $dados = [
            'id'       => $fornecedor->getId(),
            'nome'     => $fornecedor->getRazaoSocial(),
            'whatsapp' => $fornecedor->getWhatsapp(),
        ];

        return $dados;
    }
}
