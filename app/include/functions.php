<?php

	function no_diac($text) {
		$replace = array(
			'0'	=> "a",
			'1'	=> "a",
			'2'	=> "A",	
			'3'	=> "A",	
			'4'	=> "i",
			'5'	=> "I",
			'6'	=> "s",
			'7'	=> "S",
			'8'	=> "t",
			'9'	=> "T",
		);
		$search = array(
			'0'	=> "ă",
			'1'	=> "â",
			'2'	=> "Ă",	
			'3'	=> "Â",	
			'4'	=> "î",
			'5'	=> "Î",
			'6'	=> "ș",
			'7'	=> "Ș",
			'8'	=> "ț",
			'9'	=> "Ț",
		);
		$text = str_replace($search, $replace, $text);
		return $text;
	}
	function escape_input($text){
		if(server_account())
			return server_account()->real_escape_string($text);
		else
			return $text;
	}
	function GPage($v){
		global $_GET;
		$name = "page".$v;
		if(isset($_GET[$name]))
			return $_GET[$name];
		else
			return "";
	}
	function GCok($v){
		global $_COOKIE;
		if(isset($_COOKIE[$v]))
			return $_COOKIE[$v];
		else 
			return "";
	}
	function GServ($v){
		global $_SERVER;
		if(isset($_SERVER[$v]))
			return $_SERVER[$v];
		else 
			return "";
	}
	function GPost($v,$ty = 0){
		global $_POST;
		if(isset($_POST[$v]))
			if($ty == 0)
				return escape_input(no_diac($_POST[$v]));
			else
				return no_diac($_POST[$v]);
		else 
			return "";
	}
	function GSess($v){
		global $_SESSION;
		if(isset($_SESSION[$v]))
			return $_SESSION[$v];
		else 
			return "";
	}
	function r($page = ""){
		global $url;
		header('Location: '.u($page));
		exit;
	}
	function re($page = ""){
		global $url;
		header('Location: '.$page);
		exit;
	}
	function url_tag(){
		$text = "";
		if(GPage(1))
			$text .= GPage(1)."-";
		if(GPage(2))
			$text .= GPage(2)."-";
		if(GPage(3))
			$text .= GPage(3)."-";
		if($text)
			$text .= "/";
		return $text;
	}
	function url_extract($text){
		return str_replace("-", "/", $text);
	}
	function change_language($tag){
		global $lang, $_SESSION;
		$ok = 0;
		foreach($lang as $i => $v) {
			if($i == $tag){
				$ok = 1;
				break;
			}
		}
		if($ok)
			$_SESSION["player_language"] = $tag;
		else
			$_SESSION["player_language"] = s('language');
	}
	function s($tag){
		global $settings;
		return $settings[$tag];
	}
	function u($tag = ""){
		return s('url').$tag;
	}
	function l($id){
		global $lang_list;
		$lang_tag = "";
		if(GSess("player_language"))
			$lang_tag = GSess("player_language");
		else
			$lang_tag = s('language');
		return $lang_list[$lang_tag][$id];
	}
	function dfl(){
		if(GSess("player_language"))
			return GSess("player_language");
		else
			return s('language');
	}
	function shop_login(){
		if(s('url_shop')){
			$id_encrypt = cc(p_id());
			return s('url_shop')."/securelogin/".$id_encrypt."/web/1/";
		}else
			return "#no_shop";
	}
	class Crypter {
		private $key = '9NWWeJRXV5rZ92';
		private $iv = 'AFS';
		function __construct($key,$iv){
			$this->key = $key;
			$this->iv  = $iv;
		}
		protected function getCipher(){
			$cipher = mcrypt_module_open(MCRYPT_BLOWFISH,'','cbc','');
			mcrypt_generic_init($cipher, $this->key, $this->iv);
			return $cipher;
		}
		function encrypt($string){
			$binary = mcrypt_generic($this->getCipher(),$string);
			$string = '';
			for($i = 0; $i < strlen($binary); $i++){
				$string .=  str_pad(ord($binary[$i]),3,'0',STR_PAD_LEFT);
			}
			return $string;
		}
		function decrypt($encrypted){
			$encrypted = str_pad($encrypted, ceil(strlen($encrypted) / 3) * 3,'0', STR_PAD_LEFT);
			$binary = '';
			$values = str_split($encrypted,3);
			foreach($values as $chr){
				$chr = ltrim($chr,'0');
				$binary .= chr($chr);
			}
			return mdecrypt_generic($this->getCipher(),$binary);
		}
	}
	function cc($world,$type=0){
		$key = "!@#$%^&*";
		$crypt = new Crypter('9NWWeJRXV5rZ92',$key);
		if($type==1)
			return $crypt->decrypt($world);
		else
			return $crypt->encrypt($world);
		
	}
	function server_account(){
		global $server_info;
		$conect = mysqli_connect($server_info[1],$server_info[2],$server_info[3],$server_info[4], '1317');
		if($conect)
			mysqli_set_charset($conect, "utf8");
		return $conect;
	}
	function server_forum(){
		global $forum_info;
		$conect = mysqli_connect($forum_info[1],$forum_info[2],$forum_info[3],$forum_info[4], '1317');
		if($conect)
			mysqli_set_charset($conect, "utf8");
		return $conect;
	}
	function server_player(){
		global $server_info;
		$conect = mysqli_connect($server_info[1],$server_info[2],$server_info[3],$server_info[5], '1317');
		mysqli_set_charset($conect, "utf8");
		return $conect;
	}
	function forum(){
		global $forum_info;
		$conect = mysqli_connect($forum_info[1],$forum_info[2],$forum_info[3],$forum_info[4], '1317');
		mysqli_set_charset($conect, "utf8");
		return $conect;
	}
	function p_realbyid($id){
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT * FROM account WHERE id = '".$id."';"),MYSQLI_ASSOC);
		return $ivs["real_name"];
	}
	function p_selectip(){
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT * FROM account WHERE id = '".p_id()."';"),MYSQLI_ASSOC);
		return $ivs["r1z_ip"];
	}
	function server_data(){
		return date('Y-m-d H:i:s');
	}
	function player_exist($login, $password){
		$result = server_account()->query("SELECT COUNT(*) FROM account WHERE login = '$login' AND password = PASSWORD('$password');");
		$row = $result->fetch_row();
		return $row[0];
	}
	function player_exist_email($login, $email){
		$result = server_account()->query("SELECT COUNT(*) FROM account WHERE login = '$login' AND email = '$email';");
		$row = $result->fetch_row();
		return $row[0];
	}
	function player_exist_login($login){
		$result = server_account()->query("SELECT COUNT(*) FROM account WHERE login = '$login';");
		$row = $result->fetch_row();
		return $row[0];
	}
	function count_number_accounts($email) {
		$result = server_account()->query("SELECT COUNT(*) FROM account WHERE email = '$email';");
		$row = $result->fetch_row();
		return $row[0];
	}
	function player_exist_login_email($login,$email){
		$result = server_account()->query("SELECT COUNT(*) FROM account WHERE login = '$login' AND email = '$email';");
		$row = $result->fetch_row();
		return $row[0];
	}
	function player_exist_password($password){
		$result = server_account()->query("SELECT COUNT(*) FROM account WHERE login = '".p_login()."' AND password = PASSWORD('$password');");
		$row = $result->fetch_row();
		return $row[0];
	}
	function player_exist_char($id){
		$result = server_player()->query("SELECT COUNT(*) FROM player WHERE id = '$id'");
		$row = $result->fetch_row();
		return $row[0];
	}
	function player_create($login,$email,$password,$rmcode){
		//$sql_up = "";
		$time = server_data();
		$register_ip = p_ip();
		//return mysqli_query(server_account(),"INSERT INTO account SET login = '$login', password = PASSWORD('$password'), r1z_time = '$r1z_time', register_ip = '".p_ip();"', email = '$email', create_time = '$time', social_id = '$rmcode', status = 'BLOCK', r1z_status = 'WAIT';");
		return mysqli_query(server_account(),"INSERT INTO account SET login = '$login', password = PASSWORD('$password'), register_ip = '$register_ip', email = '$email', create_time = '$time', social_id = '$rmcode', status = 'BLOCK', r1z_status = 'WAIT';");
	}
	function player_update_password($login,$password){
		return mysqli_query(server_account(),"UPDATE account SET password = PASSWORD('$password') WHERE login = '$login'");
	}
	function player_update_email($email){
		return mysqli_query(server_account(),"UPDATE account SET email = '$email' WHERE login = '".p_login()."'");
	}
	function player_update_coins($id,$coins){
		return mysqli_query(server_account(),"UPDATE account SET coins = coins + '$coins' WHERE id = '$id'");
	}
	function player_update_jcoins($id,$coins){
		return mysqli_query(server_account(),"UPDATE account SET votecoins = votecoins + '$coins' WHERE id = '$id'");
	}
	function player_update_vote(){
		return mysqli_query(server_account(),"INSERT INTO r1z_vote SET u_time = '".time()."', u_ip = '".p_ip()."';");
	}
	function player_add_email($email){
		return mysqli_query(server_account(),"UPDATE account SET r1z_email = '".$email."', r1z_temp = 'OFF' WHERE id = '".p_id()."'");
	}
	function player_set_temp($temp, $id = 0){
		if($id == 0){
			$id = p_id();
		}
		if($temp == 1)
			$stat = "ON";
		else
			$stat = "OFF";
		return mysqli_query(server_account(),"UPDATE account SET r1z_temp = '".$stat."' WHERE id = '".p_id()."'");
	}
	function player_select($login, $password,$type = 0){
		global $_SESSION;
		
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT * FROM account WHERE login = '$login' AND password = PASSWORD('$password')"),MYSQLI_ASSOC);
		$passcode = generate_security();
		
		$_SESSION["player_id"] = $ivs["id"];
		$_SESSION["player_login"] = $ivs["login"];
		$_SESSION["player_coins"] = $ivs["coins"];
		$_SESSION["player_jcoins"] = $ivs["votecoins"];
		$_SESSION["player_time"] = $ivs["create_time"];
		$_SESSION["player_email"] = $ivs["email"];
		$_SESSION["player_status"] = $ivs["r1z_status"];
		$_SESSION["player_real_name"] = $ivs["real_name"];
		$_SESSION["player_r1z_email"] = $ivs["r1z_email"];
		$_SESSION["player_temp"] = $ivs["r1z_temp"];
		$_SESSION["player_r1z_secure_code"] = $ivs["r1z_secure_code"];
		$_SESSION["player_r1z_secure"] = $ivs["r1z_secure"];
		if($ivs["r1z_secure"] == "ON"){
			if($ivs["r1z_ip"] == p_ip())
				$_SESSION["player_secure"] = "ON";
			else{
				$_SESSION["player_secure"] = "WAIT";
				$_SESSION["player_secure_code"] = $passcode;
				player_send_email_security_acces($passcode, $ivs["email"], $ivs["login"]);
			}
		}else{
			$_SESSION["player_secure"] = "OFF";
			update_security_ip_id($ivs["id"]);
		}
		if($type == 0){	
		}else{
			setcookie ("player_id", cc($ivs["id"]), time() + (86400 * 30), "/");
		}
	}
	function update_information(){
		global $_SESSION;
		if(GCok("player_id") and !GSess('player_id')){
			$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT * FROM account WHERE id = '".p_id()."';"),MYSQLI_ASSOC);
			$passcode = generate_security();
			$_SESSION["player_id"] = $ivs["id"];
			$_SESSION["player_login"] = $ivs["login"];
			$_SESSION["player_coins"] = $ivs["coins"];
			$_SESSION["player_jcoins"] = $ivs["jcoins"];
			$_SESSION["player_time"] = $ivs["create_time"];
			$_SESSION["player_email"] = $ivs["email"];
			$_SESSION["player_status"] = $ivs["r1z_status"];
			$_SESSION["player_real_name"] = $ivs["real_name"];
			$_SESSION["player_r1z_email"] = $ivs["r1z_email"];
			$_SESSION["player_temp"] = $ivs["r1z_temp"];
			$_SESSION["player_r1z_secure_code"] = $ivs["r1z_secure_code"];
			$_SESSION["player_r1z_secure"] = $ivs["r1z_secure"];
			if($ivs["r1z_secure"] == "ON"){
				if($ivs["r1z_ip"] == p_ip())
					$_SESSION["player_secure"] = "ON";
				else{
					$_SESSION["player_secure"] = "WAIT";
					$_SESSION["player_secure_code"] = $passcode;
					player_send_email_security_acces($passcode, $ivs["email"], $ivs["login"]);
				}
			}else{
				$_SESSION["player_secure"] = "OFF";
				update_security_ip_id($ivs["id"]);
			}			
		}
	}
	function player_select_id($login, $password){
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT * FROM account WHERE login = '$login' AND password = PASSWORD('$password')"),MYSQLI_ASSOC);
		return $ivs["id"];
	}
	function player_select_id_email($login, $email){
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT * FROM account WHERE login = '$login' AND email = '$email'"),MYSQLI_ASSOC);
		return $ivs["id"];
	}
	function player_select_status($login, $password){
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT * FROM account WHERE login = '$login' AND password = PASSWORD('$password')"),MYSQLI_ASSOC);
		return $ivs["status"];
	}
	function player_select_r1z_status($login, $password){
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT * FROM account WHERE login = '$login' AND password = PASSWORD('$password')"),MYSQLI_ASSOC);
		return $ivs["r1z_status"];
	}
	function player_select_status_email($login, $email){
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT * FROM account WHERE login = '$login' AND email = '$email'"),MYSQLI_ASSOC);
		return $ivs["status"];
	}
	function player_send_email($login,$email,$password){
		date_default_timezone_set(s('time_zone'));
		require './app/include/module/mail/PHPMailer.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = s('smtp_host');
		$mail->Port = s('smtp_port');
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = s('smtp_user');
		$mail->Password = s('smtp_pass');
		$mail->setFrom(s('smtp_email'), s('smtp_title'));
		$mail->addReplyTo(s('smtp_reply'), s('smtp_repti'));
		$mail->addAddress($email, $login);
		$mail->Subject = l(101)." ".s('title');
		$mail_body = " ".l(108)." ".$login.",<br><br>".sprintf(l(109),"<b>".$login."</b>")." <b> ".$password." </b><br><br>".$info.l(50)."<br>".l(51)." ".s('title')."<br><br>".u()."";
		$mail->msgHTML($mail_body);
		return $mail->send();
	}
	function player_send_email_register($login,$email,$password,$rmcode){
		date_default_timezone_set(s('time_zone'));
		require './app/include/module/mail/PHPMailer.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'error_log';
		$mail->Host = s('smtp_host');
		$mail->Port = s('smtp_port');
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = s('smtp_user');
		$mail->Password = s('smtp_pass');
		$mail->setFrom(s('smtp_email'), s('smtp_title'));
		$mail->addReplyTo(s('smtp_reply'), s('smtp_repti'));
		$mail->addAddress($email, $login);
		$mail->Subject = l(171)." - ".s('title');
		$id = player_select_id($login, $password);
		$link = u('active/'.cc($id ).'/');
		$here = "<a href='".$link."'>".l(49)."</a> (<a href='".$link."'>".$link."</a>)";
		$info = l(27).": <b>$login</b><br>".l(78).": <b>$rmcode</b><br><br>";
		$mail_body = " ".l(108)." ".$login.",<br><br>".sprintf(l(172),$here,"<b>".$email."</b>",$login)."<br><br>".l(111)."<br><br>".$info.l(50)."<br>".l(51)." ".s('title')."<br><br>".u()."";
		$mail->msgHTML($mail_body);
		return $mail->send();
	}
	function player_send_email_active($email = ""){
		if($email == ""){
			$email = p_email();
		}
		date_default_timezone_set(s('time_zone'));
		require './app/include/module/mail/PHPMailer.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = s('smtp_host');
		$mail->Port = s('smtp_port');
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = s('smtp_user');
		$mail->Password = s('smtp_pass');
		$mail->setFrom(s('smtp_email'), s('smtp_title'));
		$mail->addReplyTo(s('smtp_reply'), s('smtp_repti'));
		$mail->addAddress($email, p_login());
		$mail->Subject = l(171)." - ".s('title');
		$id = p_id();
		$link = u('active/'.cc($id ).'/');
		$here = "<a href='".$link."'>".l(49)."</a> (<a href='".$link."'>".$link."</a>)";
		$mail_body = " ".l(108)." ".p_login().",<br><br>".sprintf(l(172),$here,"<b>".$email."</b>",p_login())."<br><br>".l(111)."<br><br>".l(50)."<br>".l(51)." ".s('title')."<br><br>".u()."";
		$mail->msgHTML($mail_body);
		return $mail->send();
	}
	function player_send_email_confirm_change(){
		date_default_timezone_set(s('time_zone'));
		require './app/include/module/mail/PHPMailer.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = s('smtp_host');
		$mail->Port = s('smtp_port');
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = s('smtp_user');
		$mail->Password = s('smtp_pass');
		$mail->setFrom(s('smtp_email'), s('smtp_title'));
		$mail->addReplyTo(s('smtp_reply'), s('smtp_repti'));
		$mail->addAddress(p_email(), p_login());
		$mail->Subject = l(44)." - ".s('title');
		$id = p_id();
		$link = u('confirm/'.cc($id ).'/');
		$here = "<a href='".$link."'>".l(49)."</a> (<a href='".$link."'>".$link."</a>)";
		$mail_body = " ".l(108)." ".p_login().",<br><br>".l(149)."<br><br>".l(130)."<br><br>".sprintf(l(131),$here)."<br><br>".l(50)."<br>".l(51)." ".s('title')."<br><br>".u()."";
		$mail->msgHTML($mail_body);
		return $mail->send();
	}
	function player_send_email_change($email){
		date_default_timezone_set(s('time_zone'));
		require './app/include/module/mail/PHPMailer.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = s('smtp_host');
		$mail->Port = s('smtp_port');
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = s('smtp_user');
		$mail->Password = s('smtp_pass');
		$mail->setFrom(s('smtp_email'), s('smtp_title'));
		$mail->addReplyTo(s('smtp_reply'), s('smtp_repti'));
		$mail->addAddress($email, p_login());
		$mail->Subject = l(45)." - ".s('title');
		$id = p_id();
		$link = u('update/'.cc($id ).'/');
		$here = "<a href='".$link."'>".l(49)."</a> (<a href='".$link."'>".$link."</a>)";
		$mail_body = " ".l(108)." ".p_login().",<br><br>".sprintf(l(133), $here ,$email)."<br><br>".l(50)."<br>".l(51)." ".s('title')."<br><br>".u()."";
		$mail->msgHTML($mail_body);
		return $mail->send();
	}
	function player_send_email_remove($ass){
		date_default_timezone_set(s('time_zone'));
		require './app/include/module/mail/PHPMailer.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = s('smtp_host');
		$mail->Port = s('smtp_port');
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = s('smtp_user');
		$mail->Password = s('smtp_pass');
		$mail->setFrom(s('smtp_email'), s('smtp_title'));
		$mail->addReplyTo(s('smtp_reply'), s('smtp_repti'));
		$mail->addAddress(p_email(), p_login());
		$mail->Subject = l(78)." - ".s('title');
		$mail_body = " ".l(108)." ".p_login().",<br><br>".sprintf(l(35),"<b>".p_login()."</b>")." <b>".$ass."</b><br><br>".l(50)."<br>".l(51)." ".s('title')."<br><br>".u()."";
		$mail->msgHTML($mail_body);
		return $mail->send();
	}
	function player_send_email_storage($ass){
		date_default_timezone_set(s('time_zone'));
		require './app/include/module/mail/PHPMailer.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = s('smtp_host');
		$mail->Port = s('smtp_port');
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Username = s('smtp_user');
		$mail->Password = s('smtp_pass');
		$mail->setFrom(s('smtp_email'), s('smtp_title'));
		$mail->addReplyTo(s('smtp_reply'), s('smtp_repti'));
		$mail->addAddress(p_email(), p_login());
		$mail->Subject = l(89)." - ".s('title');
		$mail_body = " ".l(108)." ".p_login().",<br><br>".sprintf(l(36),"<b>".p_login()."</b>")." <b>".$ass."</b><br><br>".l(50)."<br>".l(51)." ".s('title')."<br><br>".u()."";
		$mail->msgHTML($mail_body);
		return $mail->send();
	}
	
	function player_make_pw(){
		return substr(md5(rand(999,99999)),0,8);
	}
	function player_make_storage(){
		return substr(md5(rand(999,99999)),0,6);
	}
	function player_make_remove(){
		return rand(1000000,9999999);
	}
	function player_guild($id){
		$ivs=mysqli_fetch_array(mysqli_query(server_player(),"SELECT * FROM guild_member WHERE pid = '".$id."'"),MYSQLI_ASSOC);
		if($ivs["guild_id"]){
			$guild=mysqli_fetch_array(mysqli_query(server_player(),"SELECT * FROM guild WHERE id = '".$ivs["guild_id"]."'"),MYSQLI_ASSOC);
			if($guild["name"])
				return $guild["name"];
			else
				return "-";
		}else
			return "-";
	}
	function player_empire(){
		$ivs=mysqli_fetch_array(mysqli_query(server_player(),"SELECT empire FROM player_index WHERE id = '".p_id()."';"),MYSQLI_ASSOC);
		return $ivs["empire"];
	}
	function player_real_name($id){
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT real_name FROM account WHERE id = '".$id."';"),MYSQLI_ASSOC);
		return $ivs["real_name"];
	}
	function player_rn_login($login){
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT real_name FROM account WHERE login = '".$login."';"),MYSQLI_ASSOC);
		return $ivs["real_name"];
	}
	function player_all_char($id_p){
		$result = server_player()->query("SELECT COUNT(*) FROM player WHERE account_id = '$id_p'");
		$row = $result->fetch_row();
		return $row[0];
	}	
	function account_exist($id){
		$result = server_account()->query("SELECT COUNT(*) FROM account WHERE id = '$id'");
		$row = $result->fetch_row();
		return $row[0];
	}	
	function account_status($id){
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT * FROM account WHERE id = '$id'"),MYSQLI_ASSOC);
		if($ivs["status"] == 'BLOCK' and $ivs["r1z_status"] == 'WAIT')
			return 1;
		else
			return 0;
	}
	function account_update($id){
		return mysqli_query(server_account(),"UPDATE account SET status = 'OK', r1z_status = 'OK' WHERE id = '".$id."';");
	}
	function account_update_remove($pss){
		return mysqli_query(server_account(),"UPDATE account SET social_id = '".$pss."' WHERE id = '".p_id()."';");
	}
	function account_update_storage($pss){
		return mysqli_query(server_player(),"UPDATE safebox SET password = '".$pss."' WHERE account_id = '".p_id()."';");
	}
	function account_update_password($pass){
		return mysqli_query(server_account(),"UPDATE account SET password = PASSWORD('".$pass."') WHERE id = '".p_id()."';");
	}
	function account_update_email($eml){
		return mysqli_query(server_account(),"UPDATE account SET email = '".$eml."' WHERE id = '".p_id()."';");
	}
	function account_update_temp($id){
		return mysqli_query(server_account(),"UPDATE account SET r1z_temp = 'ON' WHERE id = '".$id."';");
	}
	function account_update_new_email($id, $email){
		return mysqli_query(server_account(),"UPDATE account SET email = '".$email."', r1z_email = '', r1z_temp = 'OFF', r1z_status = 'OK' WHERE id = '".$id."';");
	}
	function char_name($id){
		$ivs=mysqli_fetch_array(mysqli_query(server_player(),"SELECT name FROM player WHERE id = '$id'"),MYSQLI_ASSOC);
		return $ivs["name"];
	}
	function char_last_play($id){
		$ivs=mysqli_fetch_array(mysqli_query(server_player(),"SELECT last_play FROM player WHERE id = '$id'"),MYSQLI_ASSOC);
		return strtotime($ivs["last_play"]);
	}
	function get_user_r1z_email($id){
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT r1z_email FROM account WHERE id = '$id'"),MYSQLI_ASSOC);
		return $ivs["r1z_email"];
	}
	function get_user_temp($id){
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT r1z_temp FROM account WHERE id = '$id'"),MYSQLI_ASSOC);
		return $ivs["r1z_temp"];
	}
	function get_user_status($id){
		$id = escape_input($id); 
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT r1z_status FROM account WHERE id = '$id'"),MYSQLI_ASSOC);
		if($ivs["r1z_status"])
			return $ivs["r1z_status"];
		else
			return "OK";
	}
	function get_user_time($id){
		$id = escape_input($id); 
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT r1z_time FROM account WHERE id = '$id'"),MYSQLI_ASSOC);
		if($ivs["r1z_time"])
			return $ivs["r1z_time"];
		else
			return 0;
	}
	function get_user_time_ip($ip){
		$ip = escape_input($ip);
		$ivs=mysqli_fetch_array(mysqli_query(server_account(),"SELECT r1z_time FROM account WHERE register_ip = '$ip' ORDER BY r1z_time DESC LIMIT 1"),MYSQLI_ASSOC);
		if($ivs["r1z_time"])
			return $ivs["r1z_time"];
		else
			return 0;
	}	
	function get_user_password($pass){
		$id = p_id();
		$result = server_account()->query("SELECT COUNT(*) FROM account WHERE id = '".$id."' AND password = PASSWORD('".$pass."');");
		$row = $result->fetch_row();
		return (int)$row[0];
	}

	function check_time($id = 0){
		if($id == 0){
			if(p_id())
				$id = p_id();
			else{
				return 0;
				//break;
			}
		}
		$time_now = time();
		$time_user = get_user_time($id);
		$time_limit = 60 * s('smtp_time');
		$time_diff = $time_now - $time_user;
		if($time_diff >= $time_limit)
			return 1;
		else
			return 0;
	}
	function check_time_ip(){
		$ip = p_ip();
		$time_now = time();
		$time_user = get_user_time_ip($ip);
		$time_limit = 60 * s('smtp_time');
		$time_diff = $time_now - $time_user;
		if($time_diff >= $time_limit)
			return 1;
		else
			return 0;
	}
	function remain_time($id = 0){
		if($id == 0){
			if(p_id())
				$id = p_id();
			else{
				return 0;
				//break;
			}
		}
		$time_now = time();
		$time_user = get_user_time($id);
		$time_limit = 60 * s('smtp_time');
		$time_diff = $time_now - $time_user;
		$time_remail = $time_limit - $time_diff;
		if($time_remail < 0)
			return 0;
		else
			return (int)($time_remail/60);
	}
	function remain_time_ip(){
		$ip = p_ip();
		$time_now = time();
		$time_user = get_user_time_ip($ip);
		$time_limit = 60 * s('smtp_time');
		$time_diff = $time_now - $time_user;
		$time_remail = $time_limit - $time_diff;
		if($time_remail < 0)
			return 0;
		else
			return (int)($time_remail/60);
	}
	function player_unbug($id){
		$empire = player_empire();
		$mi = player_location($empire,'map_index');
		$xx = player_location($empire,'x');
		$yy = player_location($empire,'y');
		return mysqli_query(server_player(),"UPDATE player SET map_index='".$mi."', x='".$xx."', y='".$yy."', 	exit_x='".$xx."', exit_y='".$yy."', exit_map_index='".$mi."', horse_riding='0', last_play = '".date("Y-m-d H:i:s")."' WHERE id='".$id."'");
	}
	function player_update_time($id = 0){
		if($id == 0)
			$id = p_id();
		return mysqli_query(server_account(),"UPDATE account SET r1z_time='".time()."' WHERE id='".$id."'");
	}
	function player_update_time_minus($id = 0){
		if($id == 0)
			$id = p_id();
		return mysqli_query(server_account(),"UPDATE account SET r1z_time='".time() - (60 * s('smtp_time'))."' WHERE id='".$id."'");
	}
	function player_location($empire,$what){
		$resetPos = array();
		$resetPos[1]['map_index'] = 1; 	// RED
		$resetPos[1]['x'] = 468779;
		$resetPos[1]['y'] = 962107;
		$resetPos[2]['map_index'] = 21;	//YELLOW
		$resetPos[2]['x'] = 55700;
		$resetPos[2]['y'] = 157900;
		$resetPos[3]['map_index'] = 41;	// BLUE
		$resetPos[3]['x'] = 969066;
		$resetPos[3]['y'] = 278290;
		return $resetPos[$empire][$what];
	}
	function player_clear(){
		global $_SESSION;
		unset($_SESSION['player_id']);
		unset($_SESSION['player_login']);
		unset($_SESSION['player_coins']);
		unset($_SESSION['player_jcoins']);
		unset($_SESSION['player_status']);
		unset($_SESSION['player_email']);
		unset($_SESSION['player_real_name']);
		unset($_SESSION['player_r1z_email']);
		unset($_SESSION['player_temp']);
		unset($_SESSION['player_r1z_secure_code']);
		unset($_SESSION['player_r1z_secure']);
		unset($_SESSION['player_secure']);
		unset($_SESSION['player_secure_code']);
		if(GCok("player_id")){
			setcookie("player_id", "", time() - (86400 * 30), "/");		
		}
	}
	function p_id(){
		if(GCok("player_id"))
			return (int)cc(GCok("player_id"),1);
		else
			return GSess("player_id");
	}
	function p_login(){
		return GSess("player_login");
	}
	function p_status(){
		return GSess("player_status");
	}
	function p_email(){
		return GSess("player_email");
	}
	function p_time(){
		return GSess("player_time");
	}
	function p_real(){
		return GSess("player_real_name");
	}
	function p_coins(){
		return GSess("player_coins");
	}
	function p_jcoins(){
		return GSess("player_jcoins");
	}
	function p_secure_code(){
		return GSess("player_r1z_secure_code");
	}
	function p_secure(){
		return GSess("player_r1z_secure");
	}
	function p_access(){
		return GSess("player_secure");
	}
	function p_access_code(){
		return GSess("player_secure_code");
	}
	function p_r1z_email(){
		return GSess("player_r1z_email");
	}
	function p_temp(){
		return GSess("player_temp");
	}
	function p_point(){
		$ivs=mysqli_fetch_array(mysqli_query(server_player(),"SELECT point FROM r1z_point WHERE own = '".p_id()."';"),MYSQLI_ASSOC);
		return $ivs["point"];
	}
	function p_ip(){
		global $_SERVER;
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
  			$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		return $_SERVER['REMOTE_ADDR'];
	}
	function max_screenshot($id){
		$num = (int)$id;
		if(!$num)
			return 0;
		elseif($num%28 != 0)
			return max_screenshot($num - 1);
		else
			return $num;
	}
	function max_players($id){
		$num = (int)$id;
		if(!$num)
			return 0;
		elseif($num%10 != 0)
			return max_players($num - 1);
		else
			return $num;
	}

	function user_r1z_vote(){
		$cron_0 = server_account()->query("SELECT COUNT(*) FROM r1z_vote WHERE u_ip = '".p_ip()."';");
		$cron_r0 = $cron_0->fetch_row();
		return (int)$cron_r0[0];
	}

	function statistica_accounts(){
		$cron_1 = server_account()->query("SELECT COUNT(*) FROM account;");
		$cron_r1 = $cron_1->fetch_row();
		return (int)$cron_r1[0];
	}

	function statistica_players(){
		$cron_2 = server_player()->query("SELECT COUNT(*) FROM player;");
		$cron_r2 = $cron_2->fetch_row();
		return (int)$cron_r2[0];
	}

	function estadisticas_online(){
		$cron_3 = server_player()->query("SELECT COUNT(*) FROM player WHERE DATE_SUB(NOW(), INTERVAL 15 MINUTE) < last_play;");
		$cron_r3 = $cron_3->fetch_row();
		return (int)$cron_r3[0];
	}

	function estadisticas_online_24(){
		$cron_3_ = server_player()->query("SELECT COUNT(*) FROM player WHERE DATE_SUB(NOW(), INTERVAL 24 HOUR) < last_play;");
		$cron_r3_ = $cron_3_->fetch_row();
		return (int)$cron_r3_[0];
	}

	function estadisticas_shops(){
		$cron_4 = server_player()->query("SELECT COUNT(*) FROM offline_shop_npc;");
		$cron_r4 = $cron_4->fetch_row();
		return (int)$cron_r4[0];
	}
	
	function player_race($id){
		if($id == 0)
			return l(141);
		elseif($id == 1)
			return l(142);
		elseif($id == 2)
			return l(143);
		elseif($id == 3)
			return l(144);
		elseif($id == 4)
			return l(141);
		elseif($id == 5)
			return l(142);
		elseif($id == 6)
			return l(143);
		elseif($id == 7)
			return l(144);
		elseif($id == 8)
			return l(145);
		else
			return l(67);
	}
	function page_active($local){
		$page = GPage(1);
		if($local == "index" and ($page == "" or $page == "index"))
			return "mni_active";
		elseif($local == "ranking" and ($page == "ranking"))
			return "mni_active";
	}
	function page_active_($local){
		$page = GPage(1);
		if($local == "index" and ($page == "" or $page == "index"))
			return '<div class="mni_active_triangle"></div>';
		elseif($local == "ranking" and ($page == "ranking"))
			return '<div class="mni_active_triangle"></div>';
	}
	function recaptcha($vv){
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.s('s_recaptcha').'&response='.$vv);
		$responseData = json_decode($verifyResponse);
		return $responseData->success;
	}
	function title_page(){
		$page = s('title');
		if(GPage(1) == "register")
			return $page." - ".l(208);
		elseif(GPage(1) == "download")
			return $page." - ".l(210);
		elseif(GPage(1) == "ranking" and GPage(2) == "guilds")
			return $page." - ".l(211)." ".l(11);
		elseif(GPage(1) == "ranking")
			return $page." - ".l(211)." ".l(10);
		elseif(GPage(1) == "privacy")
			return $page." - ".l(184);
		elseif(GPage(1) == "tos")
			return $page." - ".l(183);
		elseif(GPage(1) == "dmca")
			return $page." - ".l(185);
		else
			return $page." - ".l(209);
	}
	function generate_security(){
		return strtoupper(substr(md5(rand(999,99999)),0,6));
	}
	function update_security_code($password){
		global $_SESSION;
		$_SESSION['player_r1z_secure_code'] = $password;
		return mysqli_query(server_account(),"UPDATE account SET r1z_secure_code = '$password' WHERE id = '".p_id()."'");
	}
	function player_send_email_security($pass){
		date_default_timezone_set(s('time_zone'));
		require './app/include/module/mail/PHPMailer.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = s('smtp_host');
		$mail->Port = s('smtp_port');
		$mail->SMTPAuth = true;
		$mail->Username = s('smtp_user');
		$mail->Password = s('smtp_pass');
		$mail->setFrom(s('smtp_email'), s('smtp_title'));
		$mail->addReplyTo(s('smtp_reply'), s('smtp_repti'));
		$mail->addAddress(p_email(), p_login());
		$mail->Subject = l(221)." - ".s('title');
		$here = '<div style="padding:5px;height:16px;width:75px;font-size:18px;background-color:black;text-align:center;color:#fff;font-family:&quot;Lucida Sans Typewriter&quot;,&quot;Lucida Console&quot;,Monaco,&quot;Bitstream Vera Sans Mono&quot;,monospace;border-radius:3px">'.$pass.'</div>';
		$mail_body = " ".l(108)." ".p_login().",<br><br>".l(222)."<br><br>".$here."<br><br>".l(223)."<br><br>".l(50)."<br>".l(51)." ".s('title')."<br><br>".u()."";
		$mail->msgHTML($mail_body);
		return $mail->send();
	}
	function player_send_email_security_remove($pass){
		date_default_timezone_set(s('time_zone'));
		require './app/include/module/mail/PHPMailer.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = s('smtp_host');
		$mail->Port = s('smtp_port');
		$mail->SMTPAuth = true;
		$mail->Username = s('smtp_user');
		$mail->Password = s('smtp_pass');
		$mail->setFrom(s('smtp_email'), s('smtp_title'));
		$mail->addReplyTo(s('smtp_reply'), s('smtp_repti'));
		$mail->addAddress(p_email(), p_login());
		$mail->Subject = l(221)." - ".s('title');
		$here = '<div style="padding:5px;height:16px;width:75px;font-size:18px;background-color:black;text-align:center;color:#fff;font-family:&quot;Lucida Sans Typewriter&quot;,&quot;Lucida Console&quot;,Monaco,&quot;Bitstream Vera Sans Mono&quot;,monospace;border-radius:3px">'.$pass.'</div>';
		$mail_body = " ".l(108)." ".p_login().",<br><br>".l(231)."<br><br>".$here."<br><br>".l(230)."<br><br>".l(50)."<br>".l(51)." ".s('title')."<br><br>".u()."";
		$mail->msgHTML($mail_body);
		return $mail->send();
	}
	function player_send_email_security_acces($pass,$email,$login){
		date_default_timezone_set(s('time_zone'));
		require './app/include/module/mail/PHPMailer.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = s('smtp_host');
		$mail->Port = s('smtp_port');
		$mail->SMTPAuth = true;
		$mail->Username = s('smtp_user');
		$mail->Password = s('smtp_pass');
		$mail->setFrom(s('smtp_email'), s('smtp_title'));
		$mail->addReplyTo(s('smtp_reply'), s('smtp_repti'));
		$mail->addAddress($email, $login);
		$mail->Subject = l(221)." - ".s('title');
		$here = '<div style="padding:5px;height:23px;width:120px;font-size:18px;background-color:black;text-align:center;color:#fff;font-family:&quot;Lucida Sans Typewriter&quot;,&quot;Lucida Console&quot;,Monaco,&quot;Bitstream Vera Sans Mono&quot;,monospace;border-radius:3px">'.$pass.'</div>';
		$mail_body = " ".l(108)." ".$login.",<br><br>".l(238)."<br><br>".$here."<br><br>".l(239)."<br><br>".l(50)."<br>".l(51)." ".s('title')."<br><br>".u()."";
		$mail->msgHTML($mail_body);
		return $mail->send();
	}
	function update_security(){
		global $_SESSION;
		$_SESSION['player_r1z_secure_code'] = "";
		$_SESSION['player_r1z_secure'] = "ON";
		return mysqli_query(server_account(),"UPDATE account SET r1z_secure_code = '', r1z_secure = 'ON', r1z_ip = '".p_ip()."' WHERE id = '".p_id()."'");
	}
	function update_security_diss(){
		global $_SESSION;
		$_SESSION['player_r1z_secure_code'] = "";
		$_SESSION['player_r1z_secure'] = "";
		return mysqli_query(server_account(),"UPDATE account SET r1z_secure_code = '', r1z_secure = '' WHERE id = '".p_id()."'");
	}
	function update_security_ip(){
		return mysqli_query(server_account(),"UPDATE account SET r1z_ip = '".p_ip()."' WHERE id = '".p_id()."'");
	}
	function update_security_ip_id($id){
		return mysqli_query(server_account(),"UPDATE account SET r1z_ip = '".p_ip()."' WHERE id = '".$id."'");
	}
	function edit_title($text){
		if(strlen($text)>45)
			return substr($text, 0, 42) . ' ...';
		else
			return $text; 
	}
	function select_text($id){
		$ivs=mysqli_fetch_array(mysqli_query(server_forum(),"SELECT * FROM wbb1_post WHERE threadID = '$id'"),MYSQLI_ASSOC);
		return substr($ivs["message"], 0, 295) . '... <b>Leer Más</b>';
	}
	function Sucuri(){
		if(isset($_SERVER['HTTP_X_SUCURI_CLIENTIP'])){ // Si utilizas Sucuri en tu pagina web como proxy inverso
		$_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_X_SUCURI_CLIENTIP'];}
	}
	function CloudFlare(){
		if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])){ // Si utilizas CloudFlare en tu pagina web como proxy inverso
		$_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_CF_CONNECTING_IP'];}
	}

	function romanic_number($integer, $upcase = true) { 
		$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1, '0'=>0); 
		$return = ''; 
		while($integer > 0) { 
			foreach($table as $rom=>$arb) { 
				if($integer >= $arb) { 
					$integer -= $arb; 
					$return .= $rom; 
					break; 
				} 
			} 
		} 

		return $return; 
	}

	class Vote
	{
		public function do_vote()
		{
			$check_status = 1;
			$url = 'http://api.metin2pserver.info/API.php?ID=mt2fenix&email=support@metin2fenix.com&name='.p_id();
			$topl_curl = curl_init();
			$oktopl_curl = curl_init();
			curl_setopt($topl_curl, CURLOPT_URL, $url);
			curl_setopt($topl_curl, CURLOPT_HEADER, 0);
			curl_setopt($topl_curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($topl_curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11');
			$topl_data = curl_exec($topl_curl);
			$topl_info = curl_getinfo($topl_curl);
			if (!curl_errno($topl_curl)) {
				if ($topl_info['http_code'] == 200) {
					$data_json = json_decode($topl_data, true);
					if($data_json['count'] == '0') {
						$check_type = "red";
						echo '<div class="notification notification_red noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text">'.l(263).'</div>
		</div>
	</div>';
					} elseif($data_json['result']['count'] == '0') {
						$check_type = "red";
						echo '<div class="notification notification_red noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text">'.l(263).'</div>
		</div>
	</div>';
					} elseif($data_json['result']['status'] == '2') {
						$check_type = "red";
						echo '<div class="notification notification_red noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text">'.l(260).'</div>
		</div>
	</div>';
					}elseif ($data_json['result']['status'] == '0') {
						$check_type = "red";
						echo '<div class="notification notification_red noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text">'.l(262).'</div>
		</div>
	</div>';
					}elseif ($data_json['result']['status'] == '1') {
						$okurl = 'http://api.metin2pserver.info/callback.php?ID=mt2fenix&name='.p_id();
						curl_setopt($oktopl_curl, CURLOPT_URL, $okurl);
						curl_setopt($oktopl_curl, CURLOPT_HEADER, 0);
						curl_setopt($oktopl_curl, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($oktopl_curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11');
						$oktopl_data = curl_exec($oktopl_curl);
						$oktopl_info = curl_getinfo($oktopl_curl);
						if (!curl_errno($oktopl_curl) && $oktopl_info['http_code'] == 200) {
							$okdata_json = json_decode($oktopl_data, true);
							if ($okdata_json['response'] == 'OK') {
								player_update_jcoins(p_id(), s('vote_free_win'));
								$win_coins = p_jcoins() + s('vote_free_win');
								$_SESSION["player_coins"] = $win_coins;
								$check_type = "green";
								echo '<div class="notification notification_green noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text">'.l(261).'</div>
		</div>
	</div>';
							} else {
								$check_type = "red";
								echo '<div class="notification notification_red noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text">'.l(260).'</div>
		</div>
	</div>';
							}
						} else {
							$check_type = "red";
							echo '<div class="notification notification_red noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text">'.l(259).'</div>
		</div>
	</div>';
						}
					}
				}else{
					$check_type = "red";
					echo '<div class="notification notification_red noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text">'.l(259).'</div>
		</div>
	</div>';
				}
			}else{
				$check_type = "red";
				echo '<div class="notification notification_red noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text">'.l(258).'</div>
		</div>
	</div>';
			}
			curl_close($topl_curl);
			curl_close($oktopl_curl);
		}

		public function vote_forms()
		{
			if(GPost('submit') != '') {
				$this->do_vote();
			} else {
				echo '<div class="main_board_regular_text">'.l(254).' '.l(255).'</div><br><form id="form" method="post" action="" onsubmit="votepopup(\''.'https://www.metin2pserver.info/vote.htm?id=mt2fenix&name='.p_id().'\'); return false;"><button type="submit" value="foo" name="submit" id="support_blue" class="vote_for_coins_icon vote_button"></button><div class="vote_for_coins_message"><p>'.sprintf(l(40),s('vote_free_win')).'</p><p class="voting_website">'.s('vote_free_nm').'</p></div><br></form><div class="main_board_regular_text">'.l(257).'</div>';
			}
		}
	}

	function get_country($ip) {
		return str_replace("\n", "", file_get_contents("http://ipinfo.io/{$ip}/country"));
	}

	function getPaymentMethodsByCountry($country) {
		header('Content-Type: application/json');
		$query = '?uid=94&mid=230&apikey=AT986PV4T3RM6NJS&cc='.strtolower($country);
		//$query = '?uid=94&mid=230&apikey=AT986PV4T3RM6NJS&cc=es';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.e-payouts.com/getData.php" . $query);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, 'Content-Type: application/json');
		$result = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($result, true);
		if(!isset($data['data']['modules']['methods'])) {
			$html = "No hay metodos de pagos disponibles para tu pais";
		} else {
			foreach ($data['data']['modules']['methods'] as $key => $value) {
				$html .= '<button id="activate_button" onclick="nextStep(this);" type="button" name="method" value="'.$key.'">'.$key.'</button>';
			}
		}
		return $html;
	}
?>