<div id="main_board_larger">
	<div class="board_title_centeralign"><?=l(182);?></div>
	<div id="ranking_page_board_header">
		<div class="current_ranking_page_subtitle">
			<?=l(19);?>
			<select id="ranking_category_select_dropdown">
				<option value="players"><?=l(10);?></option>
				<option value="guilds" <?=(GPage(2)=="guilds")?"selected":""?>><?=l(11);?></option>
			</select>
		</div>
	</div>
	<div class="main_board_regular_text"><?=l(21);?></div>
<?PHP if(GPage(2)=="guilds"){ ?>
	<form action="" method="POST">
		<div class="player_name_search_input_title"><?=l(22);?></div>
		<div class="player_name_search">
			<input type="hidden" name="type" value="player">
			<input class="player_name_search_input_box" type="text" name="search" value="<?=$p_name;?>">
			<button id="player_search_button"></button>
		</div>
	</form>
	<div class="full_ranking_navigation">
<?PHP $start_count = 0; while($start_count < $max){ $page = ($start_count == 0) ? "" : "$start_count/"; $type = ($start == $start_count)?"frn_selected":"frn_unselected"; ?>
		<div class="full_ranking_navigation_item_wrap"><a href="<?=u("ranking/guilds/$page#main_board_larger");?>"><button class="full_ranking_navigation_item <?=$type;?>"></button></a></div>
<?PHP $start_count += 10; } ?>	
	</div>
	<table id="full_ranking_table">
		<tr class="full_ranking_table_titles_row">
			<td class="full_ranking_table_title_position">#</td>
			<td class="full_ranking_table_title_name"><?=l(52);?></td>
			<td class="full_ranking_table_title_kingdom"><?=l(53);?></td>
			<td class="full_ranking_table_title_points"><?=l(57);?></td>
		</tr>
<?PHP for($i = $start + 1; $i <= $stop; $i++){ ?>
		<tr class="full_ranking_table_row <?=($i == GPage(4))?"highlighted_playername":"";?>">
			<td id="p<?=$i;?>" class="full_ranking_rank <?=($i>5)?"":"top_rank";?>"><?=($i>5)?$i:"";?></td>
			<td class="full_ranking_playername"><?=$guilds[$i][0];?></td>
			<td class="full_ranking_<?=$guilds[$i][1]?>_kingdom"></td>
			<td class="full_ranking_points"><?=$guilds[$i][2]?></td>
		</tr>
<?PHP } ?>
	</table>
	<div class="full_ranking_navigation">
<?PHP $start_count = 0; while($start_count < $max){ $page = ($start_count == 0) ? "" : "$start_count/"; $type = ($start == $start_count)?"frn_selected":"frn_unselected"; ?>
		<div class="full_ranking_navigation_item_wrap"><a href="<?=u("ranking/guilds/$page#main_board_larger");?>"><button class="full_ranking_navigation_item <?=$type;?>"></button></a></div>
<?PHP $start_count += 10;} ?>	
	</div>
<?PHP }else{ ?>
	<form action="" method="POST">
		<div class="player_name_search_input_title"><?=l(20);?></div>
		<div class="player_name_search">
			<input type="hidden" name="type" value="player">
			<input class="player_name_search_input_box" type="text" name="search" value="<?=$p_name;?>">
			<button id="player_search_button"></button>
		</div>
	</form>
	<div class="full_ranking_navigation">
<?PHP $start_count = 0; while($start_count < $max){ $page = ($start_count == 0) ? "" : "$start_count/"; $type = ($start == $start_count)?"frn_selected":"frn_unselected"; ?>
		<div class="full_ranking_navigation_item_wrap"><a href="<?=u("ranking/players/$page#main_board_larger");?>"><button class="full_ranking_navigation_item <?=$type;?>"></button></a></div>
<?PHP $start_count += 10; } ?>	
	</div>
	<table id="full_ranking_table">
		<tr class="full_ranking_table_titles_row">
			<td class="full_ranking_table_title_position">#</td>
			<td class="full_ranking_table_title_name"><?=l(52);?></td>
			<td class="full_ranking_table_title_class"><?=l(55);?></td>
			<td class="full_ranking_table_title_kingdom"><?=l(53);?></td>
			<td class="full_ranking_table_title_points"><?=l(54);?></td>
		</tr>
<?PHP for($i = $start + 1; $i <= $stop; $i++){ ?>
		<tr class="full_ranking_table_row <?=($i == GPage(4))?"highlighted_playername":"";?>">
			<td id="p<?=$i;?>" class="full_ranking_rank <?=($i>5)?"":"top_rank";?>"><?=($i>5)?$i:"";?></td>
			<td class="full_ranking_playername"><?=$players[$i][0];?></td>
			<td class="full_ranking_class"><?=player_race($players[$i][3]);?></td>
			<td class="full_ranking_<?=$players[$i][1]?>_kingdom"></td>
			<td class="full_ranking_points"><?=$players[$i][2]?></td>
		</tr>
<?PHP } ?>
	</table>
	<div class="full_ranking_navigation">
<?PHP $start_count = 0; while($start_count < $max){ $page = ($start_count == 0) ? "" : "$start_count/"; $type = ($start == $start_count)?"frn_selected":"frn_unselected"; ?>
		<div class="full_ranking_navigation_item_wrap"><a href="<?=u("ranking/players/$page#main_board_larger");?>"><button class="full_ranking_navigation_item <?=$type;?>"></button></a></div>
<?PHP $start_count += 10;} ?>	
	</div>
<?PHP } ?>
	<script type="text/javascript">
		$("#ranking_category_select_dropdown").on("change", function() {
			window.location = "<?=u('ranking/');?>" + $(this).val() + "/";
		});
	</script>
</div>