
	<!--***********************************
 	////////////////////////////////////////////////////////////////////////////////////
	// Code by R1z			email: r1z@usa.com		Pagina Web: https://r1z.org		  //
	// Perfil Zone: https://metin2zone.net/index.php?/profile/33277-r1z/			  //
	////////////////////////////////////////////////////////////////////////////////////
													*********************************-->

<?PHP
	if(file_exists(realpath('./app/include/module/pages/user/')."/".GPage(2).".php")) 
		require_once(realpath('./app/include/module/pages/user/')."/".GPage(2).".php");
	else
		require_once(realpath('./app/include/module/pages/user/').'/index.php');
?>	