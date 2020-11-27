<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::resource('/users', 'UserController');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function () {
        return redirect('/home');
    })->name('home');

    Route::get('/home', 'HomeController@index')->name('home.index');

    Route::post('/paises/save', 'PaisController@save')->name('paises.save');
    Route::post('/estados/save', 'EstadoController@save')->name('estados.save');
    Route::post('/cidades/save', 'CidadeController@save')->name('cidades.save');
    Route::post('/condicoes-pagamento/save', 'CondicaoPagamentoController@save')->name('condicoes-pagamento.save');
    Route::post('/categorias/save', 'CategoriaController@save')->name('categorias.save');
    Route::post('/produtos/save', 'ProdutoController@save')->name('produtos.save');
    Route::post('/fornecedores/save', 'FornecedorController@save')->name('fornecedores.save');
    Route::post('/clientes/save', 'ClienteController@save')->name('clientes.save');
    Route::post('/funcionarios/save', 'FuncionarioController@save')->name('funcionarios.save');

    Route::get('/paises/all', 'PaisController@all')->name('paises.all');
    Route::get('/estados/all', 'EstadoController@all')->name('estados.all');
    Route::get('/cidades/all', 'CidadeController@all')->name('cidades.all');
    Route::get('/categorias/all', 'CategoriaController@all')->name('categorias.all');
    Route::get('/produtos/all', 'ProdutoController@all')->name('produtos.all');
    Route::get('/produtos/all/{action}', 'ProdutoController@all')->name('produtos.all');
    Route::get('/clientes/all', 'ClienteController@all')->name('clientes.all');
    Route::get('/fornecedores/all', 'FornecedorController@all')->name('fornecedores.all');
    Route::get('/formas-pagamento/all', 'FormaPagamentoController@all')->name('formas-pagamento.all');
    Route::get('/condicoes-pagamento/all', 'CondicaoPagamentoController@all')->name('condicoes-pagamento.all');

    Route::get('/paises/{id}/findById', 'PaisController@findById')->name('paises.findById');
    Route::get('/estados/{id}/findById', 'EstadoController@findById')->name('estados.findById');
    Route::get('/cidades/{id}/findById', 'CidadeController@findById')->name('cidades.findById');
    Route::get('/categorias/{id}/findById', 'CategoriaController@findById')->name('categorias.findById');
    Route::get('/produtos/{id}/findById/{action}', 'ProdutoController@findById')->name('produtos.findById');
    Route::get('/fornecedores/{id}/findById', 'FornecedorController@findById')->name('fornecedores.findById');
    Route::get('/clientes/{id}/findById', 'ClienteController@findById')->name('clientes.findById');
    Route::get('/formas-pagamento/{id}/findById', 'FormaPagamentoController@findById')->name('formas-pagamento.findById');
    Route::get('/condicoes-pagamento/{id}/findById', 'CondicaoPagamentoController@findById')->name('condicoes-pagamento.findById');

    Route::resource('/paises', 'PaisController');
    Route::resource('/estados', 'EstadoController');
    Route::resource('/cidades', 'CidadeController');

    Route::resource('/formas-pagamento', 'FormaPagamentoController');
    Route::resource('/condicoes-pagamento', 'CondicaoPagamentoController');
    Route::resource('/parcelas', 'ParcelaController');

    Route::resource('/fornecedores', 'FornecedorController');
    Route::resource('/funcionarios', 'FuncionarioController');
    Route::resource('/clientes', 'ClienteController');

    Route::resource('/categorias', 'CategoriaController');
    Route::resource('/produtos', 'ProdutoController');

    Route::get('/compras', 'CompraController@index')->name('compras.index');
    Route::get('/compras/canceled', 'CompraController@canceled')->name('compras.canceled');
    Route::get('/compras/create', 'CompraController@create')->name('compras.create');
    Route::get('/compras/{compra}/cancel', 'CompraController@cancel')->name('compras.cancel');
    Route::get('/compras/{compra}', 'CompraController@show')->name('compras.show');

    Route::post('/compras/save', 'CompraController@save')->name('compras.save');
    Route::put('/compras/{compra}/update', 'CompraController@update')->name('compras.update');
    Route::get('/compras/{compra}/findByPrimaryKey', 'CompraController@findByPrimaryKey')->name('compras.findByPrimaryKey');

    Route::get('/vendas', 'VendaController@index')->name('vendas.index');
    Route::get('/vendas/create', 'VendaController@create')->name('vendas.create');
    Route::get('/vendas/{venda}/cancel', 'VendaController@cancel')->name('vendas.cancel');
    Route::get('/vendas/{venda}', 'VendaController@show')->name('vendas.show');

    Route::post('/vendas/save', 'VendaController@save')->name('vendas.save');
    Route::put('/vendas/{venda}/update', 'VendaController@update')->name('vendas.update');
    Route::get('/vendas/{venda}/findByPrimaryKey', 'VendaController@findByPrimaryKey')->name('vendas.findByPrimaryKey');

    Route::resource('/contas-a-pagar', 'ContaPagarController');
    Route::resource('/contas-a-receber', 'ContaReceberController');
    Route::get('/contas-a-receber/{status}', 'ContaReceberController@list')->name('contas-a-receber.list');
});
