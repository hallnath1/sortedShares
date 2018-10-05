<?php
session_start();
require 'database.php';
$db = new Database();
	
$newUName = $_POST["newUName"];
	
//Test User Exists
$sql = "SELECT UserID FROM Users WHERE username = :username;";
$stmt = $db->prepare($sql);
$stmt->bindValue(':username',$newUName,SQLITE3_TEXT);
$results = $stmt->execute()->fetchArray();

if(($results == null) || ($_SESSION['id'] == $results['UserID'])){
	header('Location: addPeople.php');
}
else{
	//Test User is not already a friend
	$sql = "SELECT FriendID FROM Relations WHERE UserID = :userid AND FriendID = :friendid;";
	
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':userid', $_SESSION['id'], SQLITE3_INTEGER);
	$stmt->bindValue(':friendid', $results['UserID'], SQLITE3_INTEGER);
	$exists = $stmt->execute()->fetchArray();
	
	if($exists != null){
		header('Location: addPeople.php');
	}
	else{
		//Insert into database the new relation
		$sql = "INSERT INTO Relations VALUES (NULL, :userid, :friendid);";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':userid', $_SESSION['id'], SQLITE3_INTEGER);
		$stmt->bindValue(':friendid', $results['UserID'], SQLITE3_INTEGER);
		$stmt->execute();
		
		//Insert into database the new relation
		$sql = "INSERT INTO Relations VALUES (NULL, :userid, :friendid);";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':userid', $results['UserID'], SQLITE3_INTEGER);
		$stmt->bindValue(':friendid', $_SESSION['id'], SQLITE3_INTEGER);
		$stmt->execute();
		
		header('Location: messages.php');
	}
}
?>