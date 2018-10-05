<?php
	session_start();
	require 'database.php';
	$db = new Database();
	
	$fName = $_POST["fName"];
	$lName = $_POST["lName"];
	$uName = $_POST["uName"];
	$email = $_POST["email"];
	$user_password = $_POST["user_password"];
	$user_password_check = $_POST["user_password_check"];

	$sql = "SELECT * FROM Users WHERE username = :username;";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':username', $uName, SQLITE3_TEXT);
	$result = $stmt->execute()->fetchArray();

	
	if(($user_password === $user_password_check) && ($result == null)){
	  if((strlen($user_password) > 6) && (strlen($user_password) < 15)){
		//Hash password
		$salt = sha1(time());
		$encrypted_password = sha1($salt."--".$user_password);
		
		$sql = "INSERT INTO Users VALUES (null,:fName, :lName, :username, :email, :password, :salt, 'temp.png', 'white, grey', null)";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':fName', $fName, SQLITE3_TEXT);
		$stmt->bindValue(':lName', $lName, SQLITE3_TEXT);
		$stmt->bindValue(':username', $uName, SQLITE3_TEXT);
		$stmt->bindValue(':email', $email, SQLITE3_TEXT);
		$stmt->bindValue(':password', $encrypted_password, SQLITE3_TEXT);
 		$stmt->bindValue(':salt', $salt, SQLITE3_TEXT);
		$results = $stmt->execute();
		
		$sql = "SELECT * FROM Users WHERE email = :email;";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':email', $email,SQLITE3_TEXT);
		$result = $stmt->execute()->fetchArray();
		
		
		$_SESSION['id'] = $result['UserID'];
        $_SESSION['color'] = $result['color'];
        $_SESSION['link'] = $result['paypalLink'];
 		header('Location: index.php');
	}
	}
	else{
		header('Location: register.php');
	}
?>