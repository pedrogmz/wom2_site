
<div id="main_board">
	<div class="board_title_centeralign"><?=l(185);?></div>
	<div class="tos_dmca_pp_shrinked_board">
<?PHP for($h = 1; $h <= count($dmca_info); $h++){ $tt = $dmca_info[$h]['tt']; $class = ($tt == 2)?'main_board_subtitle_centeralign':(($tt == 3)?'main_board_subtitle':'main_board_regular_text'); ?>
<p class="<?=$class;?>"><?=nl2br(cc($dmca_info[$h]['t_'.dfl()],1));?></p>
<?PHP } ?>
	</div>
</div>
