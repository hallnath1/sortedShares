<?php
//Get sent and recieved messages with both users involved
//Combine into one array
//Sort based on time/date sent
//Output to screen using respective divs

session_start();
require 'database.php';
$db = new Database();
date_default_timezone_set('UTC');
$UserID = $_SESSION['id'];

$friendUsername = $_POST['username'];
if($friendUsername != ''){
	$sql = "SELECT * FROM Users WHERE username = :username;";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':username', $friendUsername, SQLITE3_TEXT);
	$result = $stmt->execute()->fetchArray();
	
	$ToID = $result['UserID'];
	$_SESSION['friendID'] = $ToID;
}
else{
	$ToID = $_SESSION['friendID'];
	$sql = "SELECT * FROM Users WHERE username = :username;";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':username', $ToID, SQLITE3_TEXT);
	$result = $stmt->execute()->fetchArray();
}

$sql = "SELECT * FROM Messages WHERE (UserID= :userid AND ToID= :toid ) OR (UserID= :toid AND ToID= :userid ) ORDER BY sentTimeDate;";
$stmt = $db->prepare($sql);
$stmt->bindValue(':userid', $UserID, SQLITE3_TEXT);
$stmt->bindValue(':toid', $ToID, SQLITE3_TEXT);
$results = $stmt->execute();
	
while(($row = $results->fetchArray())){
	$date = new DateTime($row['sentTimeDate']);
	if($row['UserID'] == $UserID){
		if($row['type'] == 'text'){
			echo "<div class='messageSent'>" . htmlspecialchars($date->format('H:i') . ": " . $row['message'], ENT_QUOTES, 'utf-8')  . "</div>";
		}
		else if($row['type'] == 'alert'){
			echo "<div class='messageSent'><h2 style='text-align:center;'>" . $row['message'] . "</h2></div>";
		}
		else if($row['type'] == 'paymentTotal'){
			echo "<div class='messageSent'><h2 style='text-align:center;'>" . $row['message'] . "</h2><a href='clearMessage.php?id=" . $ToID . "' class='messageButton'>Cancel</a></div>";
		}
		else if($row['type'] == 'confirm'){
			echo "<div class='messageSent'><h2 style='text-align:center;'>" . $row['message'] . "</h2></div>";
		}
	}
	else{
		if($row['type'] == 'text'){
			echo "<div class='messageRecieved'>" . htmlspecialchars($date->format('H:i') . ": " . $row['message'], ENT_QUOTES, 'utf-8')  .  "</div>";
		}
		else if($row['type'] == 'alert'){
			echo "<div class='messageRecieved'><h2 style='text-align:center;'>" . $row['message'] . "</h2><a href='index.php' class='messageButton'>Pay</a></div>";
		}
		else if($row['type'] == 'paymentTotal'){
			echo "<div class='messageRecieved'><h2 style='text-align:center;'>" . $row['message'] . "</h2><a href='clearPayment.php?id=" . $row['UserID'] . "' class='messageButton'>Agree</a><a href='clearMessage.php?id=" . $row['UserID'] . "' class='messageButton'>Disagree</a></div>";
		}
		else if($row['type'] == 'confirm'){
			echo "<div class='messageRecieved'><h2 style='text-align:center;'>" . $row['message'] . "</h2><a href='confirmPayment.php?billid=".$row['BillID']."&userid=" . $row['UserID'] . "' class='messageButton'>Confirm</a><a href='denyPayment.php?billid=".$row['BillID']."&userid=" . $row['UserID'] . "' class='messageButton'>Remove</a></div>";
		}
	}
	
}
?>

