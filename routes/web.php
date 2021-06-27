<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Admin\InicioController@index');
Route::get('/consultatramite', 'Contribuyente\ContribuyenteController@busqueda');
Route::get('/tramitevirtual', 'Contribuyente\ContribuyenteController@index');
Route::post('contribuyente/registrartramite','Contribuyente\ContribuyenteController@registrarTramite')->name('contribuyente.registrartramite');
Route::get('contribuyente/buscartramite','Contribuyente\ContribuyenteController@buscarTramite')->name('contribuyente.buscartramite');
Route::post('contribuyente/buscarDNI', 'Contribuyente\ContribuyenteController@buscarDNI')->name('contribuyente.buscarDNI');
Route::get('tramitevirtual/seguimiento/pdf/{id}', 'Contribuyente\ContribuyenteController@printseguimiento')->name('contribuyente.printseguimiento');
    
// Route::get('/', 'Seguridad\LoginController@index');

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
    /*Dashboard Principal*/
    Route::get('dashboard', function(){
        return view('theme.lte.layout');
    })->name('dashboard');
    //Route::get('dashboard', 'Gestion\TramiteController@index')->name('dashboard');
    

    /* Rutas Perfil & Cambio Contraseña */
    Route::get('persona/perfil', 'Admin\UsuarioController@perfil')->name('usuario.perfil');
    Route::post('persona/password/{id}', 'Admin\UsuarioController@cambiarpassword')->name('usuario.cambiarpassword');


    /* Rutas de PERSONA */
    Route::post('persona/buscar', 'Admin\PersonalController@buscar')->name('persona.buscar');
    Route::get('persona/eliminar/{id}/{listarluego}', 'Admin\PersonalController@eliminar')->name('persona.eliminar');
    Route::resource('persona', 'Admin\PersonalController', array('except' => array('show')));
    /* Rutas de Cargo */
    Route::post('cargo/buscar', 'Admin\CargoController@buscar')->name('cargo.buscar');
    Route::get('cargo/eliminar/{id}/{listarluego}', 'Admin\CargoController@eliminar')->name('cargo.eliminar');
    Route::resource('cargo', 'Admin\CargoController', array('except' => array('show')));
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
    /* ARCHIVADOR*/
    Route::post('archivador/buscar', 'Control\ArchivadorController@buscar')->name('archivador.buscar');
    Route::get('archivador/eliminar/{id}/{listarluego}', 'Control\ArchivadorController@eliminar')->name('archivador.eliminar');
    Route::resource('archivador', 'Control\ArchivadorController', array('except' => array('show')));
    /* TIPODOCUMENTO*/
    Route::post('tipodocumento/buscar', 'Control\TipoDocumentoController@buscar')->name('tipodocumento.buscar');
    Route::get('tipodocumento/eliminar/{id}/{listarluego}', 'Control\TipoDocumentoController@eliminar')->name('tipodocumento.eliminar');
    Route::resource('tipodocumento', 'Control\TipoDocumentoController', array('except' => array('show')));
    /* PROCEDIMIENTOS*/
    Route::post('procedimiento/buscar', 'Control\ProcedimientoController@buscar')->name('procedimiento.buscar');
    Route::get('procedimiento/eliminar/{id}/{listarluego}', 'Control\ProcedimientoController@eliminar')->name('procedimiento.eliminar');
    Route::resource('procedimiento', 'Control\ProcedimientoController', array('except' => array('show')));
    
    /* EMPRESA COURIER*/
    Route::post('empresacourier/buscar', 'Control\EmpresacourierController@buscar')->name('empresacourier.buscar');
    Route::get('empresacourier/eliminar/{id}/{listarluego}', 'Control\EmpresacourierController@eliminar')->name('empresacourier.eliminar');
    Route::resource('empresacourier', 'Control\EmpresacourierController', array('except' => array('show')));
    Route::post('empresacourier/buscarRUC', 'Control\EmpresacourierController@buscarRUC')->name('empresacourier.buscarRUC');
    /* TRAMITES*/
    Route::post('tramite/buscar', 'Gestion\TramiteController@buscar')->name('tramite.buscar');
    Route::get('tramite/eliminar/{id}/{listarluego}', 'Gestion\TramiteController@eliminar')->name('tramite.eliminar');
    Route::resource('tramite', 'Gestion\TramiteController', array('except' => array('show')));
    
    Route::get('tramite/listarprocedimientos', 'Gestion\TramiteController@listarProcedimientos')->name('tramite.listarprocedimientos');
    Route::get('tramite/listarempresascourier', 'Gestion\TramiteController@listarEmpresascourier')->name('tramite.listarempresascourier');
    Route::get('tramite/listarareas', 'Gestion\TramiteController@listarAreas')->name('tramite.listarareas');
    Route::get('tramite/listararchivadores', 'Gestion\TramiteController@listarArchivadores')->name('tramite.listararchivadores');
    Route::get('tramite/listartramites', 'Gestion\TramiteController@listarTramites')->name('tramite.listartramites');
    Route::get('tramite/listarpersonal', 'Gestion\TramiteController@listarPersonal')->name('tramite.listarpersonal');
    Route::post('tramite/generarNumero', 'Gestion\TramiteController@generarNumero')->name('tramite.generarnumero');
    
    
    Route::get('tramite/confirmacion/{id}/{listarluego}/{accion}', 'Gestion\TramiteController@confirmacion')->name('tramite.confirmacion');
    Route::post('tramite/accion/{id}/{accion}', 'Gestion\TramiteController@accion')->name('tramite.accion');
    Route::get('tramite/seguimiento/pdf/{id}', 'Gestion\TramiteController@printseguimiento')->name('tramite.printseguimiento');
    
    Route::get('tramite/ticket/pdf', 'Gestion\TramiteController@generarTicket')->name('tramite.ticket');

    //tramite reportes
    Route::resource('reportetramite', 'Reportes\ReportetramiteController', array('except' => array('show')));
    Route::get('reportetramite/pdftramites', 'Reportes\ReportetramiteController@pdfTramites')->name('reportetramite.pdftramites');
    //inspeccion reporte
    Route::resource('reporteInspeccion', 'Reportes\ReporteInspeccionController', array('except' => array('show')));
    Route::get('reporteInspeccion/pdfInspeccion', 'Reportes\ReporteInspeccionController@pdfInspeccion')->name('reporteinspeccion.pdfInspeccion');
    //resolucion reporte
    Route::resource('reporteResolucion', 'Reportes\ReporteResolucionController', array('except' => array('show')));
    Route::get('reporteResolucion/pdfResolucion', 'Reportes\ReporteResolucionController@pdfResolucion')->name('reporteresolucion.pdfResolucion');
    Route::get('reporteResolucion/excelResolucion', 'Reportes\ReporteResolucionController@excel')->name('reporteresolucion.excel');

