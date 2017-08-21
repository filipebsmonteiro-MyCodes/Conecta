<?php

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

Route::get('/home',								'Site\HomeController@index')				->name('home.index');

Route::resource('/regiao',						'Site\RegiaoController');

Route::any('/convidado/presenca/{idConvidado}',	'Site\ConvidadoController@presenca')		->name('convidado.presenca');
Route::resource('/convidado',					'Site\ConvidadoController');

Route::any('/alterarSenha/{token?}',			'Site\MembroController@alterarSenha')		->name('membro.alterarSenha');
Route::any('/user/search/',						'Site\MembroController@search')				->name('membro.search');
Route::any('/membro/editPermissoes/{id}',		'Site\MembroController@editPermissoes')		->name('membro.editPermissoes');
Route::any('/membro/updatePermissoes',			'Site\MembroController@updatePermissoes')	->name('membro.updatePermissoes');
Route::any('/membro/ajax',						'Site\MembroController@ajax')				->name('membro.ajax');
Route::resource('/membro',						'Site\MembroController');

Route::resource('/rede',						'Site\RedeController');

Route::group(['prefix' => 'celula'], function($id) {
	Route::any('/gerenciar/{id}',				'Site\CelulaController@gerenciar')			->name('celula.gerenciar');
	Route::any('/presenca',						'Site\CelulaController@presenca')			->name('celula.presenca');
	Route::any('/carregaPresenca/{id}',			'Site\CelulaController@carregaPresenca')	->name('celula.carregaPresenca');
	Route::any('/lideranca',					'Site\CelulaController@lideranca')			->name('celula.lideranca');
	Route::any('/subLideranca',					'Site\CelulaController@subLideranca')		->name('celula.subLideranca');
	Route::any('/removeLideranca/{idUserCel}',	'Site\CelulaController@removeLideranca')	->name('celula.removeLideranca');
	Route::any('/multiplicar',					'Site\CelulaController@multiplicar')		->name('celula.multiplicar');
	Route::any('/migrar',						'Site\CelulaController@migrar')				->name('celula.migrar');
	Route::any('/createConvidado/{id}',			'Site\CelulaController@createConvidado')	->name('celula.createConvidado');
	Route::any('/storeConvidado',				'Site\CelulaController@storeConvidado')		->name('celula.storeConvidado');
	Route::any('/reciclar/{id}',				'Site\CelulaController@reciclar')			->name('celula.reciclar');
	Route::any('/restore',						'Site\CelulaController@restore')			->name('celula.restore');
});
Route::resource('/celula',						'Site\CelulaController');

Route::group(['prefix' => 'evento'], function($id) {
	Route::any('/listar',						'Site\EventoController@listar')				->name('evento.listar');
	Route::any('/inscrever/{idEvento}',			'Site\EventoController@inscrever')			->name('evento.inscrever');
	Route::any('/pagamento/{idEvento}',			'Site\EventoController@pagamento')			->name('evento.pagamento');
	Route::any('/presenca/{id}',				'Site\EventoController@presenca')			->name('evento.presenca');
});
Route::resource('/evento',						'Site\EventoController');

Route::any('/test',	'Site\MembroController@showResetForm');

Route::any('/pagSeguroListener/{email}/{token}', 'Site\PagSeguroController@transactionListener');
Route::any('/pagSeguroSearch/{code}',			'Site\PagSeguroController@searchTransaction')->name('pagSeguro.search');
