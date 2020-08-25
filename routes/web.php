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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::get('/paises/all', 'PaisController@all')->name('paises.all');
Route::get('/estados/all', 'EstadoController@all')->name('estados.all');
Route::get('/cidades/all', 'CidadeController@all')->name('cidades.all');
Route::get('/categorias/all', 'CategoriaController@all')->name('categorias.all');
Route::get('/produtos/all', 'ProdutoController@all')->name('produtos.all');
Route::get('/clientes/all', 'ClienteController@all')->name('clientes.all');
Route::get('/fornecedores/all', 'FornecedorController@all')->name('fornecedores.all');
Route::get('/formas-pagamento/all', 'FormaPagamentoController@all')->name('formas-pagamento.all');
Route::get('/condicoes-pagamento/all', 'CondicaoPagamentoController@all')->name('condicoes-pagamento.all');

Route::get('/paises/{id}/findById', 'PaisController@findById')->name('paises.findById');
Route::get('/estados/{id}/findById', 'EstadoController@findById')->name('estados.findById');
Route::get('/cidades/{id}/findById', 'CidadeController@findById')->name('cidades.findById');
Route::get('/categorias/{id}/findById', 'CategoriaController@findById')->name('categorias.findById');
Route::get('/produtos/{id}/findById', 'ProdutoController@findById')->name('produtos.findById');
Route::get('/fornecedores/{id}/findById', 'FornecedorController@findById')->name('fornecedores.findById');

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

Route::resource('/compras', 'CompraController');
Route::resource('/vendas', 'VendaController');
