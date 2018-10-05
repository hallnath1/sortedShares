<?php
session_start();
require 'database.php';
$db = new Database();
	
$color1 = $_POST["color1"];
$color2 = $_POST["color2"];
	
$newColor = $color1 . ', ' . $color2;

$sql = "UPDATE Users SET color = :color WHERE UserID = :id;";
$stmt = $db->prepare($sql);
$stmt->bindValue(':color', $newColor, SQLITE3_TEXT);
$stmt->bindValue(':id', $_SESSION['id'], SQLITE3_INTEGER);
$stmt->execute();

$_SESSION['color'] = $newColor;

header('Location: index.php');
?>