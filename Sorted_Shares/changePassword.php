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
</head>
<?php echo "<body style='background:linear-gradient(to bottom right, ".$_SESSION['color'].")'>";?>
	<div class="screen">
		<?php
		include 'menu_top.php';
		include 'menu_bar.php';
		?>
		<div class="topTitle">
			<h1 style="display:inline-block; margin:1% 1%;">Change Password</h1>
		
			<div class="tooltip" style="height:100%;display:inline-block;float:right;">
				<a href='index.php'>
					<img src = "icons/exit(black).png"style="height:60px;width:auto;">
				</a>
				<span class="tooltiptext">Exit</span>
			</div>
		</div>
		
		<div class="content">
			<form action="changePasswordProcessing.php" class="loginRegister" method="POST">
				<h2>Current Password</h2>
				<input type="password" name="currentPassword">
				<h2>New Password</h2>
				<input type="password" name="newPassword">
				<h2>Re-Enter Password</h2>
				<input type="password" name="newPasswordCheck">
				<input class="button" type="submit" value="Update">
			</form>
		</div>
	</div>
</body>
</html>