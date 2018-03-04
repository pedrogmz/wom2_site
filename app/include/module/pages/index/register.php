<div id="main_board">
<?PHP if($check_status){ ?>
	<div class="notification notification_red noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text"><?=$check_msg;?></div>
		</div>
	</div>
<?PHP } ?>
	<div class="board_title_centeralign"><?=l(75);?></div>
	<div class="main_board_darker_background">
		<div class="main_board_subtitle_centeralign"><?=l(77);?></div>
		<div id="progress_bar" class="progress_bar_stage1"></div>
		<form id="register_form" action="" method="POST">
			<div class="register_input_title"><?=l(27);?></div>
			<input class="register_input_box" type="text" name="login" required>
			<div class="register_input_title"><?=l(28);?></div>
			<input class="register_input_box" type="password" name="password" required>
			<div class="register_input_title"><?=l(87);?></div>
			<input class="register_input_box" type="email" name="email" required>
			<div id="deletion_code">
				<div id="deletion_code_input_title"><?=l(78);?></div>
				<input id="deletion_code_input_box" type="text" maxlength="7" size="7" placeholder="1234567" name="chardeletecode" required>
			</div>
			<div class="register_agreements">
				<label class="register_agreement_switch">
					<input type="checkbox" name="tyc" required>
					<div class="register_agreement_toggle"></div>
					<div class="register_agreement_input_title"><?=l(88);?></div>
				</label>
				<label class="register_agreement_switch">
					<input type="checkbox" name="mailoptin">
					<div class="register_agreement_toggle"></div>
					<div class="register_agreement_input_title"><?=l(91);?></div>
				</label>
			</div>
			<div class="g-recaptcha" data-sitekey="<?=s('g_recaptcha');?>"></div>
			<div id="register_button">
				<button id="register_button_text" name="user_send" value="<?=l(76);?>" type="submit"><?=l(76);?></button>
			</div>
		</form>
	</div>
</div>
