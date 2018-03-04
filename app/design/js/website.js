	/***********************************
 	////////////////////////////////////////////////////////////////////////////////////
	// Code by R1z			email: r1z@usa.com		Pagina Web: https://r1z.org		  //
	// Perfil Zone: https://metin2zone.net/index.php?/profile/33277-r1z/			  //
	////////////////////////////////////////////////////////////////////////////////////
													***********************************/

window.onresize=function(event){$(window).scrollLeft(0);var fixedNavigationTop=$("#fixed_navigation_top");var container=$("#container");fixedNavigationTop.removeClass("fixed_bar");container.removeClass("container_after_fixed");};$(window).scroll(function(){var fixedNavigationTop=$("#fixed_navigation_top");var container=$("#container");var currentScroll=$(window).scrollTop();if($(window).width()>1200){if(currentScroll>=327){fixedNavigationTop.addClass("fixed_bar");container.addClass("container_after_fixed");}
else{fixedNavigationTop.removeClass("fixed_bar");container.removeClass("container_after_fixed");}}});function dismissNotification(){let $notification=$(this);$notification.toggleClass("fade_slide_out",true);setTimeout(function(){$notification.toggleClass("hidden",true).toggleClass("fade_slide_out",false);},380);}function moveRanking(animClass){var $other=$(".hidden[data-rtype]");var $rselected=$("#ranking_category_selected");var myRtype=$rselected.data("rtype");var myName=$rselected.html();$rselected.html($other.html()).data("rtype",$other.data("rtype"));$other.html(myName).data("rtype",myRtype);var $rtable=$("#ranking_table");var $hiddenTable=$(".hidden[data-ranking]");var origContent=$rtable.html();$rtable.find("td:not(.ranking_icon)").toggleClass("fade_out",true);setTimeout(function(){$rtable.find("td:not(.ranking_icon)").toggleClass("fade_out",false);$rtable.html($hiddenTable.html());$rtable.find("td:not(.ranking_icon)").toggleClass(animClass);setTimeout(function(){$rtable.find("td:not(.ranking_icon)").removeClass(animClass);},450);$hiddenTable.html(origContent);}.bind(this),350);}$(function(){$(".notification").on("click",dismissNotification);$("#right_arrow_ranking").on("click",function(){moveRanking("fade_lefttoright_in");});$("#left_arrow_ranking").on("click",function(){moveRanking("fade_righttoleft_in");});$("#server_select").on("change",function(){var val=$(this).val();window.location.href=urll+val+urlt;});});
$('#server_select').wSelect();
var nextStep = function (element) {
	$('[name*="method"]').removeClass('selected');
	$(element).attr('class', 'selected');
	$.get("https://www.metin2fenix.com/epay.php", { cc: country }, function (data) {
		if ($(element).val() == "sms") {
			var price_sms = data.data.modules.methods.sms[0].price;
			var currency = data.data.modules.methods.sms[0].lcurrency;
			$('#second_step').find('.select_price').html('<input type="radio" name="price" id="rb0" value="' + price_sms + '" /><label for="rb0">' + price_sms + ' ' + currency + '</label>');
		} else {
			$('#second_step').find('.select_price').html('<input type="radio" name="price" id="rb1" value="5.00" /><label for="rb1">500 coins - 5.00 EUR</label><input type="radio" name="price" id="rb2" value="10.00" /><label for="rb2">1100 coins - 10.00 EUR</label><input type="radio" name="price" id="rb3" value="15.00" /><label for="rb3">1650 coins - 15.00 EUR</label><input type="radio" name="price" id="rb4" value="20.00" /><label for="rb4">2200 coins - 20.00 EUR</label><input type="radio" name="price" id="rb5" value="50.00" /><label for="rb5">6000 coins - 50.00 EUR</label>');
		}
	});
	$("#wizard").steps("next");
}

$("body").on("change", '.select_price input[name*="price"]', function (event) {
	var price = $(this).val();
	var method = $('#first_step').find('[name*="method"].selected').val();
	$('.epay_content').html('<button href="javascript:;" data-fancybox="iframe" data-src="//paymentbox.e-payouts.com?uid=94&mid=230&ucode='+player+'&price=' + price + '&pm=' + method + '" data-type="iframe" id="activate_button">PAGAR</button>');
	$("#wizard").steps("next");
});