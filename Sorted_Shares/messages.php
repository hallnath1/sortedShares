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
	<script src='js/messages.js'></script>
</head>
<?php echo "<body style='background:linear-gradient(to bottom right, ".$_SESSION['color'].")'>";?>
	<div class="screen" style="overflow:hidden;">
		<?php
		include 'menu_top.php';
		include 'menu_bar.php';
		?>

		<div class='side_menu'>
			<div style="margin-bottom:0.5%;display:block;height:3%;">
				<h2 style="display:inline-block;font-size:3vw;">People</h2>
				<div class="tooltip" style="display:inline-block;float:right;width:30%; height:auto;">
					<a href='addPeople.php'><img src="icons/addPeople(black).png" style="height:auto;width:80%;float:right;"></a>
					<span class="tooltiptext" style="bottom: 6%;">Add People</span>
				</div>
			</div>
			<?php
			$sql = "SELECT * FROM Users INNER JOIN Relations ON Users.UserID = Relations.FriendID WHERE Relations.UserID =  :id ;";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':id', $_SESSION['id'], SQLITE3_TEXT);
			$results = $stmt->execute();
			$css = "style='background-color:rgba(100,100,100,0.5)'";
			while(($row = $results->fetchArray())){
				echo "<a href='messages.php?id=".$row['UserID']."'><div class='profileDisplay' id='". $row['username'] . "' " . $css . ">";
				echo "<img src='profilePictures/".$row['profileLink']."' style='margin-right:2%;'>";
				echo "<p id='name'>";
				echo htmlspecialchars($row['fName'] . " " . $row['lName'], ENT_QUOTES, 'utf-8');
				echo "</p></div></a>";
				$css = '';
			}
					
			?>
					
		</div>
		

				
		<form id='form' class='message_box' action='sendMessage.php' method="POST">
			<div class="tooltip" style="height:100%;display:inline-block;">
			<a id='clear' href="clearContent.php"><img src="icons/remove(white).png" style="height:100%;display:inline-block;zindex:100;"></a>
			<span class="tooltiptext" style="bottom: 6%;">Remove Alerts</span>
		</div>

			
		<input name="message" class="newText" type="text"/>

		<input type="image" src="icons/send(white).png" id="newImage"/>
							    
	</form>
	<div class="messageReciever">

	</div>
	<div class="messageContent">

	 </div>
		
		
</div>
</body>
</html>
