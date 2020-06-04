<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fornecedor', 50);
            $table->string('tipo_pessoa', 8);
            $table->string('nome_fantasia', 50);
            $table->string('cep', 10);
            $table->string('endereco', 50);
            $table->string('numero', 5);
            $table->string('complemento', 50)->nullable();
            $table->string('bairro', 50);

            $table->integer('cidade_id')->unsigned()->index();
            $table->foreign('cidade_id')->references('id')->on('cidades')->onDelete('cascade');

            $table->string('telefone', 15)->nullable();
            $table->string('whatsapp', 15);
            $table->string('email', 50)->nullable();
            $table->string('website', 50)->nullable();

            $table->string('contato', 20)->nullable();
            $table->bigInteger('cpf_cnpj')->unique();
            $table->string('rg', 15)->unique();

            $table->integer('condicao_pagamento_id')->unsigned()->index();
            $table->foreign('condicao_pagamento_id')->references('id')->on('condicoes_pagamento')->onDelete('cascade');

            $table->float('valor_credito', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedores');
    }
}
