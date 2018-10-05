<?php
session_start();
require 'database.php';
$db = new Database();

$UserID = $_SESSION['id'];
$FriendID = $_SESSION['friendID'];

$sql = "DELETE FROM Messages WHERE((UserID = :userid AND ToID = :friendid) OR (UserID= :friendid AND ToID= userid)) AND (type='alert');";
$stmt = $db->prepare($sql);
$stmt->bindValue(':userid', $UserID, SQLITE3_INTEGER);
$stmt->bindValue(':friendid', $FriendID, SQLITE3_INTEGER);
$stmt->execute();

echo $sql
//header('Location: messages.php');
?>