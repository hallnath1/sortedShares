<?php
session_start();
require 'database.php';
$db = new Database();

$currentPassword = $_POST["currentPassword"];
$newPassword = $_POST['newPassword'];
$newPasswordCheck = $_POST['newPasswordCheck'];

$sql = "SELECT * FROM Users WHERE UserID = '" . $_SESSION['id'] . "';";

$result = $db->querySingle($sql);
$salt = $result['salt'];

$encrypted_password = sha1($salt."--".$currentPassword);

if($encrypted_password == $result['password']){
	$db = new Database();
	if($newPassword == $newPasswordCheck){
		$sql = "UPDATE Users SET password = :password WHERE UserID = :id;";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':password', sha1($salt."--".$newPassword),SQLITE3_TEXT);
		$stmt->bindValue(':id', $_SESSION['id'], SQLITE3_INTEGER);
		$result = $stmt->execute();
	}
}

header('Location: index.php'); 
?>