//SEGUNDA PARTE 

    //ORDEN PAGO
    Route::post('ordenpago/buscar', 'Gestion\OrdenpagoController@buscar')->name('ordenpago.buscar');
    Route::get('ordenpago/eliminar/{id}/{listarluego}', 'Gestion\OrdenpagoController@eliminar')->name('ordenpago.eliminar');
    Route::resource('ordenpago', 'Gestion\OrdenpagoController', array('except' => array('show')));  
    Route::get('ordenpago/pdf/{id}', 'Gestion\OrdenpagoController@pdf')->name('ordenpago.pdf');
    Route::post('ordenpago/generarNumero', 'Gestion\OrdenpagoController@generarNumero')->name('ordenpago.generarnumero');
    Route::get('ordenpago/listarsubtipostramite', 'Control\SubtipotramitenodocController@listarSubtipos')->name('ordenpago.listarsubtipos');
    Route::post('ordenpago/buscarDNI', 'Gestion\OrdenpagoController@buscarDNI')->name('ordenpago.buscarDNI');
    Route::post('ordenpago/buscarRUC', 'Gestion\OrdenpagoController@buscarRUC')->name('ordenpago.buscarRUC');
    Route::post('ordenpago/verificardireccion', 'Gestion\OrdenpagoController@verificardireccion')->name('ordenpago.verificardireccion');

    Route::resource('reporteordenpago', 'Reportes\ReporteordenpagoController', array('except' => array('show')));
    Route::get('reporteordenpago/pdfordenespago', 'Reportes\ReporteordenpagoController@pdfordenespago')->name('reporteordenpago.pdfordenespago');
    //FIN ORDEN PAGO

    //INSPECCION
    Route::post('inspeccion/buscar', 'Gestion\InspeccionController@buscar')->name('inspeccion.buscar');
    Route::get('inspeccion/eliminar/{id}/{listarluego}', 'Gestion\InspeccionController@eliminar')->name('inspeccion.eliminar');

    Route::resource('inspeccion', 'Gestion\InspeccionController', array('except' => array('show'))); 
    Route::get('inspeccion/pdf/{id}', 'Gestion\InspeccionController@pdfInspeccion')->name('inspeccion.pdfInspeccion');
    Route::get("inspeccion/archivo/{nombre}",'Gestion\InspeccionController@descargar')->name('inspeccion.descargar');
    Route::post('inspeccion/generarNumero', 'Gestion\InspeccionController@generarNumero')->name('inspeccion.generarnumero');
    Route::post('inspeccion/getInfo', 'Gestion\InspeccionController@getInfo')->name('inspeccion.getInfo');
    Route::put('inspeccion/observaciones', 'Gestion\InspeccionController@levantarObservaciones')->name('inspeccion.levantarObservaciones');

    //FIN INSPECCION

    /* RESOLUCIÓN*/
    Route::post('resolucion/buscar', 'Gestion\ResolucionController@buscar')->name('resolucion.buscar');
    Route::get('resolucion/eliminar/{id}/{listarluego}', 'Gestion\ResolucionController@eliminar')->name('resolucion.eliminar');
    Route::get('resolucion/cambiarestado/{id}/{listarluego}', 'Gestion\ResolucionController@estado')->name('resolucion.estado');
    Route::get('resolucion/cambiarestado/{id}', 'Gestion\ResolucionController@confirmarEstado')->name('resolucion.updateEstado');
    Route::post('resolucion/baja', 'Gestion\ResolucionController@darBaja')->name('resolucion.baja');
    Route::resource('resolucion', 'Gestion\ResolucionController', array('except' => array('show')));
    Route::get('resolucion/listarInspeccion', 'Gestion\ResolucionController@listarInspeccion')->name('resolucion.listarInspeccion');
    Route::get('resolucion/listarOrdenpago', 'Gestion\ResolucionController@listarOrdenpago')->name('resolucion.listarOrdenpago');
    Route::get('resolucion/pdf/{id}/{blanco?}/{subtipo?}', 'Gestion\ResolucionController@pdfResolucion')->name('resolucion.pdfResolucion');
    Route::post('resolucion/generarNumero', 'Gestion\ResolucionController@generarNumero')->name('resolucion.generarnumero');
    Route::post('resolucion/generarNumero2', 'Gestion\ResolucionController@generarNumero2')->name('resolucion.generarnumero2');
    Route::post('resolucion/generarNumero3', 'Gestion\ResolucionController@generarNumero3')->name('resolucion.generarnumero3');

    //Tipo tramite
    Route::post('tipotramitenodoc/buscar', 'Control\TipotramitenodocController@buscar')->name('tipotramitenodoc.buscar');
    Route::get('tipotramitenodoc/eliminar/{id}/{listarluego}', 'Control\TipotramitenodocController@eliminar')->name('tipotramitenodoc.eliminar');
    Route::resource('tipotramitenodoc', 'Control\TipotramitenodocController', array('except' => array('show')));
   //Sub tipo tramite
    Route::post('subtipotramitenodoc/buscar', 'Control\SubtipotramitenodocController@buscar')->name('subtipotramitenodoc.buscar');
    Route::get('subtipotramitenodoc/eliminar/{id}/{listarluego}', 'Control\SubtipotramitenodocController@eliminar')->name('subtipotramitenodoc.eliminar');
    Route::resource('subtipotramitenodoc', 'Control\SubtipotramitenodocController', array('except' => array('show')));

    //SOLICITUD
    Route::post('solicitud/buscar', 'Gestion\SolicitudController@buscar')->name('solicitud.buscar');
    Route::get('solicitud/eliminar/{id}/{listarluego}', 'Gestion\SolicitudController@eliminar')->name('solicitud.eliminar');
    Route::resource('solicitud', 'Gestion\SolicitudController', array('except' => array('show')));  
    Route::get('solicitud/pdf/{id}', 'Gestion\SolicitudController@pdf')->name('solicitud.pdf');
    Route::post('solicitud/generarNumero', 'Gestion\SolicitudController@generarNumero')->name('solicitud.generarnumero');

    //FIN SOLICITUD

    //CARTA
    Route::post('carta/buscar', 'Gestion\CartaController@buscar')->name('carta.buscar');
    Route::get('carta/eliminar/{id}/{listarluego}', 'Gestion\CartaController@eliminar')->name('carta.eliminar');
    Route::resource('carta', 'Gestion\CartaController', array('except' => array('show')));  
    Route::get('carta/pdf/{id}', 'Gestion\CartaController@pdf')->name('carta.pdf');
    Route::post('carta/generarNumero', 'Gestion\CartaController@generarNumero')->name('carta.generarnumero');
    Route::get('carta/cambiarestado/{id}/{listarluego}', 'Gestion\CartaController@estado')->name('carta.estado');
    Route::get('carta/cambiarestado/{id}', 'Gestion\CartaController@confirmarEstado')->name('carta.updateEstado');

    //FIN CARTA

