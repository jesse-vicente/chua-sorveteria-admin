<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->unsignedInteger("num_nota")->index();
            $table->unsignedInteger("serie")->index();
            $table->unsignedInteger("modelo")->index();

            $table->string('status', 10)->default('Em aberto');

            $table->date("data_venda");

            $table->integer('cliente_id')->unsigned()->index()->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict');

            $table->integer('funcionario_id')->unsigned()->index()->nullable();
            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('restrict');

            $table->double('descontos')->nullable();
            $table->double('total_produtos');
            $table->double('total_venda');

            $table->integer('condicao_pagamento_id')->unsigned()->index();
            $table->foreign('condicao_pagamento_id')->references('id')->on('condicoes_pagamento')->onDelete('restrict');

            $table->timestamp("data_cancelamento")->nullable();

            $table->timestamps();

            $table->primary([
                'num_nota',
                'serie',
                'modelo',
                'cliente_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendas');
    }
}
