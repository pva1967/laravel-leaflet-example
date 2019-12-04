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

Route::get('/', 'OutletMapController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*
 * Outlets Routes
 */
Route::get('/our_outlets', 'OutletMapController@index')->name('outlet_map.index');
Route::resource('outlets', 'OutletController');

/* Institution Routes*/

Route::post('institution/store','InstitutionController@store')->name('institution.store');
Route::get('institution', 'InstitutionController@show')->name('institution.show');
Route::get('institution/edit', 'InstitutionController@edit')->name('institution.edit');

Route::get('contacts', 'ContactController@index')->name('contacts.index');
Route::get('contacts/create', 'ContactController@create')->name('contacts.create');
Route::get('contacts/edit/{id}', 'ContactController@edit')->name('contacts.edit');
Route::post('contacts/store','ContactController@store')->name('contacts.store');
Route::post('contacts/update','ContactController@update')->name('contacts.update');

/*Adding contacts routes*/
Route::get('contacts_outlets/{outlet}/edit', 'Cont2locController@edit')->name('cont2outlets.edit');
Route::post('contacts_outlets/{outlet}/store', 'Cont2locController@store')->name('cont2outlets.store');


Route::get('contacts_institution/edit', 'Cont2instController@edit')->name('contacts2institution.edit');
Route::post('contacts_institution/store', 'Cont2instController@store')->name('contacts2institution.store');

Route::get('import', 'DataController@import')->name('data.import');

Route::get('export', 'DataController@export')->name('data.export');
Route::get('export_m', 'DataController@export_m')->name('data.export_m');
