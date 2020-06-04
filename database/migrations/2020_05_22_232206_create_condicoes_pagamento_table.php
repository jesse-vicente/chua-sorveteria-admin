<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCondicoesPagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condicoes_pagamento', function (Blueprint $table) {
            $table->increments('id');
            $table->string("condicao_pagamento", 50)->unique();
            $table->float("taxa_juros", 6);
            $table->float("multa", 6);
            $table->unsignedInteger("prazo");
            $table->float("porcentagem", 6);
            $table->unsignedInteger("total_parcelas");
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
        Schema::dropIfExists('condicoes_pagamento');
    }
}
