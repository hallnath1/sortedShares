<?php
session_start();
require 'database.php';
$db = new Database();

$ToID = $_SESSION['id'];
$BillID = $_GET['billid'];
$UserID = $_GET['userid'];
echo $ToID;
echo $BillID;
echo $UserID;

$sql = "UPDATE Bills SET status='Awaiting Payment' WHERE PayeeID = :payeeid AND BillID = :billid;";
$stmt = $db->prepare($sql);
$stmt->bindValue(':payeeid', $ToID, SQLITE3_INTEGER);
$stmt->bindValue(':billid', $BillID, SQLITE3_INTEGER);
$stmt->execute();

$sql = "DELETE FROM Messages WHERE (UserID= :userid AND ToID= :payeeid AND BillID= :billid) OR (UserID= :userid AND ToID= :payeeid AND type!='text');";
$stmt = $db->prepare($sql);
$stmt->bindValue(':userid', $UserID, SQLITE3_INTEGER);
$stmt->bindValue(':payeeid', $ToID, SQLITE3_INTEGER);
$stmt->bindValue(':billid', $BillID, SQLITE3_INTEGER);
$stmt->execute();

header('Location: index.php');
?>