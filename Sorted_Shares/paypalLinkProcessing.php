<?php

session_start();
if(!isset($_SESSION['id'])){
	header('Location: login.php');
}
require 'database.php';
$db = new Database();

$id = $_SESSION['id'];

$textArr = explode ('/',$_POST['link']);
$no = count($textArr);
$text = $textArr[$no-1];

$sql = "UPDATE Users SET paypalLink = :link WHERE UserID = :id;";
$stmt = $db->prepare($sql);
$stmt->bindValue(':link', $text, SQLITE3_TEXT);
$stmt->bindValue(':id', $_SESSION['id'], SQLITE3_INTEGER);
$stmt->execute();

$_SESSION['link'] = $text;

header('Location: index.php');
?>