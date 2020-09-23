<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContasReceberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas_receber', function (Blueprint $table) {
            $table->integer('num_nota')->unsigned()->index();
            $table->foreign('num_nota')->references('num_nota')->on('vendas')->onDelete('restrict');

            $table->integer('serie')->unsigned()->index();
            $table->foreign('serie')->references('serie')->on('vendas')->onDelete('restrict');

            $table->integer('modelo')->unsigned()->index();
            $table->foreign('modelo')->references('modelo')->on('vendas')->onDelete('restrict');

            $table->string('status', 10)->default('Pendente');

            $table->integer('cliente_id')->unsigned()->index();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict');

            $table->integer('funcionario_id')->unsigned()->index()->nullable();
            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('restrict');

            $table->integer('forma_pagamento_id')->unsigned()->index();
            $table->foreign('forma_pagamento_id')->references('id')->on('formas_pagamento')->onDelete('restrict');

            $table->unsignedInteger('parcela');
            $table->double('valor_parcela');

            $table->date("data_vencimento");
            $table->date("data_pagamento")->nullable();

            $table->double('valor_pago')->nullable();

            $table->timestamps();

            $table->primary([
                'num_nota',
                'serie',
                'modelo',
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
        Schema::dropIfExists('contas_receber');
    }
}
