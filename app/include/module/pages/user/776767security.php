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
	<div class="board_title_centeralign"><?=l(128);?></div>
	<div class="main_board_darker_background">
		<div class="main_board_subtitle_centeralign"> <?=l(215);?> </div>
		<div id="progress_bar" class="progress_bar_stage3"></div>
		<div id="register_stage3_information">
			<div class="main_board_regular_text"> <?=l(216);?>
			<br><br>
			<span style="color: #ffca2a"><?=l(217);?></span></div>
		</div>
		<form action="" method="POST">
			<input type="hidden" name="activate" value="<?=$permit;?>">
<?PHP if(p_secure_code()){ ?>
			<br>
			<div id="sentry_code">
				<div id="sentry_code_title"> <?=l(219);?> </div>
				<input id="sentry_code_input_box" type="text" maxlength="6" size="6" name="code">
			</div>
<?PHP } ?>
			<div class="sentry_button_container">
<?PHP if(!p_secure()){ ?>
				<button id="activate_button" name="send_inf" value="<?=l(218);?>" type="submit"><?=l(218);?></button>
<?PHP }else{ ?>
				<button id="deactivate_button" name="send_inf" value="<?=l(229);?>" type="submit"><?=l(229);?></button>
<?PHP } ?>
			</div>
		</form>
	</div>
</div>
