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
	<script src='js/createGroups.js'></script>
</head>
<?php echo "<body style='background:linear-gradient(to bottom right, ".$_SESSION['color'].")'>";?>
	<div class="screen">
		<?php
		include 'menu_top.php';
		include 'menu_bar.php';
		?>
		<div class="content">
			<h1 style="display:inline-block;">Create a group:</h1>
			<form class="loginRegister" action="groups.php" id="form" method="POST">
				<label>Group Name</label>
				<input type="text" name="groupName" class="newText">
				<div class="borderDiv">
					<?php
					$sql = "SELECT * FROM Users INNER JOIN Relations ON Users.UserID = Relations.FriendID WHERE Relations.UserID = :id;";
					$stmt = $db->prepare($sql);
					$stmt->bindValue(':id', $_SESSION['id'], SQLITE3_INTEGER);
					$results = $stmt->execute();
					while(($row = $results->fetchArray())){
						echo "<a href=''><div class='profileDisplay profileSelect'  id='". $row['username'] . "'>";
						echo "<img src='profilePictures/".$row['profileLink']."' align='middle'><p id='name'>";
						echo $row['fName'] . " " . $row['lName'];
						echo "</p></div></a>";
					}
					?>
					<div class="tooltip" style="float:center;">
		
							<a href='addPeople.php'><img src="icons/new(black).png" style="height:40px;"></a>
						
						<span class="tooltiptext">Add People</span>
					</div>
				</div>
				<input class="button" type="submit" value="Create Group">
			</form>
		</div>
	</div>
</body>
</html>
