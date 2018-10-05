<?php

function cropThis($target_url) {
	$image = imagecreatefromjpeg($target_url);
	$filename = $target_url;
	$width = imagesx($image);
	$height = imagesy($image);

	if($width==$height) {
		$thumb_width = $width;
		$thumb_height = $height;
	} 
	elseif($width<$height) {
		$thumb_width = $width;
		$thumb_height = $width;
	} 
	elseif($width>$height) {
		$thumb_width = $height;
		$thumb_height = $height;
	} 
	else {
		$thumb_width = 150;
		$thumb_height = 150;
	}

	$original_aspect = $width / $height;
	$thumb_aspect = $thumb_width / $thumb_height;

	if ( $original_aspect >= $thumb_aspect ) {
		$new_height = $thumb_height;
		$new_width = $width / ($height / $thumb_height);

	}
	else {
		$new_width = $thumb_width;
		$new_height = $height / ($width / $thumb_width);
		$kaboom = explode(".", $fileName);
	}

	$thumb = imagecreatetruecolor($thumb_width, $thumb_height);

	// Resize and crop
	imagecopyresampled($thumb, $image,	0 - ($new_width - $thumb_width) / 2, 0 - ($new_height - $thumb_height) / 2,	0, 0, $new_width, $new_height,$width, $height);
	imagejpeg($thumb, $filename, 10);
}

session_start();
if(!isset($_SESSION['id'])){
	header('Location: login.php');
}
require 'database.php';
$db = new Database();

$id = $_SESSION['id'];

if ($_FILES["image"]["error"] > 0){
	echo "Error: " . $_FILES["image"]["error"] . "<br />";
	header('Location: profilePic.php');
}	
else
{
	if($_FILES["image"]["type"] == 'image/jpeg'){
        
        $sql = "SELECT * FROM Users WHERE UserID = :id ;";
        $stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $_SESSION['id'], SQLITE3_INTEGER);
		$items = $stmt->execute()->fetchArray();
		if($items['profileLink'] != 'temp.png'){
			unlink('profilePictures/'.$items['profileLink']);
		}
		$fileName = $_FILES["image"]["name"];
		$fileType = $_FILES["image"]["type"];
		$fileSize = $_FILES["image"]["size"];
		$fileTempLocation = $_FILES["image"]["tmp_name"];
		
		cropThis($fileTempLocation);
		
		$kaboom = explode(".", $fileName);
		$fileExt = end($kaboom);
        $db_file_name = rand(0,9999) . "." . $fileExt;
		$sql = "UPDATE Users SET profileLink = '".$db_file_name."' WHERE UserID = " . $id . ";";
		$db->exec($sql);
		$moveResult = move_uploaded_file($fileTempLocation, "./profilePictures/" . $db_file_name);
	}
	else{
		header('Location: profilePic.php');
	}
}
header('Location: index.php');
?>