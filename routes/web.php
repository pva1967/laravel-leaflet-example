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

Auth::routes(['register' => false]);

Route::get('/home', 'OutletMapController@index')->name('outlet_map.index');

/*
 * Outlets Routes
 */
Route::get('/our_outlets', 'OutletMapController@index')->name('outlet_map.index');
Route::resource('outlets', 'OutletController');

/* Institution Routes*/

Route::post('institution/store','InstitutionController@store')->name('institution.store');
Route::get('institution/store', function(){
    return App::abort(404);
});
Route::get('institution/edit', 'InstitutionController@edit')->name('institution.edit');
Route::get('institution/show', 'InstitutionController@show')->name('institution.show');

Route::get('contacts', 'ContactController@index')->name('contacts.index');
Route::get('contacts/create', 'ContactController@create')->name('contacts.create');
Route::get('contacts/edit/{id}', 'ContactController@edit')->name('contacts.edit');
Route::post('contacts/store','ContactController@store')->name('contacts.store');
Route::get('contacts/store', function(){
    return App::abort(404);
});

Route::post('contacts/update','ContactController@update')->name('contacts.update');
Route::get('contacts/update', function(){
    return App::abort(404);
});

Route::post('contacts/destroy','ContactController@destroy')->name('contacts.destroy');
Route::get('contacts/destroy', function(){
    return App::abort(404);
});


/*Adding contacts routes*/
Route::get('contacts_outlets/{outlet}/edit', 'Cont2locController@edit')->name('cont2outlets.edit');
Route::post('contacts_outlets/{outlet}/store', 'Cont2locController@store')->name('cont2outlets.store');
Route::get('contacts_outlets/{outlet}/store', function(){
    return App::abort(404);
});

Route::get('contacts_institution/edit', 'Cont2instController@edit')->name('contacts2institution.edit');
Route::post('contacts_institution/store', 'Cont2instController@store')->name('contacts2institution.store');

Route::get('contacts_institution/store', function(){
    return App::abort(404);
});

Route::get('import', 'DataController@import')->name('data.import');
Route::get('export', 'DataController@export')->name('data.export');
Route::get('export_m', 'DataController@export_m')->name('data.export_m');

Route::get('admin', 'Admin\AdminController@dashboard')->name('admin.dashboard');
Route::get('admin/store', 'Admin\AdminController@store')->name('admin.store');

Route::get('admin/user_create', 'Admin\AdminController@user_create')->name('admin.user_create');
Route::post('admin/user_store', 'Admin\AdminController@user_store')->name('admin.user_store');
Route::get('admin/user_index', 'Admin\AdminController@user_index')->name('admin.user_index');
Route::get('admin/user_edit/{id}', 'Admin\AdminController@user_edit')->name('admin.user_edit');
Route::post('admin/user_update', 'Admin\AdminController@user_update')->name('admin.user_update');

Route::get('admin/name_create', 'Admin\AdminController@name_create')->name('admin.name_create');
Route::post('admin/name_store', 'Admin\AdminController@name_store')->name('admin.name_store');
Route::get('admin/inst_create', 'Admin\AdminController@inst_create')->name('admin.inst_create');
Route::post('admin/inst_store', 'Admin\AdminController@inst_store')->name('admin.inst_store');

Route::get('admin/realm_create', 'Admin\AdminController@realm_create')->name('admin.realm_create');
Route::get('admin/realm_edit', 'Admin\AdminController@realm_edit')->name('admin.realm_edit');
Route::post('admin/realm_destroy', 'Admin\AdminController@realm_destroy')->name('admin.realm_destroy');

Route::post('admin/realm_store', 'Admin\AdminController@realm_store')->name('admin.realm_store');

Route::post('reset_password', 'Admin\AdminController@PasswordRequest')->name('admin.password_reset');
Route::get('reset_password', function(){
    return App::abort(404);
});

/* copy controllers for admin */


Route::get('admin/home', 'Admin/OutletMapController@index')->name('outlet_map.index');

/*
 * Outlets Routes
 */

Route::get('admin/our_outlets', 'Admin/OutletMapController@index')->name('outlet_map.index');
Route::resource('outlets', 'OutletController');

/* Institution Routes*/

Route::post('institution/store','Admin/InstitutionController@store')->name('institution.store');
Route::get('institution/store', function(){
    return App::abort(404);
});
Route::get('institution/edit', 'Admin/InstitutionController@edit')->name('institution.edit');
Route::get('institution/show', 'Admin/InstitutionController@show')->name('institution.show');

Route::get('contacts', 'Admin/ContactController@index')->name('contacts.index');
Route::get('contacts/create', 'Admin/ContactController@create')->name('contacts.create');
Route::get('contacts/edit/{id}', 'Admin/ContactController@edit')->name('contacts.edit');
Route::post('contacts/store','Admin/ContactController@store')->name('contacts.store');
Route::get('contacts/store', function(){
    return App::abort(404);
});

Route::post('contacts/update','Admin/ContactController@update')->name('contacts.update');
Route::get('contacts/update', function(){
    return App::abort(404);
});

Route::post('contacts/destroy','Admin/ContactController@destroy')->name('contacts.destroy');
Route::get('contacts/destroy', function(){
    return App::abort(404);
});


/*Adding contacts routes*/
Route::get('contacts_outlets/{outlet}/edit', 'Admin/Cont2locController@edit')->name('cont2outlets.edit');
Route::post('contacts_outlets/{outlet}/store', 'Admin/Cont2locController@store')->name('cont2outlets.store');
Route::get('contacts_outlets/{outlet}/store', function(){
    return App::abort(404);
});

Route::get('contacts_institution/edit', 'Admin/Cont2instController@edit')->name('contacts2institution.edit');
Route::post('contacts_institution/store', 'Admin/Cont2instController@store')->name('contacts2institution.store');

Route::get('contacts_institution/store', function(){
    return App::abort(404);
});

Route::get('import', 'DataController@import')->name('data.import');
Route::get('export', 'DataController@export')->name('data.export');
Route::get('export_m', 'DataController@export_m')->name('data.export_m');
