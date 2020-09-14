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
            $table->unsignedInteger("num_nota")->unique()->index();
            $table->unsignedInteger("serie")->index();
            $table->unsignedInteger("modelo")->index();

            $table->string('status', 10)->default('Ativa');

            $table->date("data_emissao");
            $table->date("data_chegada");

            $table->integer('fornecedor_id')->unsigned()->index();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores')->onDelete('restrict');

            $table->integer('funcionario_id')->unsigned()->index()->nullable();
            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('restrict');

            $table->double('frete')->nullable();
            $table->double('seguro')->nullable();
            $table->double('despesas')->nullable();
            $table->double('descontos')->nullable();

            $table->double('total_produtos');
            $table->double('total_compra');

            $table->integer('condicao_pagamento_id')->unsigned()->index();
            $table->foreign('condicao_pagamento_id')->references('id')->on('condicoes_pagamento')->onDelete('restrict');

            $table->timestamp("data_cancelamento")->nullable();

            $table->timestamps();

            $table->primary([
                'num_nota',
                'serie',
                'modelo',
                'fornecedor_id',
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
        Schema::dropIfExists('compras');
    }
}
