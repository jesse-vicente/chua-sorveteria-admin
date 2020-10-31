<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContasPagarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas_pagar', function (Blueprint $table) {
            $table->integer('num_nota')->unsigned()->index();
            $table->foreign('num_nota')->references('num_nota')->on('compras')->onDelete('restrict');

            $table->integer('serie')->unsigned()->index();
            $table->foreign('serie')->references('serie')->on('compras')->onDelete('restrict');

            $table->integer('modelo')->unsigned()->index();
            $table->foreign('modelo')->references('modelo')->on('compras')->onDelete('restrict');

            $table->string('status', 10)->default('Em aberto');

            $table->integer('fornecedor_id')->unsigned()->index();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores')->onDelete('restrict');

            $table->integer('funcionario_id')->unsigned()->index()->nullable();
            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('restrict');

            $table->integer('forma_pagamento_id')->unsigned()->index();
            $table->foreign('forma_pagamento_id')->references('id')->on('formas_pagamento')->onDelete('restrict');

            $table->unsignedInteger('parcela');
            $table->decimal('valor_parcela');

            $table->date("data_vencimento");
            $table->date("data_pagamento")->nullable();

            $table->decimal('juros')->nullable();
            $table->decimal('multa')->nullable();
            $table->decimal('desconto')->nullable();

            $table->decimal('valor_pago')->nullable();

            $table->timestamps();

            $table->primary([
                'num_nota',
                'serie',
                'modelo',
                'fornecedor_id',
                'parcela',
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
        Schema::dropIfExists('contas_pagar');
    }
}
