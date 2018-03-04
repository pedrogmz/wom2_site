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
	<div class="board_title_centeralign"><?=l(235);?></div>
	<div class="main_board_darker_background">
		<div id="register_stage3_information">
			<div class="main_board_regular_text"> <?=l(236);?>
			<br><br>
			<span style="color: #ffca2a"><?=l(237)." ".s('smtp_email');?>.</span></div>
		</div>
		<form action="" method="POST">
			<br>
			<div id="sentry_code">
				<div id="sentry_code_title"> <?=l(219);?> </div>
				<input id="sentry_code_input_box" type="text" maxlength="6" size="6" name="code">
			</div>
			<div class="sentry_button_container">
				<button id="activate_button" name="send_inf" value="<?=l(234);?>" type="submit"><?=l(234);?></button>
			</div>
		</form>
	</div>
</div>

