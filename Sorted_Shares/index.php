<?php
session_start();
if(!isset($_SESSION['id'])){
	header('Location: login.php');
}
require 'database.php';
$db = new Database();
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
			<h1 style="display:inline-block; margin:1% 1%;">Your Payments</h1>
		
			<div class="tooltip" style="height:100%;display:inline-block;float:right;">
				<a href='newPayment.php'>
					<img src = "icons/bill(black).png" class="addImage" id="createGroupsImage" style="height:auto;width:25%; margin-right:1vw;">
				</a>
				<span class="tooltiptext">New Single Payment</span>
			</div>
			
		</div>
		
		<div class="content">
			<div class="paySummary">
				
				<?php
				$UserID = $_SESSION['id'];
				$sql = "SELECT * FROM Bills WHERE UserID = :id OR PayeeID = :id ;";
				$stmt = $db->prepare($sql);
				$stmt->bindValue(':id', $UserID, SQLITE3_INTEGER);
				$results = $stmt->execute();
				$difference = 0;
				while($row = $results->fetchArray()){
                    if($row['status'] == 'Awaiting Payment'){
                        if($row['UserID'] == $UserID){
                            $difference = $difference + $row['amount'];
                        }
                        else{
                            $difference = $difference - $row['amount'];
                        }
                    }
				}
				$difference = $difference/100;
					
				if ($difference > 0){
					$difference = abs($difference);
					echo "<h1 style='margin-bottom:1.5%' class='difDisplay' id=".number_format($difference, 2, '.', '').">+ £" . number_format($difference, 2, '.', ' '); 
				}
				else if ($difference < 0){
					echo "<h1 style='margin-bottom:1.5%' class='difDisplay' id=-".number_format(-$difference, 2, '.', '').">- £" . number_format(-$difference, 2, '.', ' '); 
				}
				else{
					echo "<h1 style='margin-bottom:1.5%' class='difDisplay' id='0'>+ £0.00"; 
				}
				?>
			</h1>
			<div class='barBase' >
				<?php echo"<div class='redBar'></div>"?>
				
			</div>
			<?php
			$arraySummary = array();
			$results->reset();
			while($row = $results->fetchArray()){
				$altered = 0;
				foreach($arraySummary as $key => $userData){
					  
                            if($userData[0] == $row['UserID']){
                                if($row['status'] == 'Awaiting Payment'){
						        $arraySummary[$key][1] -= $row['amount'];
                                }
                                $altered = 1;
                            }
					       else if ($userData[0] == $row['PayeeID']){
                               if($row['status'] == 'Awaiting Payment'){
                                $arraySummary[$key][1] += $row['amount'];
                               }
                                $altered = 1;
					       }
                      
				}
				if($altered == 0){
					if($row['UserID'] == $UserID){
                        if($row['status'] == 'Awaiting Payment'){
						    array_push($arraySummary, array($row['PayeeID'], $row['amount']));
                        }
                        else if($row['status']=='Pending'){
                            array_push($arraySummary, array($row['PayeeID'], 0));
                        }
                        else if($row['status']=='Payment Pending'){
                            array_push($arraySummary, array($row['PayeeID'], 0));
                        }
					}
					else{
                        if($row['status'] == 'Awaiting Payment'){
						    array_push($arraySummary, array($row['UserID'], -$row['amount']));
                        }
                        else if($row['status']=='Pending'){
                            array_push($arraySummary, array($row['UserID'], 0));
                        }
                        else if($row['status']=='Payment Pending'){
                            array_push($arraySummary, array($row['UserID'], 0));
                        }
					}
				}
			}
				
			?>
					 
			<h2>+ Owed</h2>
			<table>
				<?php
				foreach($arraySummary as $userData){
					if($userData[1] >= 0){	
						$sql = "SELECT * FROM USERS WHERE UserID = :id;";
						$stmt = $db->prepare($sql);
						$stmt->bindValue(':id', $userData[0], SQLITE3_INTEGER);
						$person = $stmt->execute()->fetchArray();
						echo "
							<tr>
						<th style='width:10%'><img src='profilePictures/".$person['profileLink']."' style='height:auto;width:60%;'> </th>
						<th style='width:30%'>" . $person['fName'] . " " . $person['lName'] . "</th>
						<th class='amountDisplay' id=".number_format(($userData[1]/100), 2, '.', '')." style='width:30%;color:#52ff52;'>";
                        if($userData[1] == 0){
                            echo "£0";
                        }
                        else{
                            echo "+ £" . number_format(($userData[1]/100), 2, '.', ' '); 
                        }
                        echo "</th>
						<th style='width:15%;'> <div class='tooltip' style='height:100%;display:inline-block;'>
						<img class='expandClick' id=".$person['UserID']." src='icons/expandM(black).png' style='height:50px;width:auto;cursor:pointer;'>
						<span class='tooltiptext'>Expand</span>
						</div></th>
						<th style='width:15%;'>								
						<div class='tooltip' style='height:100%;display:inline-block;'>
						<a href='alertSend.php?id=" . $person['UserID'] . "&amount=" . $userData[1]. "'><img src='icons/alert(black).png' style='height:50px;width:auto;'></a>
						<span class='tooltiptext'>Send an alert</span>
						</div>
						</th>
						</tr>";
						echo "<tr class='extraInfo' id=".$person['UserID']."><th colspan='5'><hr><table>
						";
						$sql = "SELECT * FROM Bills WHERE (UserID = :userid AND PayeeID = :payeeid ) OR (UserID = :payeeid AND PayeeID = :userid );";
						$stmt = $db->prepare($sql);
						$stmt->bindValue(':userid', $UserID, SQLITE3_INTEGER);
						$stmt->bindValue(':payeeid', $person['UserID'], SQLITE3_INTEGER);
						$cross = $stmt->execute();
						while(($part = $cross->fetchArray())){
							if($part['UserID']==$UserID){
                                if($part['status']=='Pending'){
								    echo"<tr class='extraRows'><th style='width:33%'>".$part['title']."</th><th style='width:33%;color:#243065;'>+£".($part['amount']/100)."</th><th style='width:33%'>".$part['status']."</th></tr>";
                                }
                                else if($part['status']=='Payment Pending'){
								    echo"<tr class='extraRows'><th style='width:33%'>".$part['title']."</th><th style='width:33%;color:#243065;'>+£".($part['amount']/100)."</th><th style='width:33%'>".$part['status']."</th></tr>";
                                }
                                else if($part['status']=='Awaiting Payment'){
                                    echo"<tr class='extraRows'><th style='width:33%'>".$part['title']."</th><th style='width:33%;color:#52ff52;'>+£".($part['amount']/100)."</th><th style='width:33%'>".$part['status']."</th></tr>";
                                }
							}
						}
						$cross->reset();
						while(($part = $cross->fetchArray())){
							if($part['UserID']==$person['UserID']){
                                if($part['status']=='Pending'){
								    echo"<tr class='extraRows'><th style='width:33%'>".$part['title']."</th><th style='width:33%;color:#243065;'>-£".($part['amount']/100)."</th><th>".$part['status']."</th></tr>";
                                }
                                else if($part['status']=='Payment Pending'){
								    echo"<tr class='extraRows'><th style='width:33%'>".$part['title']."</th><th style='width:33%;color:#243065;'>-£".($part['amount']/100)."</th><th>".$part['status']."</th></tr>";
                                }
                                else if($part['status']=='Awaiting Payment'){
                                    echo"<tr class='extraRows'><th style='width:33%'>".$part['title']."</th><th style='width:33%;color:#ff5050;'>-£".($part['amount']/100)."</th><th>".$part['status']."</th></tr>";
                                }
							}
						}
						echo"</table><hr></th></tr>";
					}
				}
				?>
			</table>
			<h2>- Owe</h2>
			<table>
				<?php
				foreach($arraySummary as $userData){
					if($userData[1] < 0){	
						$sql = "SELECT * FROM USERS WHERE UserID = :id;";
						$stmt = $db->prepare($sql);
						$stmt->bindValue(':id', $userData[0], SQLITE3_INTEGER);
						$person = $stmt->execute()->fetchArray();
						echo "
							<tr>
						<th style='width:10%'><img src='profilePictures/".$person['profileLink']."' style='height:auto;width:60%;'> </th>
						<th style='width:30%'>" . $person['fName'] . " " . $person['lName'] . "</th>
						<th style='color:#ff5050;width:30%'> - £" . number_format(-($userData[1]/100), 2, '.', ' ') . "</th>
						<th style='width:15%'> <div class='tooltip' style='height:100%;display:inline-block;'>
						<img class='expandClick' id=".$person['UserID']." src='icons/expandM(black).png' style='height:50px;width:auto;cursor:pointer;'>
						<span class='tooltiptext'>Expand</span>
						</div></th>
						<th style='width:15%'>
						<div class='tooltip' style='height:100%;display:inline-block;'>
						<a href='paymentOption.php?id=" . $person['UserID'] . "&amount=" . -$userData[1]. "'><img src='icons/money(black).png' style='height:50px;width:auto;'></a>
						<span class='tooltiptext'>Make Payment</span>
						</div>
						</th>
						</tr>";
						echo "<tr class='extraInfo' id=".$person['UserID']."><th colspan='5'><hr><table>
						";
						$sql = "SELECT * FROM Bills WHERE (UserID = :userid AND PayeeID = :payeeid ) OR (UserID = :payeeid AND PayeeID = :userid );";
						$stmt = $db->prepare($sql);
						$stmt->bindValue(':userid', $UserID, SQLITE3_INTEGER);
						$stmt->bindValue(':payeeid', $person['UserID'], SQLITE3_INTEGER);
						$cross = $stmt->execute();
						while(($part = $cross->fetchArray())){
							if($part['UserID']==$UserID){
                                if($part['status']=='Pending'){
								    echo"<tr class='extraRows'><th style='width:33%'>".$part['title']."</th><th style='width:33%;color:#243065;'>+£".($part['amount']/100)."</th><th style='width:33%'>".$part['status']."</th></tr>";
                                }
                                else if($part['status']=='Payment Pending'){
								    echo"<tr class='extraRows'><th style='width:33%'>".$part['title']."</th><th style='width:33%;color:#243065;'>+£".($part['amount']/100)."</th><th style='width:33%'>".$part['status']."</th></tr>";
                                }
                                else if($part['status']=='Awaiting Payment'){
                                    echo"<tr class='extraRows'><th style='width:33%'>".$part['title']."</th><th style='width:33%;color:#52ff52;'>+£".($part['amount']/100)."</th><th style='width:33%'>".$part['status']."</th></tr>";
                                }
							}
						}
						$cross->reset();
						while(($part = $cross->fetchArray())){
							if($part['UserID']==$person['UserID']){
                                if($part['status']=='Pending'){
								    echo"<tr class='extraRows'><th style='width:33%'>".$part['title']."</th><th style='width:33%;color:#243065;'>-£".($part['amount']/100)."</th><th>".$part['status']."</th></tr>";
                                }
                                else if($part['status']=='Payment Pending'){
								    echo"<tr class='extraRows'><th style='width:33%'>".$part['title']."</th><th style='width:33%;color:#243065;'>-£".($part['amount']/100)."</th><th>".$part['status']."</th></tr>";
                                }
                                else if($part['status']=='Awaiting Payment'){
                                    echo"<tr class='extraRows'><th style='width:33%'>".$part['title']."</th><th style='width:33%;color:#ff5050;'>-£".($part['amount']/100)."</th><th>".$part['status']."</th></tr>";
                                }
							}
						}
						echo"</table><hr></th></tr>";
					}
				}
				?>
			</table>
		</div>
	</div>
</div>

</body>
</html>
