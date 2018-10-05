<?php
session_start();
require 'database.php';
$db = new Database();

$ToID = $_SESSION['id'];
$BillID = $_GET['billid'];
$UserID = $_GET['userid'];

$sql = "DELETE FROM Bills WHERE PayeeID = :toid AND BillID = :billid;";
$stmt = $db->prepare($sql);
$stmt->bindValue(':toid', $ToID, SQLITE3_INTEGER);
$stmt->bindValue(':billid', $BillID, SQLITE3_INTEGER);
$stmt->execute();

$sql = "DELETE FROM Messages WHERE ((UserID = :userid AND ToID = :toid) AND BillID= :billid) AND (type='alert' OR type='confirm');";
$stmt = $db->prepare($sql);
$stmt->bindValue(':userid', $UserID, SQLITE3_INTEGER);
$stmt->bindValue(':toid', $ToID, SQLITE3_INTEGER);
$stmt->bindValue(':billid', $BillID, SQLITE3_INTEGER);
$stmt->execute();

header('Location: index.php');
?>