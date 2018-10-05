<?php
session_start();
require 'database.php';
$db = new Database();
date_default_timezone_set('UTC');

$name = $_POST['paymentName'];
$id = $_SESSION['id'];
	
$sql = 'SELECT UserID FROM Users;';
$results = $db->query($sql);
while(($row = $results->fetchArray())){
	$amount = abs($_POST[$row['UserID']]*100);
	if(($amount != null) && ($amount != 0) && ($row['UserID'] != $id)){
		$sql = "INSERT INTO Bills VALUES (null, :title, :amount, :userid, :toid , 'Pending', '".date("Y-m-d")."');";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':title', $name, SQLITE3_TEXT);
		$stmt->bindValue(':amount', $amount, SQLITE3_INTEGER);
        $stmt->bindValue(':userid', $id, SQLITE3_INTEGER);
        $stmt->bindValue(':toid', $row['UserID'], SQLITE3_INTEGER);
		$stmt->execute();
		
		$sql = "SELECT BillID FROM Bills ORDER BY BillID DESC LIMIT 1;";
		$BillID = $db->querySingle($sql);
		

		$sql = "INSERT INTO Messages VALUES (".$id.", ".$row['UserID'].",'Please confirm that you owe me £".($amount/100)." for ".htmlspecialchars($name, ENT_QUOTES, 'utf-8')."', '".date("Y-m-d h:i:s")."', 'confirm', ".$BillID['BillID'].");";
$stmt = $db->prepare($sql);
$stmt->execute();
		
	      
	  $sql = "DELETE FROM Messages WHERE ((UserID= :userid AND ToID= :payeeid) OR (ToID= :userid AND UserID= :payeeid)) AND type='alert';";
	  $stmt = $db->prepare($sql);
	  $stmt->bindValue(':userid', $id, SQLITE3_INTEGER);
	  $stmt->bindValue(':payeeid', $row['UserID'], SQLITE3_INTEGER);
	  $stmt->execute();
	}
}
header('Location: index.php');
?>