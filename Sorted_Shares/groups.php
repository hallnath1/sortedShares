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
	<script src='js/groups.js'></script>
</head>
<?php echo "<body style='background:linear-gradient(to bottom right, ".$_SESSION['color'].")'>";?>
	<div class="screen" style="overflow: scroll;">
		<?php
		include 'menu_top.php';
		include 'menu_bar.php';
		?>
		<div class="topTitle">
			<h1 style="display:inline-block; margin:1% 1%;">Your Groups</h1>
		
			<div class="tooltip" style="height:100%;display:inline-block;float:right;">
				<a href='createGroups.php'>
					<img src = "icons/add(black).png" class="addImage" id="createGroupsImage" style="height:auto;width:40%;">
				</a>
				<span class="tooltiptext">New Group</span>
			</div>
			
		</div>
		<div class="content">
			<hr>
			<?php
			$sql = "SELECT * FROM Groups INNER JOIN Users_Groups ON Users_Groups.GroupID = Groups.GroupID WHERE Users_Groups.UserID = :userid ;";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':userid', $_SESSION['id'], SQLITE3_INTEGER);
			$results = $stmt->execute();
    
            
			while(($row = $results->fetchArray())){
				echo "<h2 style='margin-bottom:1%;display:inline-block;'>" . $row['name'] . "</h2>";
				$sql = "SELECT * FROM Users INNER JOIN Users_Groups ON Users_Groups.UserID = Users.UserID WHERE Users_Groups.GroupID = :groupid;";
				$stmt = $db->prepare($sql);
				$stmt->bindValue(':groupid', $row['GroupID'], SQLITE3_INTEGER);
				$members = $stmt->execute();
				echo "<div class='tooltip' style='display:inline-block;float:right;'>
					<a href='leaveGroup.php?id=" . $row['GroupID']  . "'><img src = 'icons/exit(black).png' class='addImage leaveButton'' style='width:48px;height:auto;margin-top:0.83em; padding-right:1vw'></a>
				<span class='tooltiptext'>Leave Group</span>
				</div>";
				echo "
					<div class='tooltip' style='display:inline-block;float:right;'>
				<a href='newPaymentGroup.php?id=" . $row['GroupID']  . "'><img src = 'icons/bill(black).png' class='addImage paymentButton'' style='width:80px;height:auto;margin-top:0.83em; padding-right:1vw'></a>
				<span class='tooltiptext'>New Group Payment</span>
				</div>";
				echo "
					<div class='tooltip' style='display:inline-block;float:right;'>
				<a href='newMember.php?id=" . $row['GroupID']  . "'><img src = 'icons/addPeople(black).png' class='addImage paymentButton'' style='width:50px;height:auto;display:inline-block;margin-top:0.83em; padding-right:1vw'></a>
				<span class='tooltiptext'>Add a person</span>
				</div>";
				echo "<ul>";
				while(($member = $members->fetchArray())){
					echo "<div class='profileDisplay groupDisplay'  id='". $member['username'] . "'>";
						echo "<img src='profilePictures/".$member['profileLink']."' align='middle'><p id='name'>";
						echo $member['fName'] . " " . $member['lName'];
						echo "</p></div>";
				}
				echo "</ul><hr>";
			}
			?>
		</div>
	</div>
</body>
</html>
