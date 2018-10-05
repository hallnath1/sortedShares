<?php
session_start();
require 'database.php';
$db = new Database();
$array = (array)json_decode($_POST['array']);
var_dump($array);

$sql="INSERT INTO Groups VALUES(null, :name, null);";
$stmt = $db->prepare($sql);
$stmt->bindValue(":name", $array[0], SQLITE3_TEXT);
$stmt->execute();

unset($array[0]);

$sql = "SELECT GroupID FROM Groups WHERE oid = (select max(oid) from Groups);";
$result = $db->querySingle($sql);
$groupId = $result['GroupID'];

$count = 1;
if (is_array($array) || is_object($array))
{
	foreach($array as $member){
		$sql = "SELECT UserID FROM Users WHERE username = :username;";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':username', $array[$count], SQLITE3_TEXT);
		$results = $stmt->execute()->fetchArray();
		$userId = $results['UserID'];
		$count = $count + 1;
	
		$sql="INSERT INTO Users_Groups VALUES(:userid , :groupid);";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':userid', $userId, SQLITE3_INTEGER);
		$stmt->bindValue(':groupid', $groupId, SQLITE3_INTEGER);
		$stmt->execute();
	}
}

$sql="INSERT INTO Users_Groups VALUES(:id, :groupid);";
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $_SESSION['id'], SQLITE3_INTEGER);
$stmt->bindValue(':groupid', $groupId, SQLITE3_INTEGER);
$stmt->execute();
?>