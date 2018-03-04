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
	<div class="main_board_darker_background">
		<div class="main_board_subtitle_centeralign"> <?=l(148);?> </div>
		<div id="progress_bar" class="progress_bar_stage3"></div>
		<div id="register_stage3_information">
			<div class="main_board_regular_text"> <?=l(248);?>
			<br><br>
			<span style="color: #ffca2a"><?=l(249);?></span></div>
		</div>
		<table id="full_ranking_table">
		<tr class="full_ranking_table_titles_row">
			<td class="full_ranking_table_title_position">#</td>
			<td class="full_ranking_table_title_name"><?=l(52);?></td>
			<td class="full_ranking_table_title_kingdom"><?=l(53);?></td>
			<td class="full_ranking_table_title_points"><?=l(54);?></td>
		</tr>
		<?php   $player_account = mysqli_query(server_player(),"SELECT player.id, player.name, player.level, player_index.empire FROM player LEFT JOIN player_index ON player_index.id=player.account_id WHERE account_id = '".p_id()."';");
				$i = 0;
				while($player = mysqli_fetch_object($player_account)) {
		?>
			<tr class="full_ranking_table_row">
				<td id="p<?=$i;?>" class="full_ranking_rank <?=($i>5)?"":"top_rank";?>"><?=($i>5)?$i:"";?></td>
				<td class="full_ranking_playername"><a href="<?=u("user/unblock/".cc($player->id)."/");?>"><?=$player->name;?></a></td>
				<td class="full_ranking_<?=$player->empire?>_kingdom"></td>
				<td class="full_ranking_points"><?=$player->level?></td>
			</tr>
<?php $i++; } ?>
	</table>
	</div>
</div>
