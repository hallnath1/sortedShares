<?php
	session_start();
	require 'database.php';
	$db = new Database();
	
	$username = $_POST["username"];

	$sql = "SELECT username FROM Users WHERE username = :username;";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':username', $username, SQLITE3_TEXT);
	$result = $stmt->execute()->fetchArray();

	if($result['username']==$username){
		echo 'exists';
	}
	else{
		echo 'new';
	}
	
?>