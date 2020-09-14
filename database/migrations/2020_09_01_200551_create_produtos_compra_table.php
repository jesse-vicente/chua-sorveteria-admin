<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos_compra', function (Blueprint $table) {
            $table->integer('num_nota')->unsigned()->index();
            $table->foreign('num_nota')->references('num_nota')->on('compras')->onDelete('restrict');

            $table->integer('serie')->unsigned()->index();
            $table->foreign('serie')->references('serie')->on('compras')->onDelete('restrict');

            $table->integer('modelo')->unsigned()->index();
            $table->foreign('modelo')->references('modelo')->on('compras')->onDelete('restrict');

            $table->integer('produto_id')->unsigned()->index();
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('restrict');

            $table->unsignedInteger('quantidade');

            $table->primary([
                'num_nota',
                'serie',
                'modelo',
                'produto_id',
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
        Schema::dropIfExists('produtos_compra');
    }
}
