<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('funcionario', 50);
            $table->date('data_nascimento', 10);
            $table->float('salario', 10, 2);
            $table->bigInteger('cpf')->unique();
            $table->string('rg', 15)->unique();
            $table->string('sexo', 10);
            $table->string('cep', 10);
            $table->string('endereco', 50);
            $table->string('numero', 5);
            $table->string('complemento', 50)->nullable();
            $table->string('bairro', 50);

            $table->integer('cidade_id')->unsigned()->index();
            $table->foreign('cidade_id')->references('id')->on('cidades')->onDelete('cascade');

            $table->string('telefone', 15)->nullable();
            $table->string('whatsapp', 15)->nullable();
            $table->string('email', 50)->nullable();

            $table->date("data_admissao", 10);
            $table->date("data_demissao", 10)->nullable();

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
        Schema::dropIfExists('funcionarios');
    }
}
