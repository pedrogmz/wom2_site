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
<?PHP if($check_status_thow){ ?>
	<div class="notification notification_<?=$check_type_two;?> noselect">
		<div class="notification_inner_topbar"></div>
		<div class="notification_line">
			<div class="notification_icon"></div>
			<div class="notification_text"><?=$check_msg_two;?></div>
		</div>
	</div>
<?PHP } ?>
	<div class="board_title_centeralign">Comprar Coins</div>
	<div class="main_board_darker_background">
		<div class="main_board_subtitle_centeralign">Usando e-Payouts</div>
		<div id="wizard">
			<h1><div class="main_board_subtitle_centeralign"> Metodo de pago </div></h1>
			<div class="step-content">
				<div id="progress_bar" class="progress_bar_stage1"></div>
				<div class="main_board_regular_text" id="first_step">
					<h2>Selecciona el metodo con el cual deseas pagar</h2>
					<p id="payment_methods"><?=getPaymentMethodsByCountry($_SERVER["HTTP_CF_IPCOUNTRY"])?></p>
				</div>
			</div>
		
			<h1><div class="main_board_subtitle_centeralign"> Monto </div></h1>
			<div class="step-content">
				<div id="progress_bar" class="progress_bar_stage2"></div>
				<div class="main_board_regular_text" id="second_step">
				<h2>Elige el monto de coins a recibir</h2>
					<p class="select_price"></p>
				</div>
			</div>

			<h1><div class="main_board_subtitle_centeralign"> Completar pago </div></h1>
			<div class="step-content">
				<div id="progress_bar" class="progress_bar_stage3"></div>
				<div class="main_board_regular_text">
					<h2>Completa tu pago con e-Payouts</h2>
					<p class="epay_content"></p>
				</div>
			</div>
		</div>
	</div>

	<div class="main_board_darker_background">
			<?php
				//Paypal - START
				if(isset($_POST["pay_paypal"]))
				{
					if($_POST["type"] == '5') {
						$coins = '500';
					} elseif($_POST["type"] == '10') {
						$coins = '1100';
					} elseif($_POST["type"] == '15') {
						$coins = '1650';
					} elseif($_POST["type"] == '20') {
						$coins = '2200';
					} elseif($_POST["type"] == '50') {
						$coins = '6000';
					}
					$price = $_POST["type"];
					$return_url = 'https://www.metin2fenix.com/user/buycoins';
					$cancel_url = 'https://www.metin2fenix.com/user/buycoins';
					$notify_url = 'http://billing.btmt2.com/zRuzkSqcXfi.php';

					$item_name = 'Server: Metin2Fenix - '.$coins.' coins - Account: '.$_SESSION["player_login"];
					$item_amount = $price;
					$querystring = '';

					// Firstly Append paypal account to querystring
					$querystring .= "?business=".urlencode('billing@cerclexarxes.com')."&";

					// Append amount& currency (£) to quersytring so it cannot be edited in html

					//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
					$querystring .= "item_name=".urlencode($item_name)."&";
					$querystring .= "amount=".urlencode($item_amount)."&";

					//loop for posted values and append to querystring
					foreach($_POST as $key => $value){
						$value = urlencode(stripslashes($value));
						$querystring .= "$key=$value&";
					}

					// Append paypal return addresses
					$querystring .= "return=".urlencode(stripslashes($return_url))."&";
					$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
					$querystring .= "notify_url=".urlencode($notify_url);

					// Append querystring with custom field
					$querystring .= "&custom=".$_SESSION["player_login"];

					// Redirect to paypal IPN
					$destination = 'https://www.paypal.com/cgi-bin/webscr'.$querystring;
					echo '<meta http-equiv="refresh" content="0; url='.$destination.'">';
					exit();
				}
				//Paypal - END
			?>

		<form id="register_form" action="https://www.metin2fenix.com/user/buycoins" method="POST">
			<div class="main_board_subtitle_centeralign">Seleccionar cantidad de Coins</div>
			<select id="ranking_category_select_dropdown" style="margin-left: 41px;width:188px" name="type">
				<option value="5">500 Coins - 5 EUR</option>
				<option value="10">1100 Coins - 10 EUR</option>
				<option value="15">1650 Coins - 15 EUR</option>
				<option value="20">2200 Coins - 20 EUR</option>
				<option value="50">6000 Coins - 50 EUR</option>
			</select>
			<input type="hidden" name="cmd" value="_xclick" />
			<input type="hidden" name="no_shipping" value="1" />
			<input type="hidden" name="no_note" value="1" />
			<input type="hidden" name="rm" value="2" />
			<input type="hidden" name="currency_code" value="EUR" />
			<div id="register_button">
				<button id="activate_button" type="submit" name="pay_paypal">Pagar con PayPal</button>
			</div>
		</form>
	</div>
</div>