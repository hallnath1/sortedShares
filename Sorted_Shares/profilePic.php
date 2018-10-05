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
			<h1 style="display:inline-block; margin:1% 1%;">Profile Picture</h1>
			<div class="tooltip" style="height:100%;display:inline-block;float:right;">
				<a href='index.php'>
					<img src = "icons/exit(black).png"style="height:60px;width:auto;">
				</a>
				<span class="tooltiptext">Exit</span>
			</div>
		</div>
		<div class="content">
			<form class="loginRegister" action="profilePicProcessing.php" method="POST" enctype="multipart/form-data">
				<label>Current Image</label>
				<?php
				$sql = "SELECT profileLink FROM Users WHERE UserID = :id;";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':id', $_SESSION['id'], SQLITE3_INTEGER);
				$result = $stmt->execute()->fetchArray();
				echo "<img class='largeProfile' src='profilePictures/" . $result['profileLink'] . "'>"
				?>
			<label for="image">New Image</label>
			<input type="file" name="image" required>
			<input type="submit" class="button" name="submit" value="Submit">
			</form>
			
				


		</div>
	</div>
</body>
</html>