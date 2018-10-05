<?php
session_start();
require 'database.php';
$db = new Database();
	
$newUName = $_POST["newUName"];
	
//Test User Exists
$sql = "SELECT UserID FROM Users WHERE username = :username;";
$stmt = $db->prepare($sql);
$stmt->bindValue(':username', $newUName, SQLITE3_TEXT);
$results = $stmt->execute()->fetchArray();

if(($results == null) || ($_SESSION['id'] == $results['UserID'])){
	header("Location: newMember.php?id=" . $_GET['id']);
}
else{
	//Test User is not already in Group
	$sql = "SELECT UserID FROM Users_Groups WHERE UserID = :userid AND GroupID = :groupid ;";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':userid', $results['UserID'], SQLITE3_INTEGER);
	$stmt->bindValue(':groupid', $_GET['id'], SQLITE3_INTEGER);
	$exists = $stmt->execute()->fetchArray();

	if($exists != null){
		header('Location: newMember.php');
	}else{
		//Insert into database the new relation
		$sql = "INSERT INTO Users_Groups VALUES (:userid, :groupid);";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':userid', $results['UserID'], SQLITE3_INTEGER);
		$stmt->bindValue(':groupid', $_GET['id'], SQLITE3_INTEGER);
		$stmt->execute();		
		header('Location: groups.php');
	}
}
?>