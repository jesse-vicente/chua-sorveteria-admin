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

Route::get('/paises/{id}/find', 'PaisController@find')->name('paises.find');
Route::get('/estados/{id}/find', 'EstadoController@find')->name('estados.find');
Route::get('/cidades/{id}/find', 'CidadeController@find')->name('cidades.find');

Route::get('/categorias/{id}/find', 'CategoriaController@find')->name('categorias.find');
Route::get('/fornecedores/{id}/find', 'FornecedorController@find')->name('fornecedores.find');

Route::get('/formas-pagamento/{id}/find', 'FormaPagamentoController@find')->name('formas-pagamento.find');
Route::get('/condicoes-pagamento/{id}/find', 'CondicaoPagamentoController@find')->name('condicoes-pagamento.find');

Route::get('/paises/search', 'PaisController@search')->name('paises.search');
Route::get('/estados/search', 'EstadoController@search')->name('estados.search');
Route::get('/cidades/search', 'CidadeController@search')->name('cidades.search');

Route::get('/categorias/search', 'CategoriaController@search')->name('categorias.search');
Route::get('/fornecedores/search', 'FornecedorController@search')->name('fornecedores.search');
Route::get('/funcionarios/search', 'FuncionarioController@search')->name('funcionarios.search');
Route::get('/formas-pagamento/search', 'FormaPagamentoController@search')->name('formas-pagamento.search');
Route::get('/condicoes-pagamento/search', 'CondicaoPagamentoController@search')->name('condicoes-pagamento.search');

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
