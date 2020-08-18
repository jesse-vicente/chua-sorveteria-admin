<?php

namespace App\Http\Dao;

use App\Http\Dao\Dao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Models\Funcionario;

class DaoFuncionario implements Dao {

    private DaoCidade $daoCidade;

    public function __construct()
    {
        $this->daoCidade = new DaoCidade();
    }

    public function all() {
        $funcionarios = $this->search();
        return $funcionarios;
    }

    public function create(array $dados) {
        $funcionario = new Funcionario();

        if (isset($dados["id"])) {
            $funcionario->setId($dados["id"]);
            $funcionario->setDataCadastro($dados["data_cadastro"] ?? null);
            $funcionario->setDataAlteracao($dados["data_alteracao"] ?? null);
        }

        $funcionario->setNome($dados["funcionario"]);
        $funcionario->setTipo("Física");
        $funcionario->setApelido($dados["apelido"]);
        $funcionario->setSexo($dados["sexo"]);
        $funcionario->setCEP($dados["cep"]);
        $funcionario->setEndereco($dados["endereco"]);
        $funcionario->setNumero((int) $dados["numero"]);
        $funcionario->setComplemento($dados["complemento"]);
        $funcionario->setBairro($dados["bairro"]);
        $funcionario->setCidade($this->daoCidade->find($dados["cidade_id"]));
        $funcionario->setTelefone($dados["telefone"]);
        $funcionario->setWhatsapp($dados["whatsapp"]);
        $funcionario->setEmail($dados["email"]);
        $funcionario->setCpfCnpj($dados["cpf"]);
        $funcionario->setRgInscricaoEstadual($dados["rg"]);
        $funcionario->setDataNascimento($dados["data_nascimento"]);
        $funcionario->setSalario((float) $dados["salario"]);
        $funcionario->setDataAdmissao($dados["data_admissao"]);
        $funcionario->setDataDemissao($dados["data_demissao"]);
        $funcionario->setObservacoes($dados["observacoes"]);

        return $funcionario;
    }

    public function store($funcionario) {
        DB::beginTransaction();

        try {
            $dados = $this->fillData($funcionario);

            DB::table('funcionarios')->insert($dados);
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
            $funcionario = $this->create($request->all());

            $dados = $this->fillData($funcionario);

            DB::table('funcionarios')->where('id', $id)->update($dados);

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
            DB::table('funcionarios')->delete($id);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function find(int $id) {
        $dados = DB::table('funcionarios')->where('id', '=', $id)->first();

        $funcionario = $this->create(get_object_vars($dados));

        return $funcionario;
    }

    public function search(string $q = null)
    {
        $funcionarios = array();

        if (!is_null($q)) {
            $dados = DB::table('funcionarios')->where('id', '=', $q)->orWhere('funcionario', 'like', '$q')->first();

            if ($dados)
                $funcionarios[0] = $this->create(get_object_vars($dados));
        }
        else {
            $dados = DB::table('funcionarios')->limit(10)->get();

            foreach ($dados as $obj) {
                $funcionario = $this->create(get_object_vars($obj));
                array_push($funcionarios, $funcionario);
            }
        }

        return $funcionarios;
    }

    public function fillData($funcionario) {
        $dados = [
            'id'              => $funcionario->getId(),
            'funcionario'     => $funcionario->getNome(),
            'apelido'         => $funcionario->getApelido(),
            'data_nascimento' => $funcionario->getDataNascimento(),
            'salario'         => $funcionario->getSalario(),
            'cpf'             => $funcionario->getCpfCnpj(),
            'rg'              => $funcionario->getRgInscricaoEstadual(),
            'sexo'            => $funcionario->getSexo(),
            'cep'             => $funcionario->getCEP(),
            'endereco'        => $funcionario->getEndereco(),
            'numero'          => $funcionario->getNumero(),
            'complemento'     => $funcionario->getComplemento(),
            'bairro'          => $funcionario->getBairro(),
            'cidade_id'       => $funcionario->getCidade()->getId(),
            'telefone'        => $funcionario->getTelefone(),
            'whatsapp'        => $funcionario->getWhatsapp(),
            'email'           => $funcionario->getEmail(),
            'observacoes'     => $funcionario->getObservacoes(),
            'data_admissao'   => $funcionario->getDataAdmissao(),
            'data_demissao'   => $funcionario->getDataDemissao(),
        ];

        return $dados;
    }
}
