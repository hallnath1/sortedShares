<?php
session_start();
require 'database.php';
$db = new Database();
$input = $_POST['passcode'];
$password = $_POST['user_password'];

$passwordTwo = $_POST['user_password_two'];
$value = $_POST['value'];
$id = $_POST['userid'];
if($value == $input){

  if($password == $passwordTwo){
	if((strlen($password)>6) && (strlen($password)<15)){
	$sql = "SELECT salt FROM Users WHERE UserID = ".$id.";";
	$result = $db->querySingle($sql);
	
	$salt = $result['salt'];
	echo $sql;
	echo $salt;
	
	$encrypted_password = sha1($salt."--".$password);
	
	$sql = "UPDATE Users SET password='".$encrypted_password."' WHERE UserID = ".$id.";";
	$db->exec($sql);
	}
  }
}
header('Location: login.php');
?>