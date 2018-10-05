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
			<div class="content">
				<h1 style="display:inline-block;">New Member for <?php
			$sql = "SELECT * FROM Groups WHERE GroupID = :id;";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':id', $_GET['id'], SQLITE3_INTEGER);
			$results = $stmt->execute()->fetchArray();
			echo $results['name'];
				?></h1>
				<?php
					echo "<form class='loginRegister' action='newMemberProcessing.php?id=". $_GET['id'] . "' method='POST'>"
				?>
					<label>New Person's Username</label>
					<input type="text" name="newUName">
					<input class="button" type="submit" value="Add">
				</form>

			</div>
		</div>
	</body>
</html>
