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
	<div class="board_title_centeralign"><?=l(201);?></div>
	<div class="main_board_darker_background">
		<form action="" method="POST">
			<input type="hidden" name="action" value="do">
			<div id="forgot_password_form">
				<div class="forgot_password_input_title"><?=l(27);?></div>
				<input class="forgot_password_input_box" type="text" name="user_name" required>
				<div class="forgot_password_input_title"><?=l(87);?></div>
				<input class="forgot_password_input_box" type="email" name="user_email" required>
			</div>
			<center><div class="g-recaptcha" data-sitekey="<?=s('g_recaptcha');?>"></div></center>
			<div id="reset_button">
				<button id="reset_button_text" type="submit" name="user_send" value="<?=l(202);?>"><?=l(202);?></button>
			</div>
		</form>
	</div>
</div>
