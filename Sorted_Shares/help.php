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
	<script src='js/index.js'></script>
</head>
<?php echo "<body style='background:linear-gradient(to bottom right, ".$_SESSION['color'].")'>";?>

	<div class="screen" style="overflow: scroll;">
		<?php
		include 'menu_top.php';
		include 'menu_bar.php';
		?>
		<div class="topTitle">
			<h1 style="display:inline-block; margin:1% 1%;">Help</h1>
		
            <div class="tooltip" style="height:100%;display:inline-block;float:right;">
				<a href='index.php'>
					<img src = "icons/exit(black).png"style="height:60px;width:auto;">
				</a>
				<span class="tooltiptext">Exit</span>
			</div>
            
            <table style="margin:auto; text-align:left; padding-top:2vw;">
  <tr>
    <td><img src = "icons/addPeople(black).png" style="height:60px;width:auto;"></td>
    <td>Add a new Person</td>
  </tr>
  <tr>
    <td><img src = "icons/bill(black).png"style="height:60px;width:auto;margin-right:3vw;"></td>
    <td>Create a new payment</td>
  </tr>
  <tr>
    <td><img src = "icons/money(black).png"style="height:60px;width:auto;margin:auto;"></td>
    <td>Make a Payment</td>
  </tr>
  <tr>
    <td><img src = "icons/expandM(black).png"style="height:60px;width:auto;"></td>
    <td>Expand</td>
  </tr>
  <tr>
    <td><img src = "icons/expandL(black).png"style="height:60px;width:auto;"></td>
    <td>Reduce</td>
  </tr>
  <tr>
    <td><img src = "icons/exit(black).png"style="height:60px;width:auto;"></td>
    <td>Exit/Leave</td>
  </tr>
  <tr>
    <td><img src = "icons/alert(black).png"style="height:60px;width:auto;"></td>
    <td>Send an alert</td>
  </tr>
  <tr>
    <td><img src = "icons/send(black).png"style="height:60px;width:auto;"></td>
    <td>Send Message</td>
  </tr>
  <tr>
    <td><img src = "icons/remove(white).png"style="height:60px;width:auto;"></td>
    <td>Clear Alerts</td>
  </tr>
  <tr>
    <td><img src = "icons/paypal.png"style="height:60px;width:auto;"></td>
    <td>PayPal is linked</td>
  </tr>
</table>
			
		</div>
		
		<div class="content">
			
	   </div>
</div>

</body>
</html>
