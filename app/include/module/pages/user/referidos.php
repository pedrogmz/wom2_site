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
	<div class="main_board_darker_background">
		<div class="main_board_subtitle_centeralign"> <?=l(264);?> </div>
		<div id="progress_bar" class="progress_bar_stage3"></div>
		<div id="register_stage3_information">
			<div class="main_board_regular_text"><?=l(265);?>
				<br><br>
				<span style="color: #ffca2a"><?=l(266);?></span>
				<br><br>
				<input style="width: 100%;" class="account_details_input_box" type="text" value="<?=u('')?>ref/<?=cc(p_id())?>" disabled>
			</div>
		</div>
		<table id="full_ranking_table tabla_referidos">
			<thead>
				<tr class="full_ranking_table_titles_row">
					<th class="full_ranking_table_title_position">#</th>
					<th class="full_ranking_table_title_name"><?=l(52);?></th>
					<th class="full_ranking_table_title_name"><?=l(267);?></th>
					<th class="full_ranking_table_title_name"><?=l(268);?></th>
				</tr>
			</thead>
			<tbody>
		<?php
			$referidos = mysqli_query(server_account(),"SELECT * FROM aff_users WHERE aff = '".p_id()."' ORDER by id ASC;");
			$i = 0;
			while($referido = mysqli_fetch_object($referidos)) {
		?>
			<tr class="full_ranking_table_row">
				<td id="p<?=$i;?>" class="full_ranking_rank <?=($i>5)?"":"top_rank";?>"><?=($i>5)?$i:"";?></td>
				<td class="full_ranking_playername"><?=player_real_name($referido->player);?></td>
				<td class="full_ranking_playername"><?=date("H:i, d/m/Y", strtotime($referido->reg_dat));?></td>
				<td class="full_ranking_playername"><?=$referido->status == "WAIT" ? l(269) : l(270);?></td>
			</tr>
<?php $i++; } ?>
			</tbody>
		</table>
	</div>
</div>