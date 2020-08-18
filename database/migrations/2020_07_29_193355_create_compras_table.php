<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->unsignedInteger("num_nota");
            $table->unsignedInteger("serie");
            $table->unsignedInteger("modelo");

            $table->string('status', 10);

            $table->date("data_emissao")->nullable();
            $table->date("data_entrada")->nullable();

            $table->integer('fornecedor_id')->unsigned()->index();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores')->onDelete('restrict');

            $table->integer('funcionario_id')->unsigned()->index();
            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('restrict');

            $table->double('valor_total');
            $table->double('frete');
            $table->double('seguro');
            $table->double('despesas');
            $table->double('descontos');
            $table->double('valor_total_nota');

            $table->integer('condicao_pagamento_id')->unsigned()->index();
            $table->foreign('condicao_pagamento_id')->references('id')->on('condicoes_pagamento')->onDelete('restrict');

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
        Schema::dropIfExists('compras');
    }
}
