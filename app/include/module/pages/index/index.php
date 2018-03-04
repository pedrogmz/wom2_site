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
<div style="margin:0 auto;text-align:center">
<a href="https://www.metin2fenix.com/img/Metin2Fenix_presentacion_es.png"><img src="https://www.metin2fenix.com/img/Sin-título-2_01.gif"/></a>
<a href="https://www.metin2fenix.com/img/Metin2Fenix_presentacion_en.png"><img style="margin-left: -4px;" src="https://www.metin2fenix.com/img/Sin-título-2_02.png"/></a>
</div>
	
	<!-- <script type="text/javascript">
		$(function() {
			$(".posts_navigation_item").on("click", function() {
				var pthis = $(this);
				$(".pn_selected").toggleClass("pn_selected", false).toggleClass("pn_unselected", true)
				pthis.toggleClass("pn_unselected", false).toggleClass("pn_selected", true);
					$(".post").toggleClass("fade_out", true);
				setTimeout(function() {
					$(".post").toggleClass("hidden", true).toggleClass("fade_out", false);
					$(".post[data-page="+pthis.data("page")+"]").toggleClass('hidden', false).toggleClass("fade_in", true);
				}.bind(this), 350);
			})
			$("#first_page").trigger('click');
		})
	</script> -->
</div>
