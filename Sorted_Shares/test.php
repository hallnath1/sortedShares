<?php
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
		<script src='js/test.js'></script>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
</head>
<body>
	<div class="screen">
		
		<?php
			include 'menu_top.php';
			include 'menu_bar.php';
		?>

		<div class="content">
			<h1>Test</h1>
			<form class="loginRegister" action="createGroupProcessing.php" method ="POST">
				<input type="text" name="username">
				
				<input class="button" type="submit" value="Test It!">
			</form>
            
        <a href='https://www.paypal.me/NathanH168/25gbp' target="_blank"><img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_200x51.png" alt="PayPal" /></a>
            <a href="http://www.textfixer.com" onclick="javascript:void window.open('http://www.textfixer.com','1521071839267','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;">Pop-up Window</a>
		</div>
	</div>
</body>
</html>
