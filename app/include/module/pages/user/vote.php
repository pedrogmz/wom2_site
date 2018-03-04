
<div id="main_board">
<?php if($check_status){ ?>
	<div class="notification notification_<?=$check_type;?> noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text"><?=$check_msg;?></div>
		</div>
	</div>
<?php } ?>
	<div class="board_title_centeralign"><?=l(39);?></div>
	<div class="main_board_darker_background">
		<div class="main_board_subtitle"><?=l(38);?></div>
		<div class="vote_for_coins_row">
		<?php
			$vote = new Vote();
			$vote->vote_forms();
		?>
		</div>
	</div>
</div>
<script type="text/javascript">
	function votepopup(url) {
		$(".vote_button").attr('id', 'support_red');
		$("#form").attr("onsubmit","");
		fenster = window.open(url, "Vote4Coins", "width=1150,height=750,status=yes,scrollbars=yes,resizable=yes");
		fenster.focus();
	}
</script>