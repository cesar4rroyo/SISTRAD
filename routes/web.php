<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Admin\InicioController@index');




//auth
Route::get('auth/login', 'Seguridad\LoginController@index')->name('login');
Route::post('auth/login', 'Seguridad\LoginController@login')->name('login_post');
Route::get('auth/logout', 'Seguridad\LoginController@logout')->name('logout');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'AdminController@index')->name('admin');
    /* Rutas de ACCESO */
    Route::get('acceso', 'AccesoController@index')->name('acceso');
    Route::post('acceso', 'AccesoController@store')->name('store_acceso');
    /* Rutas de GRUPOMENU */
    Route::post('grupomenu/buscar', 'GrupoMenuController@buscar')->name('grupomenu.buscar');
    Route::get('grupomenu/eliminar/{id}/{listarluego}', 'GrupoMenuController@eliminar')->name('grupomenu.eliminar');
    Route::resource('grupomenu', 'GrupoMenuController', array('except' => array('show')));

    /* Rutas de OPCIONMENU */
    Route::get('opcionmenu/create', 'OpcionMenuController@create')->name('create_opcionmenu');
    Route::get('opcionmenu', 'OpcionMenuController@index')->name('opcionmenu');
    Route::get('opcionmenu/get', 'OpcionMenuController@getOpciones')->name('get_opcion');
    Route::get('opcionmenu/show/{id}', 'OpcionMenuController@show')->name('show_opcionmenu');
    Route::post('opcionmenu', 'OpcionMenuController@store')->name('store_opcionmenu');
    Route::post('opcionmenu/edit', 'OpcionMenuController@edit')->name('edit_opcionmenu');
    Route::post('opcionmenu/update', 'OpcionMenuController@update')->name('update_opcionmenu');
    Route::post('opcionmenu/destroy', 'OpcionMenuController@destroy')->name('destroy_opcionmenu');

    /* Rutas de Cargo */
    Route::post('cargo/buscar', 'CargoController@buscar')->name('cargo.buscar');
    Route::get('cargo/eliminar/{id}/{listarluego}', 'CargoController@eliminar')->name('cargo.eliminar');
    Route::resource('cargo', 'CargoController', array('except' => array('show')));


    /* Rutas de ROL */
    Route::get('rol/create', 'RolController@create')->name('create_rol');
    Route::get('rol', 'RolController@index')->name('rol');
    Route::get('rol/get', 'RolController@getRoles')->name('get_rol');
    Route::get('rol/show/{id}', 'RolController@show')->name('show_rol');
    Route::post('rol', 'RolController@store')->name('store_rol');
    Route::post('rol/edit', 'RolController@edit')->name('edit_rol');
    Route::post('rol/update', 'RolController@update')->name('update_rol');
    Route::post('rol/destroy', 'RolController@destroy')->name('destroy_rol');

    /* Rutas de ROLPERSONA */
    Route::get('rolpersona', 'RolPersonalController@index')->name('rolpersona');
    Route::post('rolpersona', 'RolPersonalController@store')->name('store_rolpersona');
    /* Rutas de TIPOUSUARIO */
    Route::get('tipousuario/create', 'TipoUsuarioController@create')->name('create_tipousuario');
    Route::get('tipousuario', 'TipoUsuarioController@index')->name('tipousuario');
    Route::get('tipousuario/get', 'TipoUsuarioController@getTipos')->name('get_tipo');
    Route::get('tipousuario/show/{id}', 'TipoUsuarioController@show')->name('show_tipousuario');
    Route::post('tipousuario', 'TipoUsuarioController@store')->name('store_tipousuario');
    Route::post('tipousuario/edit', 'TipoUsuarioController@edit')->name('edit_tipousuario');
    Route::post('tipousuario/update', 'TipoUsuarioController@update')->name('update_tipousuario');
    Route::post('tipousuario/destroy', 'TipoUsuarioController@destroy')->name('destroy_tipousuario');
    /* Rutas de USUARIO */
    Route::get('usuario/create', 'UsuarioController@create')->name('create_usuario');
    Route::get('usuario', 'UsuarioController@index')->name('usuario');
    Route::get('usuario/get', 'UsuarioController@getUsuarios')->name('get_usuario');
    Route::get('usuario/show/{id}', 'UsuarioController@show')->name('show_usuario');
    Route::post('usuario', 'UsuarioController@store')->name('store_usuario');
    Route::post('usuario/edit', 'UsuarioController@edit')->name('edit_usuario');
    Route::post('usuario/update', 'UsuarioController@update')->name('update_usuario');
    Route::post('usuario/destroy', 'UsuarioController@destroy')->name('destroy_usuario');
});
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    /* Rutas de PERSONA */
    Route::get('persona/create', 'PersonalController@create')->name('create_persona');
    Route::get('persona', 'PersonalController@index')->name('persona');
    Route::get('persona/get', 'PersonalController@getPersonas')->name('get_persona');
    Route::get('persona/show/{id}', 'PersonalController@show')->name('show_persona');
    Route::post('persona', 'PersonalController@store')->name('store_persona');
    Route::post('persona/edit', 'PersonalController@edit')->name('edit_persona');
    Route::post('persona/update', 'PersonalController@update')->name('update_persona');
    Route::post('persona/destroy', 'PersonalController@destroy')->name('destroy_persona');
    //obetener solo los clientes con RUC para combobox
    Route::get('persona/clientes/ruc', 'PersonalController@getClientesRuc')->name('getClientesRuc');
    //obetner todos los clientes
    Route::get('persona/clientes/generales', 'PersonalController@getClientesSinRuc')->name('getTodosClientes');
    //agregar persona RUC desde el checkout
    Route::post('persona/store/checkout', 'PersonalController@storeClienteRuc')->name('storeClienteRuc');

});


Route::group(['middleware' => 'auth'], function () {

    /* MOTIVOS RECHAZO*/
    Route::post('motivorechazo/buscar', 'Control\MotivorechazoController@buscar')->name('motivorechazo.buscar');
    Route::get('motivorechazo/eliminar/{id}/{listarluego}', 'Control\MotivorechazoController@eliminar')->name('motivorechazo.eliminar');
    Route::resource('motivorechazo', 'Control\MotivorechazoController', array('except' => array('show')));
   
    /* MOTIVOS COURIER*/
    Route::post('motivocourier/buscar', 'Control\MotivocourierController@buscar')->name('motivocourier.buscar');
    Route::get('motivocourier/eliminar/{id}/{listarluego}', 'Control\MotivocourierController@eliminar')->name('motivocourier.eliminar');
    Route::resource('motivocourier', 'Control\MotivocourierController', array('except' => array('show')));

    /* AREAS*/
    Route::post('area/buscar', 'Control\AreaController@buscar')->name('area.buscar');
    Route::get('area/eliminar/{id}/{listarluego}', 'Control\AreaController@eliminar')->name('area.eliminar');
    Route::resource('area', 'Control\AreaController', array('except' => array('show')));

    /* TRAMITES*/
    Route::post('tramite/buscar', 'Control\TramiteController@buscar')->name('tramite.buscar');
    Route::get('tramite/eliminar/{id}/{listarluego}', 'Control\TramiteController@eliminar')->name('tramite.eliminar');
    Route::resource('tramite', 'Control\TramiteController', array('except' => array('show')));

   
});