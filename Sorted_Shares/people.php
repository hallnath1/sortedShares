<?php
session_start();
if(!isset($_SESSION['id'])){
	header('Location: login.php');
}
require 'database.php';
$db = new Database();
date_default_timezone_set('UTC');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" name="viewport" content="width=device-width">
	<title>Sorted Shares</title>
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
	<link rel="stylesheet" href="style.css" type="text/css" charset="utf-8">
	<script src='js/jquery-3.3.1.min.js'></script>
	<script src='js/index.js'></script>
</head>
<?php echo "<body style='background:linear-gradient(to bottom right, ".$_SESSION['color'].")'>";?>

	<div class="screen" style="overflow: scroll;">
		<?php
		include 'menu_top.php';
		include 'menu_bar.php';
		?>
		<div class="topTitle">
			<h1 style="display:inline-block; margin:1% 1%;">Your People</h1>
		
			<div class="tooltip" style="height:100%;display:inline-block;float:right;">
				<a href='addPeople.php'>
					<img src = "icons/addPeople(black).png" class="addImage" id="createGroupsImage" style="height:auto;width:5vw;">
				</a>
				<span class="tooltiptext">Add People</span>
			</div>
			
		</div>
		
		<div class="content">
			
			<?php
            $UserID = $_SESSION['id'];
            
            $sql="SELECT * FROM Relations WHERE UserID=:userid;"; 
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':userid', $UserID, SQLITE3_INTEGER);
			$results = $stmt->execute();
            
          
               
            
                 echo "<table style='width:100%;'>";
      
            
           
			while($row = $results->fetchArray()){
                $sql="SELECT * FROM Users WHERE UserID=:userid;"; 
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':userid', $row['FriendID'], SQLITE3_INTEGER);
			    $person = $stmt->execute()->fetchArray();
                
                
                echo "
							<tr>
						<th style='width:10%'><img src='profilePictures/".$person['profileLink']."' style='height:auto;width:60%;'> </th>
						<th style='width:80%'><h2 style='text-align:left;'>" . $person['fName'] . " " . $person['lName'] . "</h2></th>
						<th style='width:10%;'> <div class='tooltip' style='height:100%;display:inline-block;float:right;'>
						<img class='expandClick' id=".$person['UserID']." src='icons/expandM(black).png' style='height:50px;width:auto;cursor:pointer;'>
						<span class='tooltiptext'>Expand</span>
						</div></th>
						
						</tr>";
						echo "<tr class='extraInfo' id=".$person['UserID']."><th colspan='3'><hr><table class='expandInfo'>
						";
						$sql = "SELECT * FROM Bills WHERE (UserID = :userid AND PayeeID = :payeeid ) OR (UserID = :payeeid AND PayeeID = :userid) ORDER BY BillID DESC;";
						$stmt = $db->prepare($sql);
						$stmt->bindValue(':userid', $UserID, SQLITE3_INTEGER);
						$stmt->bindValue(':payeeid', $person['UserID'], SQLITE3_INTEGER);
						$cross = $stmt->execute();
						while(($part = $cross->fetchArray())){
                            $date = new DateTime($part['createdDate']);
                            $date = $date->format('d/m/Y');
							if($part['UserID']==$UserID){
                                if($part['status']=='Awaiting Payment'){
                                    echo"<tr class='extraRows'><th style='width:25%'><h2>".$date."</h2></th><th style='width:25%'><h2>".$part['title']."</h2></th><th style='color:#52ff52;width:25%'><h2>+£".($part['amount']/100)."</h2></th><th style='width:25%'><h2>".$part['status']."</h2></th></tr>";
                                }
                                else{
                                    echo"<tr class='extraRows'><th style='width:25%'><h2>".$date."</h2></th><th style='width:25%'><h2>".$part['title']."</h2></th><th style='color:#243065;width:25%'><h2>+£".($part['amount']/100)."</h2></th><th style='width:25%'><h2>".$part['status']."</h2></th></tr>";
                                }
							}
						}
						$cross->reset();
						while(($part = $cross->fetchArray())){
							if($part['UserID']==$person['UserID']){
                                if($part['status']=='Awaiting Payment'){
                                    echo"<tr class='extraRows'><th style='width:25%'><h2>".$date."</h2></th><th style='width:25%'><h2>".$part['title']."</h2></th><th style='color:#ff5050;width:25%'><h2>-£".($part['amount']/100)."</h2></th><th style='width:25%'><h2>".$part['status']."</h2></th></tr>";
                                }
                                else{
                                    echo"<tr class='extraRows'><th style='width:25%'><h2>".$date."</h2></th><th style='width:25%'><h2>".$part['title']."</h2></th><th style='color:#243065;width:25%'><h2>-£".($part['amount']/100)."</h2></th><th style='width:25%'><h2>".$part['status']."</h2></th></tr>";
                                }
							}
						}
						echo"</table><hr></th></tr>";
			}
            echo "</table>";
				
			?>
	</div>
</div>

</body>
</html>
