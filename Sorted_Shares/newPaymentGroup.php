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
	<script src='js/newPaymentGroup.js'></script>
</head>
<?php echo "<body style='background:linear-gradient(to bottom right, ".$_SESSION['color'].")'>";?>
	<div class="screen" style="overflow: scroll;">
		<?php
		include 'menu_top.php';
		include 'menu_bar.php';
		?>
		<div class="content">
			<?php
			$sql = "SELECT * FROM Groups WHERE GroupID = :id ;";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id'. $_GET['id'], SQLITE3_INTEGER);
			$results = $stmt->execute()->fetchArray();
			echo "<h1>New Payment for " . $results['name'] . "</h1>";
				?>
			<form class="loginRegister" id='form' action='newPaymentGroupProcessing.php' method="POST">
				<label>Payment Name</label>
				<input type="text" name="paymentName" class="newText">
				<label>Amount</label>
				<div class='currencyinput'><div class='symbol'>£</div><input type="number" name="amount" id="money" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100"></div>
				
				<label>Select People</label>
				<div class="borderDiv">
					<?php
					$sql = "SELECT * FROM Users INNER JOIN Users_Groups ON Users.UserID = Users_Groups.UserID WHERE Users_Groups.GroupID = :id ;";
					$stmt = $db->prepare($sql);
                    $stmt->bindValue(':id', $_GET['id'], SQLITE3_INTEGER);
                    $results = $stmt->execute();
					$count = 0;
					while(($row = $results->fetchArray())){
						
							echo "<a href=''><div class='profileDisplay profileSelect' id='". $row['UserID'] . "' style='border:3px solid limeGreen;opacity:1;'>";
							echo "<img src='profilePictures/".$row['profileLink']."'  align='middle'><p id='name'>";
							echo $row['fName'] . " " . $row['lName'];
							echo "</p></div></a>";
							$count += 1;
						
					}
					?>
					<div class="tooltip" style="float:center;">
		
							<a href='addPeople.php'><img src="icons/add(black).png" style="height:40px;"></a>
						
						<span class="tooltiptext">Add People</span>
					</div>
				</div>
				<h4>Split?</h4>
				<table id='people' style='width:100%;'>
					<?php
					$results->reset();
					while(($row = $results->fetchArray())){
							echo "<tr class='person' id='" . $row['UserID'] . "'>";
							echo "<th style='width:10%;'><img src='profilePictures/".$row['profileLink']."' align='middle' style='height:auto;width:3vw;display:inline-block;margin:auto;'><p id='name'></th>";
							echo "<th style='width:10%;'><p style='display:inline-block;'>" . $row['fName'] . " " . $row['lName'] . "</p></th>";
							echo "<th style='width:40%;'><div class='currencyinput'><div class='symbol'>%</div><input class='percentSplit' type='number' value='" . (100/$count) . "' min='0' step='0.01' data-number-to-fixed='2' data-number-stepfactor='100'></div></th>";
							echo "<th style='width:40%;'><div class='currencyinput'><div class='symbol'>£</div><input class='amountSplit' name='" . $row['UserID'] . "' type='number' value='0.00' min='0' step='0.01' data-number-to-fixed='2' data-number-stepfactor='100'></div></th>";
							echo "</tr>";
					
					}
					?>
				</table>
				<div id="alertDiv"></div>
				<input class="button" type="submit" value="Add" id="button">
			</form>
				


		</div>
	</div>
</body>
</html>
