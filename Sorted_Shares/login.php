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
		<script src='js/login.js'></script>
  	</head>
	
  	<body>
    	<div class="screen" style="text-align:center;">
			
		<img src="icons/logo(black).png" style="height:150px; width:auto; margin:auto; margin-top:2%;">
		<h1 style="font-size:3em; margin-bottom:2%">Sorted Shares</h1>
		<div class="content">
			<form class="loginRegister" action="loginCheck.php" method="POST" id='form'>
				<label>Username</label>
				<input type="text" name="uName" id="username">
				<div class="alert" id="1"></div>
				<label>Password</label>
				<input type="password" name="user_password" id="password">
				<div class="alert" id="2"></div>
				<input class="button" type="submit" value="Login">
			</form>
			<form class="loginRegister" action="register.php" method="POST">
				<label>or</label>
				<input class="button" type="submit" value="Register">
			</form>
			<form class="loginRegister" action="recoverUser.php" method="POST">
				<label>or</label>
				<input class="button" type="submit" value="Recover Password">
			</form>
		</div>
		

  	</body>
</html>
