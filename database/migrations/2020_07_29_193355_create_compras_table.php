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
            $table->unsignedInteger("num_nota")->unique();
            $table->unsignedInteger("serie");
            $table->unsignedInteger("modelo");

            $table->string('status', 10);

            $table->date("data_emissao");
            $table->date("data_entrada");

            $table->integer('fornecedor_id')->unsigned()->index();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores')->onDelete('restrict');

            $table->integer('funcionario_id')->unsigned()->index();
            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('restrict');

            $table->double('frete')->nullable();
            $table->double('seguro')->nullable();
            $table->double('despesas')->nullable();
            $table->double('descontos')->nullable();

            $table->double('total_produtos');
            $table->double('total_compra');

            $table->integer('condicao_pagamento_id')->unsigned()->index();
            $table->foreign('condicao_pagamento_id')->references('id')->on('condicoes_pagamento')->onDelete('restrict');

            $table->primary([
                'num_nota',
                'serie',
                'modelo',
                'fornecedor_id',
            ]);

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
