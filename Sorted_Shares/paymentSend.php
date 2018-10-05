<?php
session_start();
require 'database.php';
$db = new Database();
	
$UserID = $_SESSION['id'];
$FriendID = $_GET['id'];
$amount = $_GET['amount'];
$amount = number_format($amount/100, 2, '.', ' ');
$message = "I have paid you £" . $amount . ".";

$sql = "INSERT INTO Messages VALUES (:id, :fromid,'".$message."', '".date("Y-m-d h:i:s")."', 'paymentTotal', null);";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $UserID, SQLITE3_INTEGER);
$stmt->bindValue(':fromid', $FriendID, SQLITE3_INTEGER);
$stmt->execute();

$sql = "UPDATE Bills SET status='Payment Pending' WHERE ((UserID = :id AND PayeeID = :fromid) OR (PayeeID = :id AND UserID = :fromid)) AND (status='Awaiting Payment');";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $UserID, SQLITE3_INTEGER);
$stmt->bindValue(':fromid', $FriendID, SQLITE3_INTEGER);
$stmt->execute();

$sql = "DELETE FROM Messages WHERE((UserID=:id AND ToID=:fromid) OR (UserID=:fromid AND ToID=:id)) AND (type='alert');";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $UserID, SQLITE3_INTEGER);
$stmt->bindValue(':fromid', $FriendID, SQLITE3_INTEGER);
$stmt->execute();

header('Location: messages.php');
?>