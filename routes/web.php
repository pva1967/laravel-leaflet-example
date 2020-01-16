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

Route::get('/', 'OutletMapController@index')->name('home');

Auth::routes(['register' => false]);

Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){

    Route::get('/', 'AdminController@dashboard')->name('dashboard');
    Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');
    Route::get('/home', 'AdminController@dashboard')->name('home');
    Route::get('/store', 'AdminController@store')->name('store');

    Route::get('/user_create', 'AdminController@user_create')->name('user_create');
    Route::post('/user_store', 'AdminController@user_store')->name('user_store');
    Route::get('/user_index', 'AdminController@user_index')->name('user_index');
    Route::get('/user_edit/{id}', 'AdminController@user_edit')->name('user_edit');
    Route::post('/user_update', 'AdminController@user_update')->name('user_update');

    Route::get('/name_create', 'AdminController@name_create')->name('name_create');
    Route::post('/name_store', 'AdminController@name_store')->name('name_store');
    Route::get('/inst_create', 'AdminController@inst_create')->name('inst_create');
    Route::post('/inst_store', 'AdminController@inst_store')->name('inst_store');

    Route::get('/realm_create', 'AdminController@realm_create')->name('realm_create');
    Route::get('/realm_edit', 'AdminController@realm_edit')->name('realm_edit');
    Route::post('/realm_destroy', 'AdminController@realm_destroy')->name('realm_destroy');

    Route::post('/realm_store', 'AdminController@realm_store')->name('realm_store');
    /*Отслыка ссылки на изменение пароля для админов организаций*/
    Route::post('send_password', 'AdminController@PasswordSend')->name('password.send');

    Route::post('institution/store','InstitutionController@store')->name('institution.store');
    Route::get('institution/store', function(){
        return App::abort(404);
    });



    Route::namespace('Auth')->group(function(){

        //Login Routes
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
        Route::post('/logout','LoginController@logout')->name('logout');
        //Forgot Password Routes
        Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        //Reset Password Routes
        Route::get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset','ResetPasswordController@reset')->name('password.update');


    });
});

Route::get('/admin/outlets', 'OutletController@index')->name('admin.outlets.index');
Route::get('/admin/outlets/create', 'OutletController@create')->name('admin.outlets.create');
Route::post('/admin/outlets/store', 'OutletController@store')->name('admin.outlets.store');
Route::get('/admin/outlets/{outlet}', 'OutletController@show')->name('admin.outlets.show');
Route::get('/admin/outlets/{outlet}/edit', 'OutletController@edit')->name('admin.outlets.edit');
Route::patch('/admin/outlets/{outlet}/update', 'OutletController@update')->name('admin.outlets.update');
Route::delete('/admin/outlets/{outlet}/destroy', 'OutletController@destroy')->name('admin.outlets.destroy');

Route::post('/admin/institution/store','InstitutionController@store')->name('admin.institution.store');
Route::get('/admin/institution/store', function(){
    return App::abort(404);
});
Route::get('/admin/institution/edit', 'InstitutionController@edit')->name('admin.institution.edit');
Route::get('/admin/show', 'InstitutionController@show')->name('admin.institution.show');

Route::get('/admin/contacts', 'ContactController@index')->name('admin.contacts.index');
Route::get('/admin/contacts/create', 'ContactController@create')->name('admin.contacts.create');
Route::get('/admin/contacts/edit/{id}', 'ContactController@edit')->name('admin.contacts.edit');
Route::post('/admin/contacts/store','ContactController@store')->name('admin.contacts.store');
Route::get('/admin/contacts/store', function(){
    return App::abort(404);
});
Route::post('/admin/contacts/update','ContactController@update')->name('admin.contacts.update');
Route::get('/admin/contacts/update', function(){
    return App::abort(404);
});

Route::delete('/admin/contacts/destroy/','ContactController@destroy')->name('admin.contacts.destroy');
Route::get('/admin/contacts/destroy', function(){
    return App::abort(404);
});

Route::get('/admin/contacts_outlets/{outlet}/edit', 'Cont2locController@edit')->name('admin.cont2outlets.edit');
Route::post('/admin/contacts_outlets/{outlet}/store', 'Cont2locController@store')->name('admin.cont2outlets.store');
Route::get('/admin/contacts_outlets/{outlet}/store', function(){
    return App::abort(404);
});

Route::get('/admin/contacts_institution/edit', 'Cont2instController@edit')->name('admin.contacts2institution.edit');
Route::post('/admin/contacts_institution/store', 'Cont2instController@store')->name('admin.contacts2institution.store');

Route::get('/admin/contacts_institution/store', function(){
    return App::abort(404);
});



Route::get('/admin/our_outlets', 'OutletMapController@index')->name('admin.outlet_map.index');

Route::get('/admin', function () {
    return redirect('admin/login');
});

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

Route::delete('contacts/destroy','ContactController@destroy')->name('contacts.destroy');
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




/* copy controllers for admin */





Route::get('import', 'DataController@import')->name('data.import');
Route::get('export', 'DataController@export')->name('data.export');
Route::get('export_m', 'DataController@export_m')->name('data.export_m');
