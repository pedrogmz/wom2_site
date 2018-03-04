<?php

	$check_status_login = 0;
	$check_status = 0;
	$check_status_thow = 0;
	$check_msg = "";
	$check_msg_two = "";
	$check_type = "red";
	$check_type_two = "red";
	
	// Check Page
	if(!p_id() and (GPage(1)=="user" or GPage(1) == "logout"))
		r();

	if(p_id() and (GPage(1)=="register" or GPage(1)=="lostpw"))
		r("user/");
	
	if(p_id() and GPage(1) == "user"){
		if(p_access() == "WAIT" and GPage(2) != "confirm")
			r('user/confirm/');
		
		if((p_access() == "ON" or p_access() == "OFF") and GPage(2) == "confirm"){
			r("user/");
		}
	}

	// Logout User
	if(GPage(1) == "logout"){
		player_clear();
		r("");
	}
	
	// User Secure Auto Logout
	if(p_id()){
		if(p_selectip() != p_ip()){
			r("logout/");
		}
	}
	
	// Update user information Session
	if(GCok("player_id") and !GSess('player_id')){
		update_information();
		r('user/');
	}

	// Load Player Top
	if(GPage(1) == "ranking"){
		if(GPage(2) == "guilds"){
			$start = max_players((int)GPage(3));
			$max = count($guilds);;
			if($start > $max)
				$start = max_players($max);
			$stop = $start + 10;
			if($stop > $max)
				$stop = $max;

			if($max >= 100 and !GPost("search",1))
				$max = 100;

			if(GPost("search",1)){
				$nrfind = 0;
				for($p = 1; $p <= count($guilds); $p++)
					if(GPost("search",1) == $guilds[$p][0]){
						$pp = max_players($p - 1);
						r("ranking/guilds/$pp/$p/");
					}
				if(!$nrfind){
					r("ranking/guilds/");
				}
			}
			$p_name = "";
			$p_pos =(int)GPage(4);
			if($p_pos){
				if($p_pos > 0 and $p_pos <= count($guilds))
					$p_name = $guilds[$p_pos][0];
				
				if($p_pos > $start + 10 or $p_pos <= $start){
					$pp = max_players($p_pos - 1);
					r("ranking/guilds/$pp/$p_pos/");
				}
			}			
		}else{
			$start = max_players((int)GPage(3));
			$max = count($players);
			if($start > $max)
				$start = max_players($max);
			$stop = $start + 10;
			if($stop > $max)
				$stop = $max;
			
			if($max >= 100 and !GPost("search",1))
				$max = 100;
			
			if(GPost("search",1)){
				$nrfind = 0;
				for($p = 1; $p <= count($players); $p++)
					if(GPost("search",1) == $players[$p][0]){
						$pp = max_players($p - 1);
						r("ranking/players/$pp/$p/");
					}
				if(!$nrfind){
					r("ranking/players/");
				}
			}
			$p_name = "";
			$p_pos =(int)GPage(4);
			if($p_pos){
				if($p_pos > 0 and $p_pos <= count($players))
					$p_name = $players[$p_pos][0];
				
				if($p_pos > $start + 10 or $p_pos <= $start){
					$pp = max_players($p_pos - 1);
					r("ranking/players/$pp/$p_pos/");
				}
			}
		}
	}
	
	// Load News Index
	if(GPage(1) == "" or GPage(1) == "index" or GPage(1) == "confirm" or GPage(1) == "update" or GPage(1) == "active"){
		include('./app/include/cron/news.php');
		$max = count($news_info);
		$page = 0;
		$ver = 0;
		$_page = 0;
		$_ver = 0;
		$pos = 0;
	}

	// DMCA Load file
	if(GPage(1) == "dmca"){
		include('./app/include/cron/dmca.php');
	}
	
	// Privacy Load file
	if(GPage(1) == "privacy"){
		include('./app/include/cron/privacy.php');
	}
	
	// Tos Load file
	if(GPage(1) == "tos"){
		include('./app/include/cron/tos.php');
	}
	
	// Select Language
	if(GPage(1) == "language"){
		if(GPage(2)){
			change_language(GPage(2));
			r(url_extract(GPage(3)));
		}else{
			r();
		}
	}
	
	// Login Form
	if(!p_id()){
		if(GPost("submit_login") and GPost("submit_login") == no_diac(l(26))){
			$check_status_login = 1;
			//var_dump(GPost('userid').' + '.GPost('userpass'));
			if(server_account()){
				if(GPost("userid") and GPost("userpass")){
					if(player_exist(GPost("userid"), GPost("userpass"))){
						if((player_select_status(GPost("userid"), GPost("userpass")) != "BLOCK") || (player_select_r1z_status(GPost("userid"), GPost("userpass")) == 'WAIT' && player_select_status(GPost("userid"), GPost("userpass")) == "BLOCK")) {
							if(GPost('remember_me'))
								$ltype = 1;
							else
								$ltype = 0;
							player_select(GPost("userid"), GPost("userpass"), $ltype);
							r("user/");
						}else{
							$check_msg = l(34);							
						}
					}else{
						$check_msg = l(33);
					}
				}else{
					$check_msg = l(32);
				}
			}else{
				$check_msg = l(31);
			}
		}
	}
	

	// Register User
	if(GPage(1) == "register"){
		$post_user_send = GPost("user_send");
		$post_tyc = GPost("tyc");
		$post_mailoptin = GPost("mailoptin");
		$post_login = GPost("login");
		$post_password = GPost("password");
		$post_email = GPost("email");
		$post_chardeletecode = GPost("chardeletecode");
		$post_grecaptcharesponse = GPost("g-recaptcha-response");
		
		if($post_user_send and $post_user_send == no_diac(l(76))){
			$check_status = 1;
			if(!server_account()){
				$check_msg = l(31);
				return;
			}
			if(!$post_tyc){
				$check_msg = l(214);
				return;				
			}
			if(!$post_grecaptcharesponse and !recaptcha($post_grecaptcharesponse)){
				$check_msg = l(212);
				return;
			}
			if(!$post_login or !$post_email or !$post_password or !$post_chardeletecode){
				$check_msg = l(32);
				return;
			}
			if(!ctype_digit($post_chardeletecode)){
				$check_msg = l(213);
				return;
			}
			if((int)count_number_accounts($post_email) >= 3) {
				$check_msg = l(243);
				return;
			}
			if(filter_var($post_email, FILTER_VALIDATE_EMAIL)){
				if(strlen($post_password) >= 8){
					if(!preg_match('/[\'^£$%&*()}{ @#~?><>,|=_+¬-]/', $post_login)){
						if(!player_exist_login($post_login)){
							if(player_create($post_login,$post_email,$post_password,$post_chardeletecode)) {
								if(check_time_ip()) {
									if(player_send_email_register($post_login,$post_email,$post_password,$post_chardeletecode)){
										$referido = player_select_id_email($post_login, $post_email);
										if(GSess("aff_player")) {
											mysqli_query(server_account(), "INSERT INTO aff_users SET aff = '".GSess("aff_player")."', player = '$referido', reg_dat = '".date('Y-m-d H:i:s')."'");
										}
										player_update_time($referido);
										r('verify/');
									} else {
										$check_msg = l(170);
									}
								} else {
									print_r('toy aqui');
									$check_msg = sprintf(l(207),s('smtp_time'),remain_time_ip());
								}
							}else{
								$check_msg = l(84);
							}
						}else{
							$check_msg = l(83);
						}
					}else{
						$check_msg = l(81);
					}
				}else{
					$check_msg = l(80);
				}
			}else{
				$check_msg = l(79);
			}
		}
	}

	// Lost Password	
	if(GPage(1) == "forgotpwd"){
		if(GPost("user_send") and GPost("user_send") == no_diac(l(202))){	
			$check_status = 1;
			if(server_account()){
					if(GPost("user_name") and GPost("user_email") and GPost("g-recaptcha-response")and recaptcha(GPost("g-recaptcha-response"))){
						if(player_exist_login_email(GPost("user_name"),GPost("user_email"))){
							$newpw = player_make_pw();
							if(player_update_password(GPost("user_name"), $newpw)){
								if(player_send_email(GPost("user_name"),GPost("user_email"),$newpw)){
									$check_type = "green";
									$check_msg = sprintf(l(107),GPost("user_email"));									
								}else{
									$check_msg = l(106);
								}
							}else{
								$check_msg = l(105);
							}
						}else{
							$check_msg = l(33);
						}
					}else{
						$check_msg = l(32);
					}			
			}else{
				$check_msg = l(31);
			}
		}
	}
	
	// Resend email active
	if(GPage(1) == "user" and GPage(2) == "verify"){
		if(p_status() == "OK"){
			r("user/");
		}else{
			$check_status = 1;
			if(check_time()){
				if(player_send_email_active()){
					player_update_time();
					$check_type = "green";
					$check_msg = sprintf(l(107),p_email());		
				}else{
					$check_msg = l(170);
				}
			}else{
				$check_msg = sprintf(l(207),s('smtp_time'),remain_time());
			}
		}
	}
	
	// Update Player Remove Characters
	if(GPage(1) == "user" and GPage(2) == "remove"){
		$check_status = 1;
		if(p_status() != "OK"){
			$check_msg = l(158);
		}else{
			if(check_time()){
				$paswd = player_make_remove();
				if(account_update_remove($paswd)){
					if(player_send_email_remove($paswd)){
						player_update_time();
						$check_type = "green";
						$check_msg = sprintf(l(107),p_email());		
					}else{
						$check_msg = l(161);
					}
				}else{
					$check_msg = l(121);
				}
			}else{
				$check_msg = sprintf(l(207),s('smtp_time'),remain_time());
			}
		}
	}
	
	// Update Player Storage Password
	if(GPage(1) == "user" and GPage(2) == "storage"){
		$check_status = 1;
		if(p_status() != "OK"){
			$check_msg = l(158);
		}else{
			if(check_time()){
				$paswd = player_make_storage();
				if(account_update_storage($paswd)){
					if(player_send_email_storage($paswd)){
						player_update_time();
						$check_type = "green";
						$check_msg = sprintf(l(107),p_email());		
					}else{
						$check_msg = l(161);
					}
				}else{
					$check_msg = l(121);
				}
			}else{
				$check_msg = sprintf(l(207),s('smtp_time'),remain_time());
			}
		}
	}
	
	// User Vote Page
	if(GPage(1) == "user" and GPage(2) == "vote"){
		if(p_status() != "OK"){
			$check_status = 1;
			$check_msg = l(41);
		}
	}
	
	// User Security Page
	/*if(GPage(1) == "user" and GPage(2) == "security"){
		if(p_status() != "OK"){
			$check_status = 1;
			$check_msg = l(240);
		}else{
			$permit = 1;
			$post_active = GPost("send_inf");
			$post_activate = GPost("activate");
			if($post_active and $post_activate and ($post_active == l(218) or $post_active == l(229))){
				$check_status = 1;
				if(!p_secure()){
					if(!p_secure_code()){
						$pass = generate_security();
						if(!update_security_code($pass)){
							$check_msg = l(220);
							return;
						}
						if(!player_send_email_security($pass)){
							$check_msg = l(224);
							return;
						}else{
							$check_type = "green";
							$check_msg = sprintf(l(107),p_email());
						}
					}else{
						$code = GPost('code');
						if(!$code){
							$check_msg = l(225);
							return;							
						}
						if($code != p_secure_code()){
							$check_msg = l(226);
							return;							
						}
						if(!update_security()){
							$check_msg = l(227);
						}else{
							$check_type = "green";
							$check_msg = l(228);
							$_SESSION["player_secure"] = "ON";
							$permit = 0;
						}
					}
				}else{
					if(!p_secure_code()){
						$pass = generate_security();
						if(!update_security_code($pass)){
							$check_msg = l(220);
							return;
						}
						if(!player_send_email_security_remove($pass)){
							$check_msg = l(224);
							return;
						}else{
							$check_type = "green";
							$check_msg = sprintf(l(107),p_email());
						}							
					}else{
						$code = GPost('code');
						if(!$code){
							$check_msg = l(225);
							return;							
						}
						if($code != p_secure_code()){
							$check_msg = l(226);
							return;							
						}
						if(!update_security_diss()){
							$check_msg = l(232);
						}else{
							$check_type = "green";
							$check_msg = l(233);
							$_SESSION["player_secure"] = "OFF";
							$permit = 0;
						}
					}
				}
			}
		}
	}*/
	
	// User Security Page
	/*if(GPage(1) == "user" and GPage(2) == "confirm"){
		$post_active = GPost("send_inf");
		if($post_active and $post_active == l(234)){
			$check_status = 1;
			$code = GPost('code');
			if(!$code){
				$check_msg = l(225);
				return;							
			}
			if($code != p_access_code()){
				$check_msg = l(226);
				return;							
			}else{
				$_SESSION["player_secure"] = "ON";
				update_security_ip();
				r("user/");
			}
		}
	}*/
	
	// User Account Settings
	if(GPage(1) == "user" and GPage(2) == ""){
		$gp_usersubm = GPost("usersubm");
		if($gp_usersubm and $gp_usersubm == no_diac(l(90))){
			$gp_new_email = GPost("new_email");
			if($gp_new_email){
				$check_status = 1;
				if(filter_var($gp_new_email, FILTER_VALIDATE_EMAIL)){
					if(p_status() == "OK"){
						if(check_time()){
							if(player_add_email($gp_new_email)){
								if(player_send_email_confirm_change()){
									player_update_time_minus();
									$check_type = "green";
									$check_msg = sprintf(l(107),p_email());		
									$_SESSION["player_r1z_email"] = $gp_new_email;
									$_SESSION["player_temp"] = "OFF";					
								}else{
									$check_msg = l(160);
								}
							}else{
								$check_msg = l(176);
							}
						}else{
							$check_msg = sprintf(l(207), s('smtp_time'), remain_time());
						}
					}else{
						if(check_time()){
							if(account_update_email($gp_new_email)){
								$_SESSION["player_email"] = $gp_new_email;
								if(player_send_email_active($gp_new_email)){
									player_update_time();
									$check_type = "green";
									$check_msg = sprintf(l(107),$gp_new_email);		
								}else{
									$check_msg = l(170);
								}
							}else{
								$check_msg = l(168);
							}
						}else{
							$check_msg = sprintf(l(207), s('smtp_time'), remain_time());
						}
					}
				}else{
					$check_msg = l(79);
				}
			}
			$gp_cur_pwd = GPost('cur_pwd');
			$gp_new_pwd = GPost('new_pwd');
			$gp_new_pwd_confirm = GPost('new_pwd_confirm');
			if($gp_cur_pwd or $gp_new_pwd or $gp_new_pwd_confirm){
				$check_status_thow = 1;
				if($gp_cur_pwd and $gp_new_pwd and $gp_new_pwd_confirm){
					if(strlen($gp_cur_pwd) >= 8 and strlen($gp_new_pwd) >= 8 and strlen($gp_new_pwd_confirm) >= 8){
						if($gp_cur_pwd != $gp_new_pwd){
							if($gp_new_pwd == $gp_new_pwd_confirm){
								if(get_user_password($gp_cur_pwd)){
									if(account_update_password($gp_new_pwd)){
										$check_type_two = "green";
										$check_msg_two = l(124);
									}else{
										$check_msg_two = l(105);
									}
								}else{
									$check_msg_two = l(43);
								}
							}else{
								$check_msg_two = l(122);
							}
						}else{
							$check_msg_two = l(129);
						}
					}else{
						$check_msg_two = l(80);
					}
				}else{
					$check_msg_two = l(32);
				}
			}
		}
	}
	
	// Active account
	if(GPage(1) == "active"){
		if(GPage(2)){
			$id = (int)cc(GPage(2),1);
			$status = get_user_status($id);
			if($status == "OK"){
				r();
			}else{
				$check_status = 1;
				if(account_update($id)){
					$check_type = "green";
					$check_msg = l(174);
					if(p_id()){
						$_SESSION["player_status"] = "OK";
					}
				}else{
					$check_msg = l(173);
				}
			}
		}else{
			r();
		}
	}
	
	// Confirm change email
	if(GPage(1) == "confirm"){
		if(GPage(2)){
			$id = (int)cc(GPage(2), 1);
			$r1z_email = get_user_r1z_email($id);
			if($r1z_email){
				$check_status = 1;
				if(check_time($id)){
					if(account_update_temp($id)){
						if(player_send_email_change($r1z_email)){
							player_update_time($id);
							$check_type = "green";
							$check_msg = sprintf(l(107), $r1z_email);
							$_SESSION["player_temp"] = "ON";			
						}else{
							$check_msg = l(160);
						}
					}else{
						$check_msg = l(132);
					}
				}else{
					$check_msg = sprintf(l(207),s('smtp_time'),remain_time());
				}
			}else{
				r();
			}
		}else{
			r();
		}
	}
	
	// Confirm change email
	if(GPage(1) == "update"){
		if(GPage(2)){
			$id = (int)cc(GPage(2), 1);
			$r1z_email = get_user_r1z_email($id);
			$r1z_temp = get_user_temp($id);
			if($r1z_email and $r1z_temp == "ON"){
				$check_status = 1;
				if(account_update_new_email($id, $r1z_email)){
					$check_type = "green";
					$check_msg = l(46);
					$_SESSION["player_email"] = $r1z_email;
					$_SESSION["player_temp"] = "OFF";
					$_SESSION["player_status"] = "OK";
					$_SESSION["player_r1z_email"] = "";
				}else{
					$check_msg = l(47);
				}
			}else{
				r();
			}
		}else{
			r();
		}
	}
	
	// Desbug
	if(GPage(1) == "user" and GPage(2) == "unblock" and GPage(3)) {
		if(GPage(2)) {
			$check_status = 1;
			$p_char = (int)cc(GPage(3), 1);
			$times = time() - char_last_play($p_char);
			if(player_exist_char($p_char) && $times > (15*60)) {
				if(player_unbug($p_char)) {
					$check_type = "green";
					$check_msg = l(250);
				} else {
					$check_msg = l(151);
				}
			} else {
				$check_msg = l(251);
			}
		} else {
			r();
		}
	}

	//Sistema de referidos
	if(GPage(1) == "ref"){
		if(GPage(2)){
			$account = (int)cc(GPage(2), 1);
			if(account_exist($account)){
				$_SESSION['aff_player'] = $account;
				r("register/");
			} else {
				r();
			}
		} else {
			r();
		}
	}
	
?>