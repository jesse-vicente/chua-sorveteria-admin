<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cliente', 50);
            $table->string('tipo_pessoa', 8);
            $table->date('data_nascimento', 10);

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

            $table->bigInteger('cpf_cnpj')->unique();
            $table->bigInteger('rg')->unique()->nullable();

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
        Schema::dropIfExists('clientes');
    }
}
