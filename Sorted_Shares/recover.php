<?php
session_start();
require 'database.php';
$db = new Database();

$sql = "SELECT * FROM Users WHERE username = '".$_POST['username']."' ;";
$results = $db->querySingle($sql);

$seed = str_split('abcdefghijklmnopqrstuvwxyz'
                     .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                     .'0123456789');
shuffle($seed); 
$rand = '';
foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];
 

if($results['email'] != ''){mail($results['email'], 'Password Recover', 'Code: '. $rand . '');}
?>
    
<!DOCTYPE html>
<html>
	<head>
    	<meta charset="UTF-8" name="viewport" content="width=device-width">
    	<title>Sorted Shares</title>
		<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
		<link rel="stylesheet" href="style.css" type="text/css" charset="utf-8">
		<script src='js/jquery-3.3.1.min.js'></script>
  	</head>
	
  	<body>
    	<div class="screen" style="text-align:center;">
			
		<img src="icons/logo(black).png" style="height:150px; width:auto; margin:auto; margin-top:2%;">
		<h1 style="font-size:3em; margin-bottom:2%">Sorted Shares</h1>
		<div class="content">
		<h2>A link should be sent to the email linked to this account!</h2>
			<form class="loginRegister" action="recoverPro.php" method="POST" id='form'>
				<label>Recover Code</label>
				<input type="text" name="passcode" id="username">
				<div class="alert" id="1"></div>
				<label>New Password</label>
				<input type="password" name="user_password" id="password">
				<div class="alert" id="2"></div>
				<label>New Password Confirm</label>
				<input type="password" name="user_password_two" id="password">
				<div class="alert" id="2"></div>
				<input class="button" type="submit" value="Login">
				<input type="hidden" name='value' value=<?php echo "'".$rand."'"; ?>>
				<input type="hidden" name='userid' value=<?php echo ''.$results['UserID'].'';?>>
			</form>
		</div>
	</body>
</html>
