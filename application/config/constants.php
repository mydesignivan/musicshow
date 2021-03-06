<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 				'rb');
define('FOPEN_READ_WRITE',			'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 	'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 			'ab');
define('FOPEN_READ_WRITE_CREATE', 		'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 		'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',	'x+b');

/*
|--------------------------------------------------------------------------
| NOMBRES DE TABLAS (BASE DE DATO)
|--------------------------------------------------------------------------
*/
define('TBL_COUNTRY', 'list_country');
define('TBL_STATES', 'list_states');
define('TBL_CITY', 'list_city');
define('TBL_LOCALITY', 'list_locality');
define('TBL_GENEROS', 'list_generos');
define('TBL_USERS', 'users');
define('TBL_RECITALES', 'recitales');
define('TBL_RECITALES_TO_LUGARVTA', 'recitales_to_lugarvta');
define('TBL_LUGARES', 'lugares');
define('TBL_CONTENT', 'content_index');
define('TBL_DESTACADOS', 'destacados');
define('TBL_BANDAS', 'bandas');
define('TBL_BANDASGALLERY', 'bandas_gallery');
define('TBL_BANDASINT', 'bandas_integrantes');
define('TBL_BANDASDISC', 'bandas_discografica');
define('TBL_BANDASDISCTRACK', 'bandas_discografica_temas');
define('TBL_BANDASOTHERCONTACTS', 'bandas_othercontact');
define('TBL_BANDASWEBLINK', 'bandas_weblink');
define('TBL_BANDASLINKSINTERES', 'bandas_linksinteres');

/*
|--------------------------------------------------------------------------
| UPLOAD FILE
|--------------------------------------------------------------------------
*/
define('UPLOAD_DIR', './uploads/');
define('UPLOAD_FILETYPE', 'gif|jpg|png');
define('UPLOAD_MAXSIZE', 1024); //Expresado en Kylobytes

define('IMAGE_THUMB_WIDTH', 107);
define('IMAGE_THUMB_HEIGHT', 90);
define('IMAGE_ORIGINAL_WIDTH', 800);
define('IMAGE_ORIGINAL_HEIGHT', 600);

/*
|--------------------------------------------------------------------------
| UPLOAD FILE "BANDAS"
|--------------------------------------------------------------------------
*/
define('UPLOAD_BANDA_DIR', './uploads/bandas/');
define('UPLOAD_BANDA_FILETYPE', 'gif|jpg|png');
define('UPLOAD_BANDA_MAXSIZE', 1024); //Expresado en Kylobytes
define('IMAGE_BANDA_THUMB_WIDTH', 107);
define('IMAGE_BANDA_THUMB_HEIGHT', 90);
define('IMAGE_BANDA_ORIGINAL_WIDTH', 800);
define('IMAGE_BANDA_ORIGINAL_HEIGHT', 600);

/*
|--------------------------------------------------------------------------
| UPLOAD FILE "DISCOGRAFICA"
|--------------------------------------------------------------------------
*/
define('UPLOAD_DISC_DIR', './uploads/disc/');
define('UPLOAD_DISC_FILETYPE', 'gif|jpg|png');
define('UPLOAD_DISC_MAXSIZE', 1024); //Expresado en Kylobytes
define('IMAGE_DISC_THUMB_WIDTH', 107);
define('IMAGE_DISC_THUMB_HEIGHT', 90);
define('IMAGE_DISC_ORIGINAL_WIDTH', 800);
define('IMAGE_DISC_ORIGINAL_HEIGHT', 600);


/*
|--------------------------------------------------------------------------
| MENSAJES DE ERROR
|--------------------------------------------------------------------------
*/
define('ERR_UPLOAD_NOTUPLOAD', 'El archivo no ha podido llegar al servidor.');
define('ERR_UPLOAD_MAXSIZE', 'El tamaño del archivo debe ser menor a %s MB.');
define('ERR_UPLOAD_FILETYPE', 'El tipo de archivo es incompatible.');

define('ERR_DB_UPDATE', 'Ha ocurrido un error al tratar de actualizar la tabla "%s".');
define('ERR_DB_INSERT', 'Ha ocurrido un error al tratar de insertar datos en la tabla "%s".');
define('ERR_DB_DELETE', 'Ha ocurrido un error al tratar de eliminar datos en la tabla "%s".');

define('ERR_USER_EDIT',   'El usuario no pudo ser modificado. Si el error coninua por favor, comuniquelo al administrador del sitio.');
define('ERR_USER_DELETE', 'El usuario no pudo ser eliminado. Si el error coninua por favor, comuniquelo al administrador del sitio.');

define('ERR_RECITAL_DELETE', 'El recital no pudo ser eliminado. Si el error coninua por favor, comuniquelo al administrador del sitio.');

define('ERR_DB', 'Ha ocurrido un error en la base de dato, por favor, intentelo mas tarde o comuniquese con el administrador de la web.');

/*
|--------------------------------------------------------------------------
| EMAIL FORM REGISTRO
|--------------------------------------------------------------------------
*/
$msg = 'Hola, %s.<br /><br />';
$msg.= 'Por favor confirme su cuenta de <b>MusicShows</b> haciendo click en este link:<br /><br />';
$msg.= '<a href="%s">%s</a><br /><br />';
$msg.= 'Una vez confirmado, usted tendra acceso completo a <b>MusicShows</b> y todas las notificaciones futuras seran enviadas a esta cuenta de email.<br /><br />';
$msg.= 'Muchas Gracias!<br />www.musicshows.com.ar';

define('EMAIL_REG_FROM', 'no-reply@musicshows.com.ar');
define('EMAIL_REG_NAME', 'musicshows.com.ar');
define('EMAIL_REG_SUBJECT', 'Confirme su cuenta de MusicShows');
define('EMAIL_REG_MESSAGE', $msg);

/*
|--------------------------------------------------------------------------
| EMAIL FORM REGISTRO DE ACTIVACION
|--------------------------------------------------------------------------
*/
$msg = 'Hola, %s.<br /><br />';
$msg.= 'Gracias por registrarte en <b>MusicShows</b>.<br /><br />';
$msg.= 'Tus datos de registro son:<br />';
$msg.= 'Usuario: %s<br />';
$msg.= 'Contrase&ntilde;a: %s<br /><br />';
$msg.= 'Atentamente,<br />';
$msg.= 'www.musicshows.com.ar';

define('EMAIL_REGACTIVE_FROM', 'no-reply@musicshows.com.ar');
define('EMAIL_REGACTIVE_NAME', 'www.musicshows.com.ar');
define('EMAIL_REGACTIVE_SUBJECT', 'Bienvenido a MusicShows');
define('EMAIL_REGACTIVE_MESSAGE', $msg);

/*
|--------------------------------------------------------------------------
| EMAIL RECORDAR CONTRASEÑA
|--------------------------------------------------------------------------
*/
$msg = "Hola!<br /><br />";
$msg.= "¿No recuerda su contrase&ntilde;a?<br />";
$msg.= "Puede sucederle a cualquiera.<br /><br />";
$msg.= "Por favor abra este link en su navegador:<br /><br />";
$msg.= '<a href="%s">%s</a><br /><br />';
$msg.= 'Esto resetear&aacute; su contrase&ntilde;a<br />';
$msg.= 'Usted puede luego ingresar y cambiarla por alguna que recuerde.<br /><br />';
$msg.= 'Atentamente,<br />';
$msg.= 'www.musicshows.com.ar';

define('EMAIL_RP_FROM', 'no-reply@musicshows.com.ar');
define('EMAIL_RP_NAME', 'www.musicshows.com.ar');
define('EMAIL_RP_SUBJECT', 'Resetear su contraseña de www.musicshows.com.ar');
define('EMAIL_RP_MESSAGE', $msg);

/*
|--------------------------------------------------------------------------
| EMAIL CONTACTO
|--------------------------------------------------------------------------
*/
$msg = '<b>Nombre Completo:</b>   %s<br /><br />';
$msg.= '<b>Email:</b>   %s<br /><br />';
$msg.= '<b>Telefono:</b>   %s<br /><br />';
$msg.= '<b>Provincia:</b>   %s<br /><br />';
$msg.= '<b>Ciudad:</b>   %s<br /><br />';
$msg.= '<b>Consulta:</b><hr color="#000000" />%s';

define('EMAIL_CONTACT_SUBJECT', 'Formulario de Consulta');
define('EMAIL_CONTACT_MESSAGE', $msg);

/*
|--------------------------------------------------------------------------
| TITULOS DE CADA SECCION
|--------------------------------------------------------------------------
*/
define('TITLE_GLOBAL', 'MusicShows.com.ar - Fechas de Recitales y Conciertos'); // Titulo para todas las secciones
define('TITLE_INDEX', '');
define('TITLE_FECHAS', '');
define('TITLE_BANDAS', '');
define('TITLE_CONTACTO', '');
define('TITLE_REGISTRO', '');
define('TITLE_MICUENTA', '');
define('TITLE_RECITALES', '');
define('TITLE_RECORDARCONTRA', '');
define('TITLE_VERMAS', '');

/*
|--------------------------------------------------------------------------
| META - Palabras Claves y Descripcion de la web
|--------------------------------------------------------------------------
*/
define('META_KEYWORDS', 'recitales, musica, bandas, fechas de recitales, fechas de bandas, agenda de recitales, bandas de rock, shows, grupos de rock, pop, punk, reggae');
define('META_DESCRIPTION', 'MusicShows.com.ar es el sitio donde los usuarios pueden registrarse y cargar sus recitales gratuitamente. Sirve para buscar los recitales que mas te gustan en todo el pais.');

/*
|--------------------------------------------------------------------------
| CONFIG
|--------------------------------------------------------------------------
*/
define('CFG_COUNT_FREE_RECITAL', 50);   // Cantidad de recitales que puede publicar gratis
define('CFG_TWITTER_USER', 'Music_Shows');
define('CFG_TWITTER_PSS', 'theclash1');

/* End of file constants.php */
/* Location: ./system/application/config/constants.php */