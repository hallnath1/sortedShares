<?php
session_start();
require 'database.php';
$db = new Database();

$UserID = $_SESSION['id'];
$FriendID = $_SESSION['friendID'];
$message = $_POST['message'];

$sql = "INSERT INTO Messages VALUES (:id, :fromid,'".$message."', '".date("Y-m-d h:i:s")."', 'text', null);";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $UserID, SQLITE3_INTEGER);
$stmt->bindValue(':fromid', $FriendID, SQLITE3_INTEGER);
$stmt->execute();

header('Location: messages.php');
?>