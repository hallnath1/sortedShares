<?php
session_start();
require 'database.php';
$db = new Database();
	
$uName = $_POST["uName"];
$password = $_POST["user_password"];

if($uName != NULL){
	$sql = "SELECT * FROM Users WHERE username = :username;";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':username', $uName,SQLITE3_TEXT);
	$result = $stmt->execute()->fetchArray();
	
	$salt = $result['salt'];
	
	$encrypted_password = sha1($salt."--".$password);

	if($encrypted_password == $result['password']){
		$_SESSION['id'] = $result['UserID'];
		$_SESSION['link'] = $result['paypalLink'];
		$_SESSION['color'] = $result['color'];
		header('Location: index.php');
	}
	else{
		if(!isset($_POST['js'])){
		  header('Location: login.php');
		}
		echo 'error';
	}
}
else{
	if(!isset($_POST['js'])){
	      header('Location: login.php');
	}
	echo 'error';
}
?>