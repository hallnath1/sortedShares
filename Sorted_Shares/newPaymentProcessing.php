<?php
session_start();
require 'database.php';
$db = new Database();
date_default_timezone_set('UTC');

$name = $_POST['groupName'];
$amount = abs($_POST['amount']*100);
$recieverID = $_SESSION['id'];
$uName = $_POST['username'];

$sql = "SELECT * FROM Users WHERE username = :username;";
$stmt = $db->prepare($sql);
$stmt->bindValue(':username', $uName, SQLITE3_TEXT);
$result = $stmt->execute()->fetchArray();

$payerID = $result['UserID'];

$sql = "INSERT INTO Bills VALUES (null, :title, :amount, :userid, :toid , 'Pending', '".date("Y-m-d")."');";
$stmt = $db->prepare($sql);
$stmt->bindValue(':title', $name, SQLITE3_TEXT);
$stmt->bindValue(':amount', $amount, SQLITE3_INTEGER);
$stmt->bindValue(':userid', $recieverID, SQLITE3_INTEGER);
$stmt->bindValue(':toid', $payerID, SQLITE3_INTEGER);
$stmt->execute();

$sql = "SELECT BillID FROM Bills ORDER BY BillID DESC LIMIT 1;";
$BillID = $db->querySingle($sql);

$sql = "INSERT INTO Messages VALUES (".$recieverID.", ".$payerID.",'Please confirm that you owe me £".($amount/100)." for ".htmlspecialchars($name, ENT_QUOTES, 'utf-8')."', '".date("Y-m-d h:i:s")."', 'confirm', ".$BillID['BillID'].");";
$stmt = $db->prepare($sql);
$stmt->execute();

$sql = "DELETE FROM Messages WHERE ((UserID= :userid AND ToID= :payeeid) OR (ToID= :userid AND UserID= :payeeid)) AND type='alert';";
$stmt = $db->prepare($sql);
$stmt->bindValue(':userid', $recieverID, SQLITE3_INTEGER);
$stmt->bindValue(':payeeid', $payerID, SQLITE3_INTEGER);
$stmt->execute();

header('Location: index.php');
?>