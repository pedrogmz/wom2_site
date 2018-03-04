<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" type="image/x-icon" href="<?=u(s('favicon'));?>">
		<meta name="description" content="<?=s('description');?>">
		<meta name="keywords" content="<?=s('keywords');?>">
		<meta name="author" content="R1z.org">
		<title><?=title_page();?></title>
		<meta property="og:title" content="<?=title_page();?>">
		<link href="https://fonts.googleapis.com/css?family=Merriweather:400,500,600,700,800,900" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?=u('app/design/css/style.css');?>"/>
		<link rel="stylesheet" media="all and (max-width: 1200px)" type="text/css" href="<?=u('app/design/css/style_1200.css');?>"/>
		<link rel="stylesheet" type="text/css" href="<?=u('app/design/css/animations.css');?>"/>
		<link rel="stylesheet" type="text/css" href="<?=u('app/design/css/normalize.css');?>">
		<link rel="stylesheet" type="text/css" href="<?=u('app/design/css/wSelect.css');?>" />
		<link rel="stylesheet" type="text/css" href="<?=u('app/design/plugins/stepwizard/css/stepwizard.css');?>" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		
		<script>
			var urll = "<?=u('language/');?>";
			var urlt = "/<?=url_tag();?>";
		</script>
  	
	</head>
	<body>
		<div id="header">
			<div class="fade_pan">
				<div class="fade_pan_left"></div>
				<div class="fade_pan_right"></div>
			</div>
			<div id="server_select_bar">
				<div class="fade_pan_left"></div>
				<div class="fade_pan_right"></div>
				<select id="server_select" title="<?=l(188);?>">
					<?php foreach($lang as $i => $v){ ?><option value="<?=$i;?>" data-icon="<?=u('app/design/img/'.$i.'.png')?>" <?=($i == dfl())?"selected":"";?> > <?=$v;?> </option><?php } ?>
				</select>
			</div>
			<div id="header_image_1" class="header_image"></div>
			<div id="fixed_navigation_top">
<?php if(p_id()){ ?>
				<div class="main_button">
					<a href="https://www.metin2fenix.com/user/buycoins">
						<button class="main_button_text item_mall_big_button"><?=l(16);?>
						<div id="account_coins">
							<div id="account_dc"><?=p_coins();?> <?=l(126);?></div>
							<div id="account_mc"><?=p_jcoins();?> <?=l(127);?></div>
						</div>
						</button>
					</a>
					<div id="item_mall_button_background"></div>
				</div>
<?php }else{ ?>				
				<div class="main_button">
					<a href="<?=u('register/');?>"><button class="main_button_text"><?=l(187);?></button></a>
					<div id="play_now_button_background"></div>
				</div>
<?php } ?>			
				<div id="main_menu_navigator">
					<div class="fade_pan_left"></div>
					<div class="fade_pan_right"></div>
					<div id="menu_navigator_items_list" class="noselect">
						<div class="menu_navigator_item <?=page_active('index');?>"><a href="<?=u();?>"><?=l(17);?></a> <?=page_active_('index');?> </div>
						<div class="menu_navigator_item <?=page_active('ranking');?>"><a href="<?=u('ranking/');?>"><?=l(182);?></a> <?=page_active_('ranking');?> </div>
						<div class="menu_navigator_item"><a href="/board/"><?=l(15);?></a></div>
						<div style="text-transform: uppercase;" class="menu_navigator_item"><a href="https://discord.gg/jX83bsp" target="_blank"><?=l(245);?></a></div>
						<div style="text-transform: uppercase;" class="menu_navigator_item "><a href="https://www.metin2fenix.com/board/index.php?%2Fforum%2F13-guias-oficiales%2F"><?=l(246);?></a></div>
						<div style="text-transform: uppercase;" class="menu_navigator_item "><a href="https://www.metin2fenix.com/board/index.php?%2Fcalendar%2F"><?=l(276);?></a></div>
						<div class="menu_navigator_item support_item"><a href="<?=s('url_support')?>"><?=l(14);?></a></div>
					</div>
				</div>
			</div>
		</div>
		<div id="container">
	<!-- Ranking left panel -->
	<?php
		if(GPage(1) != "ranking") {
	?>
<div id="left_board">
	<div class="board_title_centeralign"><?=l(12);?></div>
	<div id="ranking_category">
		<div id="left_arrow_ranking"></div>
				<div id="ranking_category_selected" data-rtype='player'><?=l(10);?></div>
		<div   class='hidden' data-rtype='guild'><?=l(11);?></div>
		<div id="right_arrow_ranking"></div>
	</div>
	<table class="hidden" data-ranking="guild">
	<?php for($i = 1; $i <= 5; $i++){ ?>
		<tr class="ranking_table_row">
			<td class="ranking_icon"></td>
			<td class="ranking_playername"><?=$guilds[$i][0]?></td>
			<td class="ranking_points">
			<div class="ranking_points_title"><?=l(9);?></div>
			<div class="ranking_points_value"><?=$guilds[$i][2]?></div>
			</td>
		</tr>
<?php } ?>

	</table>
	<table id="ranking_table">
<?php for($i = 1; $i <= 5; $i++){ ?>
		<tr class="ranking_table_row">
			<td class="ranking_icon"></td>
			<td class="ranking_playername"><?=$players[$i][0]?></td>
			<td class="ranking_points">
				<div class="ranking_points_title"><?=l(8);?></div>
				<div class="ranking_points_value"><?=$players[$i][2]?></div>
			</td>
		</tr>
<?php } ?>
	</table>
	<div id="show_full_ranking" class="small_link_text"><a href="<?=u("ranking/");?>"><?=l(189);?></a></div>
<?php if(s('url_yt_video')){ ?>
	<div id="featured_video">
		<div id="featured_video_title"><?=l(190);?></div>
		<iframe id="video" width="255" height="163" src="<?=s('url_yt_video');?>" frameborder="0" allowfullscreen></iframe>
	</div>
<?php } ?>
</div>

<?php } ?>

