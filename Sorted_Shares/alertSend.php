<?php
session_start();
require 'database.php';
$db = new Database();
	
$UserID = $_SESSION['id'];
$FriendID = $_GET['id'];
$amount = $_GET['amount'];
$amount = number_format($amount/100, 2, '.', ' ');
$message = "REMINDER - In total you owe me £" . $amount . ".";

$sql = "INSERT INTO Messages VALUES (:userid, :friendid, :message, '" . date("Y-m-d h:i:s") . "', 'alert', null);";
$stmt = $db->prepare($sql);
$stmt->bindValue(':userid', $UserID, SQLITE3_INTEGER);
$stmt->bindValue(':friendid', $FriendID, SQLITE3_INTEGER);
$stmt->bindValue(':message', $message, SQLITE3_TEXT);
$stmt->execute();
header('Location: messages.php');
?>