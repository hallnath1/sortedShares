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
	<script src='js/paymentOptions.js'></script>
</head>
<?php echo "<body style='background:linear-gradient(to bottom right, ".$_SESSION['color'].")'>";?>

	<div class="screen" style="overflow: scroll;">
		<?php
		include 'menu_top.php';
		include 'menu_bar.php';
		?>
		<div class="topTitle">
			<h1 style="display:inline-block; margin:1% 1%;">Payment Methods</h1>
			<div class="tooltip" style="height:100%;display:inline-block;float:right;">
				<a href='index.php'>
					<img src = "icons/exit(black).png"style="height:60px;width:auto;">
				</a>
				<span class="tooltiptext">Exit</span>
			</div>
		</div>
		
		<div class="content" style='text-align:center;vertical-align::middle;'>
		
            <?php 
            
            $id = $_SESSION['id'];
            $getID = $_GET['id'];
            $amount = $_GET['amount'];
            
            $sql = "SELECT paypalLink FROM Users WHERE UserID = :id;";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $getID, SQLITE3_INTEGER);
            $link = $stmt->execute()->fetchArray();
            
            if ($link['paypalLink'] != null){
            echo "<a class='paypalOption' id1=".$getID."' id2=".$link['paypalLink']." id3=".$amount." href='https://www.paypal.me/".$link['paypalLink']."/".($amount/100)."gbp' target='_blank'><img src='https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_200x51.png' alt='PayPal' /></a>
        <br><br><h3>OR</h3><br>";
            
            }
            ?>
				
			                 <?php echo"<a href='paymentSend.php?id=" . $getID . "&amount=" . $amount. "'>"; ?>
                <div class="tooltip">
					<img src = "icons/bill(black).png" style="height:auto;width:120px;">
				<span class="tooltiptext">Pay in Cash</span>
			</div>
               
       
                  </a>
		
	</div>
</div>

</body>
</html>