//FIN SEGUNDA PARTE
    //ACTA DE INSPECCION
    Route::post('acta/buscar', 'Gestion\ActaController@buscar')->name('acta.buscar');
    Route::get('acta/eliminar/{id}/{listarluego}', 'Gestion\ActaController@eliminar')->name('acta.eliminar');
    Route::resource('acta', 'Gestion\ActaController', array('except' => array('show')));  
    Route::get('acta/pdf/{id}', 'Gestion\ActaController@pdf')->name('acta.pdf');
    Route::post('acta/generarNumero', 'Gestion\ActaController@generarNumero')->name('acta.generarnumero');

    //NOTIFICACION CARGO
    Route::post('notificacioncargo/buscar', 'Gestion\NotificacioncargoController@buscar')->name('notificacioncargo.buscar');
    Route::get('notificacioncargo/eliminar/{id}/{listarluego}', 'Gestion\NotificacioncargoController@eliminar')->name('notificacioncargo.eliminar');
    Route::resource('notificacioncargo', 'Gestion\NotificacioncargoController', array('except' => array('show')));
    Route::get('notificacioncargo/pdf/{id}', 'Gestion\NotificacioncargoController@pdf')->name('notificacioncargo.pdf');
    Route::get('notificacioncargo/descargo/{id}/{listarluego}', 'Gestion\NotificacioncargoController@descargo')->name('notificacioncargo.descargo');
    Route::post('notificacioncargo/guardardescargo/{id}', 'Gestion\NotificacioncargoController@guardardescargo')->name('notificacioncargo.guardardescargo');
    Route::get('notificacioncargo/resolucion/{id}/{listarluego}', 'Gestion\NotificacioncargoController@resolucion')->name('notificacioncargo.resolucion');
    Route::get('notificacioncargo/confirmarresolucion/{id}', 'Gestion\NotificacioncargoController@confirmarresolucion')->name('notificacioncargo.confirmarresolucion');
    Route::get('notificacioncargo/archivar/{id}/{listarluego}', 'Gestion\NotificacioncargoController@archivar')->name('notificacioncargo.archivar');
    Route::get('notificacioncargo/confirmararchivar/{id}', 'Gestion\NotificacioncargoController@confirmararchivar')->name('notificacioncargo.confirmararchivar');
    Route::get('notificacioncargo/seguimiento/{id}/{listarluego}', 'Gestion\NotificacioncargoController@seguimiento')->name('notificacioncargo.seguimiento');

    //RESOLUCION SANCION
    Route::post('resolucionsancion/buscar', 'Gestion\ResolucionSancionController@buscar')->name('resolucionsancion.buscar');
    Route::get('resolucionsancion/eliminar/{id}/{listarluego}', 'Gestion\ResolucionSancionController@eliminar')->name('resolucionsancion.eliminar');
    Route::resource('resolucionsancion', 'Gestion\ResolucionSancionController', array('except' => array('show')));
    Route::get('resolucionsancion/pdf/{id}', 'Gestion\ResolucionSancionController@pdf')->name('resolucionsancion.pdf');
    Route::post('resolucionsancion/generarNumero', 'Gestion\ResolucionSancionController@generarNumero')->name('resolucionsancion.generarnumero');
    Route::get('resolucionsancion/confirmacion/{id}/{listarluego}/{accion}', 'Gestion\ResolucionSancionController@confirmacion')->name('resolucionsancion.confirmacion');
    Route::post('resolucionsancion/accion/{id}/{accion}', 'Gestion\ResolucionSancionController@accion')->name('resolucionsancion.accion');


    Route::post('padronfiscalizacion/buscar', 'Gestion\PadronFiscalizacionController@buscar')->name('padronfiscalizacion.buscar');
    Route::get('padronfiscalizacion/eliminar/{id}/{listarluego}', 'Gestion\PadronFiscalizacionController@eliminar')->name('padronfiscalizacion.eliminar');
    Route::resource('padronfiscalizacion', 'Gestion\PadronFiscalizacionController', array('except' => array('show')));
    Route::get('padronfiscalizacion/pdf/{id}', 'Gestion\PadronFiscalizacionController@pdf')->name('padronfiscalizacion.pdf');
    Route::post('padronfiscalizacion/generarNumero', 'Gestion\PadronFiscalizacionController@generarNumero')->name('padronfiscalizacion.generarnumero');
    Route::get('padronfiscalizacion/confirmacion/{id}/{listarluego}/{accion}', 'Gestion\PadronFiscalizacionController@confirmacion')->name('padronfiscalizacion.confirmacion');
    Route::post('padronfiscalizacion/accion/{id}/{accion}', 'Gestion\PadronFiscalizacionController@accion')->name('padronfiscalizacion.accion');

      /* Pretramite */
      Route::post('pretramite/buscar', 'Contribuyente\PretramiteController@buscar')->name('pretramite.buscar');
      Route::get('pretramite/eliminar/{id}/{listarluego}', 'Contribuyente\PretramiteController@eliminar')->name('pretramite.eliminar');
      Route::resource('pretramite', 'Contribuyente\PretramiteController', array('except' => array('show')));
      Route::get('pretramite/aceptar/{id}/{listarluego}', 'Contribuyente\PretramiteController@aceptar')->name('pretramite.aceptar');
      Route::get('pretramite/rechazar/{id}/{listarluego}', 'Contribuyente\PretramiteController@rechazar')->name('pretramite.rechazar');
    Route::get('pretramite/confirmarrechazar/{id}', 'Contribuyente\PretramiteController@confirmarrechazar')->name('pretramite.confirmarrechazar');
    Route::get('pretramite/confirmaraceptar/{id}', 'Contribuyente\PretramiteController@confirmaraceptar')->name('pretramite.confirmaraceptar');
    Route::get('pretramite/crear/{id}/{listarluego}', 'Contribuyente\PretramiteController@crear')->name('pretramite.crear');
    
});

    