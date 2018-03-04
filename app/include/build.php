<?php
	// Sesión
	session_name("secure");
	session_start([
		'cookie_lifetime' => 86400,
	]);

	mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_STRICT);
	//ini_set ("display_errors", "1");
	error_reporting(E_ALL ^ E_DEPRECATED);
	
	// Time zone
	date_default_timezone_set('Europe/Madrid');
	
	// Cargar el archivo global de configuración
	require_once("./app/include/configure.php");
	
	// Cargar archivo de funciones
	require_once("./app/include/functions.php");
	
	// FireWall Estado
	define('PHP_FIREWALL_ACTIVATION', false );

	// Cargar archivo seguro
	require_once('./app/include/secure.php');
	
	// Cargar archivo de idioma
	require_once('./app/include/languages.php');

	include('./app/include/cron/players.php');
	
	include('./app/include/cron/guilds.php');
	
	// Cargar archivo de verificación
	require_once("./app/include/check.php");
	
	// Cargar archivo de páginas
	require_once("./app/include/pages.php");
	
	