<div id="main_board">
<?PHP if($check_status){ ?>
	<div class="notification notification_<?=$check_type;?> noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text"><?=$check_msg;?></div>
		</div>
	</div>
<?PHP } ?>
<?PHP if($check_status_thow){ ?>
	<div class="notification notification_<?=$check_type_two;?> noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text"><?=$check_msg_two;?></div>
		</div>
	</div>
<?PHP } ?>
	<div class="board_title_centeralign"><?=l(114);?></div>
	<div class="account_settings_main_board_darker_background">
		<form action="<?=u("user/");?>" method="POST">
			<div class="main_board_subtitle_centeralign"><?=l(192);?></div>
			<table id="account_details">
				<tr class="account_details_row">
					<td class="account_details_category"><?=l(27);?></td>
					<td class="account_details_value"> <?=p_login();?> </td>
				</tr>
				<tr class="account_details_row">
					<td class="account_details_category"><?=l(87);?></td>
					<td class="account_details_value"> <?=p_email();?> </td>
				</tr>
<?PHP if(p_status() != "OK"){ ?>
				<tr class="account_details_row">
					<td colspan="100%" class="account_details_value">
						<div class="warning_email_icon"></div>
						<div class="warning_email_message"><?=l(193);?> <a href="<?=u('user/verify/');?>"><?=l(194);?></a></a></div>
					</td>
				</tr>
<?PHP } ?>
<?PHP if(p_temp() != "OFF"){ ?>
				<tr class="account_details_row">
					<td class="account_details_category"><?=l(134);?></td>
					<td class="account_details_value"> <?=p_r1z_email();?> </td>
				</tr>
				<tr class="account_details_row">
					<td colspan="100%" class="account_details_value">
						<div class="warning_email_icon"></div>
						<div class="warning_email_message"><?=l(48);?></a></a></div>
					</td>
				</tr>
<?PHP } ?>
				<tr class="account_details_row">
					<td class="account_details_category">
						<?=l(195);?>
					</td>
					<td class="account_details_value">
						<input class="account_details_input_box" type="text" name="new_email">
					</td>
				</tr>
				<tr class="account_details_row">
					<td class="account_details_category"><?=l(196);?></td>
					<td class="account_details_value"> <?=p_time();?> </td>
				</tr>
			</table>
			<table id="account_details_password_change">
				<tr class="account_details_row_title">
					<td colspan="100%"><?=l(152);?></td>
				</tr>
				<tr class="account_details_row">
					<td class="account_details_category"><?=l(118);?></td>
					<td class="account_details_value">
						<input class="account_details_input_box" type="password" name="cur_pwd">
					</td>
				</tr>
				<tr class="account_details_row">
					<td class="account_details_category"><?=l(119);?></td>
					<td class="account_details_value">
						<input class="account_details_input_box" type="password" name="new_pwd">
					</td>
				</tr>
				<tr class="account_details_row">
					<td class="account_details_category"><?=l(120);?></td>
					<td class="account_details_value">
						<input class="account_details_input_box" type="password" name="new_pwd_confirm">
					</td>
				</tr>
			</table>
			<table id="account_details_character_delete">
				<tr class="account_details_row_title">
					<td colspan="100%"><?=l(78);?></td>
				</tr>
				<tr class="account_details_row_regular_text">
					<td colspan="100%">
						<?=l(197);?> <a href="<?=u('user/remove/');?>"><?=l(198);?></a>
					
					</td>
				</tr>
			</table>
			<table id="account_details_storage_password">
				<tr class="account_details_row_title">
					<td colspan="100%"><?=l(89);?></td>
				</tr>
				<tr class="account_details_row_regular_text">
					<td colspan="100%">
						<?=l(199);?> <a href="<?=u('user/storage/');?>"><?=l(200);?></a>
					</td>
				</tr>
			</table>
			<div id="save_button">
				<button id="save_button_text" type="submit" name="usersubm" value="<?=l(90);?>"><?=l(90);?></button>
			</div>
		</form>
	</div>
</div>
