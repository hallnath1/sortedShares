<?php
session_start();
require 'database.php';
$db = new Database();

$UserID = $_SESSION['id'];
$FriendID = $_GET['id'];

$sql = "DELETE FROM Messages WHERE((UserID = :userid AND ToID = :friendid) OR (UserID= :friendid AND ToID= :userid)) AND (type='paymentTotal');";
$stmt = $db->prepare($sql);
$stmt->bindValue(':userid', $UserID, SQLITE3_INTEGER);
$stmt->bindValue(':friendid', $FriendID, SQLITE3_INTEGER);
$stmt->execute();

$sql = "UPDATE Bills SET status='Awaiting Payment' WHERE ((UserID = :id AND PayeeID = :fromid) OR (PayeeID = :id AND UserID = :fromid)) AND (status='Payment Pending');";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $UserID, SQLITE3_INTEGER);
$stmt->bindValue(':fromid', $FriendID, SQLITE3_INTEGER);
$stmt->execute();

header('Location: index.php');
?>