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
		<script src='js/newPayment.js'></script>
	</head>
	<?php echo "<body style='background:linear-gradient(to bottom right, ".$_SESSION['color'].")'>";?>
		<div class="screen">
			<?php
				include 'menu_top.php';
				include 'menu_bar.php';
			?>
			<div class="content">
				<h1>New Payment</h1>
					<form class="loginRegister" id='form' action='newPaymentProcessing.php' method='POST'>
						<label>Payment Name</label>
						<input type="text" name="groupName" class="newText">
					<label>Select a Person</label>
					<div class="borderDiv">
						<?php
						$sql = "SELECT * FROM Users INNER JOIN Relations ON Users.UserID = Relations.FriendID WHERE Relations.UserID = :id ;";
                        $stmt = $db->prepare($sql);
                        $stmt->bindValue(':id', $_SESSION['id'], SQLITE3_INTEGER);
						$results = $stmt->execute();
						while(($row = $results->fetchArray())){
							echo "<a href=''><div class='profileDisplay profileSelect'  id='". $row['username'] . "'>";
							echo "<img src='profilePictures/".$row['profileLink']."'  align='middle'><p id='name'>";
							echo $row['fName'] . " " . $row['lName'];
							echo "</p></div></a>";
						}
						?>
						<div class="tooltip" style="float:center;">
		
								<a href='addPeople.php'><img src="icons/add(black).png" style="height:40px;"></a>
						
							<span class="tooltiptext">Add People</span>
						</div>
					</div>
					<label>Amount</label>
					<div class="currencyinput"><div class="symbol">£</div><input type="number" name="amount" id="money" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100"></div>
					<input id="payerID" name='username' type="hidden" value="">
					<input class="button" type="submit" value="Add">
				</form>
			</div>
		</div>
	</body>
</html>
