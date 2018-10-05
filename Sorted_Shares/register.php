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
	<script src='js/register.js'></script>
</head>
<body style='font-size:150%'>
	<div class="screen" style='text-align:center;overflow: scroll;'>
		
		<img src="icons/logo(black).png" style="height:150px; width:auto; margin:auto; margin-top:1%;">
		<h1 style="font-size:3em; margin-bottom:2%">Sorted Shares</h1>
		
		<div class="content">
			<h1>Register</h1>
			<form class="loginRegister" action="registerNewUser.php" id="form" method ="POST">
				<label>First Name</label>
				<input type="text" name="fName">
				<div class="alert"></div>
				<label>Last Name</label>
				<input type="text" name="lName">
				<div class="alert"></div>
				<label>Username</label>
				<input type="text" name="uName" id='username'>
				<div class="alert" id="2"></div>
				<label>E-mail Address</label>
				<input type="text" name="email" id='email'>
				<div class="alert" id="3"></div>
				<label>Password</label>
				<input type="password" name="user_password" id='password'>
				<div class="alert" id="4"></div>
				<label>Re-enter Password</label>
				<input type="password" name="user_password_check" id='password_check'>
				<div class="alert" id="1"></div>
				<input class="button" type="submit" value="Register">
			</form>
			<form class="loginRegister" action="login.php" method="POST">
				<label>or</label>
				<input class="button" type="submit" value="Login">
			</form>
		</div>
	</div>
</body>
</html>
