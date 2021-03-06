<?php
session_start();
require 'database.php';
$db = new Database();

$UserID = $_SESSION['id'];
$FriendID = $_GET['id'];

$sql= "UPDATE BILLS SET status='Paid' WHERE((UserID = :userid AND PayeeID = :friendid) OR (UserID= :friendid AND PayeeID= :userid)) AND (status='Payment Pending');";
$stmt = $db->prepare($sql);
$stmt->bindValue(':userid', $UserID, SQLITE3_INTEGER);
$stmt->bindValue(':friendid', $FriendID, SQLITE3_INTEGER);
$stmt->execute();


$sql = "DELETE FROM Messages WHERE((UserID = :userid AND ToID = :friendid) OR (UserID= :friendid AND ToID= :userid)) AND (type='paymentTotal' OR type='alert');";
$stmt = $db->prepare($sql);
$stmt->bindValue(':userid', $UserID, SQLITE3_INTEGER);
$stmt->bindValue(':friendid', $FriendID, SQLITE3_INTEGER);
$stmt->execute();

header('Location: messages.php');
?>