<?php
	if(file_exists(realpath('./app/include/module/pages/index/')."/".GPage(1).".php")) 
		require_once(realpath('./app/include/module/pages/index/')."/".GPage(1).".php");
	elseif(GPage(1) == "" or GPage(1) == "confirm" or GPage(1) == "update" or GPage(1) == "active")
		require_once(realpath('./app/include/module/pages/index/').'/index.php');
	else
		require_once(realpath('./app/include/module/pages/index/').'/error.php');
?>
			<div id="right_board">
				<div id="download_button">
					<a href="<?=u("download/");?>">
						<button id="download_button_text">
							<div id="download_button_text_row1" class="noselect"><?=l(191);?></div>
							<div id="download_button_text_row2" class="noselect"><?=l(18);?></div>
						</button>
						<div id="download_button_background"></div>
					</a>
				</div>
<?php if(p_id()){ ?>
<div class="board_title_leftalign"><?=l(115);?></div>
<div class="welcome_message"><?=l(113);?>, <?=p_login();?></div>
<div class="user_panel_buttons">
	<a href='<?=u("user/");?>'>
		<button id="upb_accountsettings" class="user_panel_buttons_row">
			<div class="user_panel_buttons_icon"></div><?=l(114);?>
		</button>
	</a>
	<a href='<?=u("user/vote/");?>'>
		<button id="upb_vote" class="user_panel_buttons_row">
			<div class="user_panel_buttons_icon"></div><?=l(116);?>
		</button>
	</a>
	<a href='<?=u("user/unblock");?>'>
		<button id="upb_accountsettings" style="text-transform: uppercase;" class="user_panel_buttons_row">
			<div class="user_panel_buttons_icon"></div><?=l(148);?>
		</button>
	</a>
	<a href='<?=u("user/referidos/");?>'>
		<button style="text-transform: uppercase;" class="user_panel_buttons_row">
			<div style="height: auto;" class="user_panel_buttons_icon fa fa-users"></div><?=l(264);?>
		</button>
	</a>
</div>
<div id="logout_button">
	<a href="<?=u('logout');?>"><button id="logout_button_text"><?=l(117);?></button></a>
</div>
<?php }else{ ?>
<?php if($check_status_login){ ?>
				<div class="notification notification_red noselect">
					<div class="notification_inner_topbar"></div>
					<div class="notification_line">
						<div class="notification_icon"></div>
						<div class="notification_text"><?=$check_msg;?></div>
					</div>
				</div>
<?php } ?>
				<div class="board_title_leftalign"><?=l(26);?></div>
				<form action="" method="POST">
					<input type="hidden" name="action" value="login">
					<div class="input_title"><?=l(27);?></div>
					<input class="login_input_box" type="text" name="userid" required>
					<div class="input_title"><?=l(28);?></div>
					<input class="login_input_box" type="password" name="userpass" required>
					<div id="remember_me">
						<label class="switch">
							<input type="checkbox" name="remember_me">
							<div class="remember_toggle"></div>
							<div class="input_title" id="remember_text"><?=l(3);?></div>
						</label>
					</div>
					<div id="signin_button">
						<button id="signin_button_text" type="submit" name="submit_login" value="<?=l(26);?>"><?=l(26);?></button>
					</div>
				</form>
				<div id="register" class="small_link_text"><a href='<?=u('register/');?>'><?=l(2);?></a></div>
				<div id="forgot_pw" class="small_link_text"><a href='<?=u('forgotpwd/');?>'><?=l(29);?></a></div>
<?php } ?>
				<div id="ingame_statistics">
					<div id="player_count">
						<div id="player_count_value">
							<?=$stat_3;?>
						</div>
					</div>
						<div id="player_count_title"><?=l(4);?></div>
						<div id="shops_explanation">(<?=l(5);?>)</div>
						<div id="player_count_additional_stats">
						<div>
								<div class="player_count_additional_stats_value"><?=$stat_5;?></div>
								<div class="player_count_additional_stats_title"><?=l(244);?></div>
						</div>
							<div>
								<div class="player_count_additional_stats_value"><?=$stat_4;?></div>
								<div class="player_count_additional_stats_title"><?=l(6);?></div>
						</div>
						<div>
							<div class="player_count_additional_stats_value"><?=$stat_2;?></div>
							<div class="player_count_additional_stats_title"><?=l(7);?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="footer">
			<div id="footer_navigator_items_list" class="noselect">
				<div class="footer_navigator_item"><a href="<?=s('url_support')?>"><?=l(14);?></a></div>
				<div class="footer_navigator_item"><a href='<?=u('tos/')?>'><?=l(183);?></a></div>
				<div class="footer_navigator_item"><a href='<?=u('privacy/')?>'><?=l(184)?></a></div>
				<div class="footer_navigator_item"><a href='<?=u('dmca/')?>'><?=l(185)?></a></div>
			</div>
			<div id="footer_other_infos">
				<p><?=s("footer_copy");?> | Codeada por <a href="https://metin2zone.net/index.php?/profile/33277-r1z/" target="_blank">R1z</a> | Resources by <a>WoM2</a></p><div><a style="font-size:1px;" href="https://www.metin2pserver.info" title="Metin2 PServer">Metin2 PServer</a></div>
				<p><?=l('footer');?></p>
			</div>
			<div id="social_networks">
				<?php if(s("url_discord")){ ?><a href="<?=s("url_discord");?>" target="_blank"><button id="discord"></button></a><?php } ?>
				<?php if(s("url_fb")){ ?><a href="<?=s("url_fb");?>" target="_blank"><button id="facebook"></button></a><?php } ?>
				<?php if(s("url_yt")){ ?><a href="<?=s("url_yt");?>" target="_blank"><button id="youtube"></button></a><?php } ?>
				<?php if(s("url_epvp")){ ?><a href="<?=s("url_epvp");?>" target="_blank"><button id="epvp"></button></a><?php } ?>
			</div>
		</div>
		<script type="text/javascript" src="<?=u('app/design/js/wSelect.min.js');?>"></script>
		<script type="text/javascript"> var country = "<?=strtolower($_SERVER["HTTP_CF_IPCOUNTRY"]);?>"; </script>
		<script type="text/javascript"> var player = "<?=$_SESSION["player_login"]?>"; </script>
		<script src="<?=u('app/design/js/website.js');?>"></script>
		<script src="<?=u('app/design/plugins/stepwizard/js/stepwizard.js');?>"></script>
		<script src="//google.com/recaptcha/api.js" async defer></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>
		<script src="https://use.fontawesome.com/669f7f0f07.js"></script>
		<script>
			$(document).ready(function(){
				$('#wizard').steps({
					enableAllSteps: false
				});
			});
		</script>
	</body>
</html>

