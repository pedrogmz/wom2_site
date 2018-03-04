<?php 
	$ip = array("127.0.0.1");
	if(!in_array($_SERVER["REMOTE_ADDR"], $ip)) die("Acceso no permitido.");
?>

<?php
	
 	////////////////////////////////////////////////////////////////////////////////////
	// Code by R1z			email: r1z@usa.com		Pagina Web: https://r1z.org		  //
	// Perfil Zone: https://metin2zone.net/index.php?/profile/33277-r1z/			  //
	////////////////////////////////////////////////////////////////////////////////////
	
	// Cargar el archivo global de configuración
	require_once("./app/include/configure.php");
	
	// Cargar archivo de funciones
	require_once("./app/include/functions.php");

	$limit_level = 90;		// Nivl minimo para obtener los coins
	$limit_time = 604800;		// Tiempo minimo para obtener los coins
	$coins_win = 100;		// Coins en premio al obtener lo anterior
	
	// Compruebe la conexión del servidor
	if(server_account() and server_player()) {

		// Shops Registered (estadisticas_shops.txt) (Si dispones de sistema de tiendas offline quita las anotaciones / * y * /
		{
			$cron_p0 = estadisticas_shops();
			$cron_f0 = fopen(s('cron')."estadisticas_shops.txt", "w");
			fwrite($cron_f0, $cron_p0);
			fclose($cron_f0);
			echo "Succes Write <b>estadisticas_shops.txt</b>...<br>\n";
		}
		
		// Player Online (statistica_players.txt)
		{
			$cron_p3 = estadisticas_online();
			$cron_f3 = fopen(s('cron')."estadisticas_online.txt", "w");
			fwrite($cron_f3, $cron_p3);
			fclose($cron_f3);
			echo "Cron Ejecutado <b>estadisticas_online.txt</b>...<br>\n";
		}

		// Player Online 24h (estadisticas_online_24.txt)
		{
			$cron_p3_ = estadisticas_online_24();
			$cron_f3 = fopen(s('cron')."estadisticas_online_24.txt", "w");
			fwrite($cron_f3, $cron_p3_);
			fclose($cron_f3);
			echo "Cron Ejecutado <b>estadisticas_online_24.txt</b>...<br>\n";
		}

		// Total accounts
		{
			$cron_p3_ = statistica_accounts();
			$cron_f3 = fopen(s('cron')."total_accounts.txt", "w");
			fwrite($cron_f3, $cron_p3_);
			fclose($cron_f3);
			echo "Cron ejecutado <b>total_accounts.txt</b>...<br>\n";
		}
		
		// Player Top Players (players.php)
		{
			$cron_p6 = '<?PHP $players = array(';
			$total6 = 0;
			if ($cron_6=mysqli_query(server_player(),"SELECT player.id,player.name,player.level,player.job,player_index.empire,account.status FROM player left join account.account on account.id=player.account_id LEFT JOIN player_index ON player_index.id=player.account_id WHERE player.name NOT LIKE '[%]%' AND account.status != 'BLOCK' and availDt = '0000-00-00 00:00:00' ORDER BY player.level DESC, player.exp DESC, player.playtime DESC;"))
				while ($cron_r6=mysqli_fetch_object($cron_6)){ 
					$total6++;	
					$cron_p6 .= ' '.$total6.' => ["'.$cron_r6->name.'", '.$cron_r6->empire.', '.$cron_r6->level.', '.$cron_r6->job.'],';
				}
			$cron_p6 .= ');';
			$cron_f6 = fopen(s('cron')."players.php", "w");
			fwrite($cron_f6, $cron_p6);
			fclose($cron_f6);
			echo "Cron Ejecutado <b>players.php</b>...<br>\n";

			// Player Top Guilds (guilds.php)
			$cron_p7 = '<?PHP $guilds = array(';
			$total7 = 0;
			if ($cron_7=mysqli_query(server_player(), "SELECT guild.name, guild.level, guild.ladder_point, player.name AS player_name, player_index.empire AS guild_empire FROM guild LEFT JOIN player ON player.id = guild.master LEFT JOIN player_index ON player_index.id=player.account_id ORDER BY guild.ladder_point DESC, guild.name ASC;"))
				while ($cron_r7=mysqli_fetch_object($cron_7)){ 
					$total7++;
					$empr = ($cron_r7->guild_empire)?$cron_r7->guild_empire:1;
					$cron_p7 .= ' '.$total7.' => ["'.$cron_r7->name.'", '.$empr.', '.$cron_r7->ladder_point.'],';
				}
			$cron_p7 .= ');';
			$cron_f7 = fopen(s('cron')."guilds.php", "w");
			fwrite($cron_f7, $cron_p7);
			fclose($cron_f7);
			echo "Cron Ejecutado <b>guilds.php</b>...<br>\n";
		}

		{
			$referidos = mysqli_query(server_account(), "SELECT * FROM aff_users WHERE status = 'WAIT'");
			while ($referido = mysqli_fetch_object($referidos)) {
				$cuenta_referida = $referido->player;
				if ($navconn = mysqli_query(server_player(), "SELECT level,playtime FROM player WHERE account_id = '$cuenta_referida'")) {
					while ($player = mysqli_fetch_object($navconn)) {
						if($player->level >= $limit_level and $player->playtime >= $limit_time) {
							mysqli_query(server_account(),"UPDATE aff_users SET status = 'CLOSE', ch_dat = '".date('Y-m-d H:i:s')."' WHERE player = '$cuenta_referida'");
							$aff_id = $referido->aff;
							mysqli_query($ser_connect,"UPDATE account SET coins = coins + '$coins_win' WHERE id = '$aff_id'");
							
						}
					}
				}
			}
			echo "Cron Ejecutado <b>referidos.php</b>...<br>\n";
		}

		// Actualizar lista de votos
		/*{
			if ($cron_8=mysqli_query(server_account(), "SELECT * FROM r1z_vote;"))
				while ($cron_r8=mysqli_fetch_object($cron_8)){ 
					$u_time = time();
					$u_time = $u_time - (s('vote_time') * 60 * 60);
					if($cron_r8->u_time <= $u_time){
						server_account()->query("DELETE FROM r1z_vote WHERE id = '".$cron_r8->id."';");
					}
				}
			echo "Update Vote List ...<br>\n";
		}*/
		
		// Lista de noticias (news.php)		["title", "text", "url", "time"]
		/*if(server_forum()){
			$cron_p10 = '<?PHP $news_info = array( ';
			$total10 = 0;
			if ($cron_10=mysqli_query(server_forum(), "SELECT * FROM wbb1_thread WHERE boardID = '2' ORDER by threadID DESC LIMIT 28;"))
				while ($cron_r10=mysqli_fetch_object($cron_10)){ 
					$total10++;
					$cron_p10 .= ' '.$total10.' => [ "title" => "'.edit_title($cron_r10->topic).'", 
					"text" => "'.cc(select_text($cron_r10->threadID)).'", 
					"url" => "//ejemplo.com/index.php?thread/'.$cron_r10->threadID.'/", 
					"time" => "'.date("d/m/Y (H:i)",$cron_r10->time).'",], ';
				}
			$cron_p10 .= ');';
			$cron_f10 = fopen(s('cron')."news.php", "w");
			fwrite($cron_f10, $cron_p10);
			fclose($cron_f10);
			echo "Cron Ejecutado <b>news.php</b>...<br>\n";
		}
	*/
		// DMCA
		if(s('cron_dmca')){
			$cron_p11 = '<?PHP $dmca_info = array( ';
			$total11 = 0;
			if ($cron_10=mysqli_query(server_account(), "SELECT * FROM r1z_dmca;"))
				while ($cron_r11=mysqli_fetch_object($cron_10)){ 
					$total11++;
					$cron_p11 .= ' '.$total11.' => [ "tt" => "'.$cron_r11->types.'", 
					"t_ro" => "'.cc($cron_r11->ro).'", 
					"t_en" => "'.cc($cron_r11->en).'", 
					"t_es" => "'.cc($cron_r11->es).'",], ';
				}
			$cron_p11 .= ');';
			$cron_f11 = fopen(s('cron')."dmca.php", "w");
			fwrite($cron_f11, $cron_p11);
			fclose($cron_f11);
			echo "Cron Ejecutado <b>dmca.php</b>...<br>\n";
		}
		
		// Privacy
		if(s('cron_privacy')){
			$cron_p12 = '<?PHP $privacy_info = array( ';
			$total12 = 0;
			if ($cron_10=mysqli_query(server_account(), "SELECT * FROM r1z_privacy;"))
				while ($cron_r12=mysqli_fetch_object($cron_10)){ 
					$total12++;
					$cron_p12 .= ' '.$total12.' => [ "tt" => "'.$cron_r12->types.'", 
					"t_ro" => "'.cc($cron_r12->ro).'", 
					"t_en" => "'.cc($cron_r12->en).'", 
					"t_es" => "'.cc($cron_r12->es).'",], ';
				}
			$cron_p12 .= ');';
			$cron_f12 = fopen(s('cron')."privacy.php", "w");
			fwrite($cron_f12, $cron_p12);
			fclose($cron_f12);
			echo "Cron Ejecutado <b>privacy.php</b>...<br>\n";
		}
		
		// Tos
		if(s('cron_tos')){
			$cron_p13 = '<?PHP $tos_info = array( ';
			$total13 = 0;
			if ($cron_10=mysqli_query(server_account(), "SELECT * FROM r1z_tos;"))
				while ($cron_r13=mysqli_fetch_object($cron_10)){ 
					$total13++;
					$cron_p13 .= ' '.$total13.' => [ "tt" => "'.$cron_r13->types.'", 
					"t_ro" => "'.cc($cron_r13->ro).'", 
					"t_en" => "'.cc($cron_r13->en).'", 
					"t_es" => "'.cc($cron_r13->es).'",], ';
				}
			$cron_p13 .= ');';
			$cron_f13 = fopen(s('cron')."tos.php", "w");
			fwrite($cron_f13, $cron_p13);
			fclose($cron_f13);
			echo "Cron Ejecutado <b>tos.php</b>...<br>\n";
		}


	}else{
		echo "Error en la conexión con el servidor...<br>\n";
	}