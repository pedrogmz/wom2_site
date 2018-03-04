<?PHP

 	////////////////////////////////////////////////////////////////////////////////////
	// Code by R1z			email: r1z@usa.com		Pagina Web: https://r1z.org		  //
	// Perfil Zone: https://metin2zone.net/index.php?/profile/33277-r1z/			  //
	////////////////////////////////////////////////////////////////////////////////////

	$stat_2 =  file_get_contents("./app/include/cron/estadisticas_online_24.txt");
	$stat_2 = number_format($stat_2, 0, ",", ".");

	$stat_3 =  file_get_contents("./app/include/cron/estadisticas_online.txt");
	$stat_3 = number_format($stat_3, 0, ",", ".");

	$stat_4 =  file_get_contents("./app/include/cron/estadisticas_shops.txt");
	$stat_4 = number_format($stat_4, 0, ",", ".");

	$stat_5 =  file_get_contents("./app/include/cron/total_accounts.txt");
	$stat_5 = number_format($stat_5, 0, ",", ".");

	require_once('./app/include/module/index.php');
	
?>