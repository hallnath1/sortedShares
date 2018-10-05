<?php
session_start();
if(!isset($_SESSION['id'])){
	header('Location: login.php');
}
require 'database.php';
$db = new Database();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" name="viewport" content="width=device-width">
	<title>Sorted Shares</title>
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
	<link rel="stylesheet" href="style.css" type="text/css" charset="utf-8">
	<script src='js/jquery-3.3.1.min.js'></script>
	<script src='js/newPaymentGroup.js'></script>
</head>
<?php echo "<body style='background:linear-gradient(to bottom right, ".$_SESSION['color'].")'>";?>
	<div class="screen" style="overflow: scroll;">
		<?php
		include 'menu_top.php';
		include 'menu_bar.php';
		?>
		<div class="topTitle">
			<h1 style="display:inline-block; margin:1% 1%;">Link your PayPal.Me</h1>
			<div class="tooltip" style="height:100%;display:inline-block;float:right;">
				<a href='index.php'>
					<img src = "icons/exit(black).png"style="height:60px;width:auto;">
				</a>
				<span class="tooltiptext">Exit</span>
			</div>
		</div>
		<div class="content">

			<form class="loginRegister" action="paypalLinkProcessing.php" method="POST">
                <h2>This will allow friends to pay you using PayPal </h2>
				<label>PayPal.Me Link</label>
                <input type="text" name="link" value="https://www.paypal.me/">
                <input type="submit" class="button" name="submit" value="Submit">
			</form>
			
				


		</div>
	</div>
</body>
</html>