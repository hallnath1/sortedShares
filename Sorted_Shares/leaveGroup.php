<?php
session_start();
require 'database.php';
$db = new Database();
	
$groupID = $_GET['id'];
$userID = $_SESSION['id'];

$sql = "DELETE FROM Users_Groups WHERE UserID = :userid AND GroupID = :groupid ;";
$stmt = $db->prepare($sql);
$stmt->bindValue(':userid', $userID, SQLITE3_INTEGER);
$stmt->bindValue(':groupid', $groupID, SQLITE3_INTEGER);
$stmt->execute();

header('Location: groups.php');
?>