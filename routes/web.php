<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', 'Admin\InicioController@index');

//auth
Route::get('auth/login', 'Seguridad\LoginController@index')->name('login');
Route::post('auth/login', 'Seguridad\LoginController@login')->name('login_post');
Route::get('auth/logout', 'Seguridad\LoginController@logout')->name('logout');

//middleware "root" es para el Usuario-> ADMINISTRADOR PRINCIAPAL, ID=1
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware'=>['auth', 'root']], function () {
    /* Rutas de ACCESO */
    Route::get('acceso', 'AccesoController@index')->name('acceso');
    Route::post('acceso', 'AccesoController@store')->name('store_acceso');
    /* Rutas de GRUPOMENU */
    Route::post('grupomenu/buscar', 'GrupoMenuController@buscar')->name('grupomenu.buscar');
    Route::get('grupomenu/eliminar/{id}/{listarluego}', 'GrupoMenuController@eliminar')->name('grupomenu.eliminar');
    Route::resource('grupomenu', 'GrupoMenuController', array('except' => array('show')));
    /* Rutas de OPCIONMENU */
    Route::post('opcionmenu/buscar', 'OpcionMenuController@buscar')->name('opcionmenu.buscar');
    Route::get('opcionmenu/eliminar/{id}/{listarluego}', 'OpcionMenuController@eliminar')->name('opcionmenu.eliminar');
    Route::resource('opcionmenu', 'OpcionMenuController', array('except' => array('show')));
    /* Rutas de ROL */
    Route::post('rol/buscar', 'RolController@buscar')->name('rol.buscar');
    Route::get('rol/eliminar/{id}/{listarluego}', 'RolController@eliminar')->name('rol.eliminar');
    Route::resource('rol', 'RolController', array('except' => array('show')));
    /* Rutas de ROLPERSONA */
    Route::get('rolpersona', 'RolPersonalController@index')->name('rolpersona');
    Route::post('rolpersona', 'RolPersonalController@store')->name('store_rolpersona');
    /* Rutas de TIPOUSUARIO */
    Route::post('tipousuario/buscar', 'TipoUsuarioController@buscar')->name('tipousuario.buscar');
    Route::get('tipousuario/eliminar/{id}/{listarluego}', 'TipoUsuarioController@eliminar')->name('tipousuario.eliminar');
    Route::resource('tipousuario', 'TipoUsuarioController', array('except' => array('show')));
    /* Rutas de USUARIO */
    Route::post('usuario/buscar', 'UsuarioController@buscar')->name('usuario.buscar');
    Route::get('usuario/eliminar/{id}/{listarluego}', 'UsuarioController@eliminar')->name('usuario.eliminar');
    Route::resource('usuario', 'UsuarioController', array('except' => array('show')));
});


//aca las demas rutas
Route::group(['middleware' => ['auth', 'acceso']], function () {
    /* Rutas de PERSONA */
    Route::post('persona/buscar', 'Admin\PersonalController@buscar')->name('persona.buscar');
    Route::get('persona/eliminar/{id}/{listarluego}', 'Admin\PersonalController@eliminar')->name('persona.eliminar');
    Route::resource('persona', 'Admin\PersonalController', array('except' => array('show')));
    /* Rutas de Cargo */
    Route::post('cargo/buscar', 'Admin\CargoController@buscar')->name('cargo.buscar');
    Route::get('cargo/eliminar/{id}/{listarluego}', 'Admin\CargoController@eliminar')->name('cargo.eliminar');
    Route::resource('cargo', 'Admin\CargoController', array('except' => array('show')));
    Route::get('dashboard', 'Admin\AdminController@index')->name('dashboard');
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
    Route::post('procedimiento/buscar', 'Control\ProcedimientoController@buscar')->name('procedimiento.buscar');
    Route::get('procedimiento/eliminar/{id}/{listarluego}', 'Control\ProcedimientoController@eliminar')->name('procedimiento.eliminar');
    Route::resource('procedimiento', 'Control\ProcedimientoController', array('except' => array('show')));

   
});