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
    return view('welcome');
});

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::get('/paises/search', 'PaisController@search')->name('paises.search');
Route::get('/estados/search', 'EstadoController@search')->name('estados.search');
Route::get('/cidades/search', 'CidadeController@search')->name('cidades.search');

Route::resource('/paises', 'PaisController');
Route::resource('/estados', 'EstadoController');
Route::resource('/cidades', 'CidadeController');

Route::resource('/formas-pagamento', 'FormaPagamentoController');
Route::resource('/condicoes-pagamento', 'CondicaoPagamentoController');

Route::resource('/fornecedores', 'FornecedorController');
Route::resource('/funcionarios', 'FuncionarioController');
Route::resource('/clientes', 'ClienteController');

Route::resource('/categorias', 'CategoriaController');
Route::resource('/produtos', 'ProdutoController');
