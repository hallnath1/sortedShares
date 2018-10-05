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
	<script src='js/newColor.js'></script>
</head>
<?php echo "<body style='background:linear-gradient(to bottom right, ".$_SESSION['color'].")'>";?>
	<div class="screen" style="overflow: scroll;">
		<?php
		include 'menu_top.php';
		include 'menu_bar.php';
		?>
		<div class="topTitle">
			<h1 style="display:inline-block; margin:1% 1%;">Profile Picture</h1>
			<div class="tooltip" style="height:100%;display:inline-block;float:right;">
				<a href='index.php'>
					<img src = "icons/exit(black).png"style="height:60px;width:auto;">
				</a>
				<span class="tooltiptext">Exit</span>
			</div>
		</div>
		<div class="content">
			<form class="loginRegister" action="newColorProcessing.php" method="POST">
				<label>Current Theme</label>
                <div class='example' 
                     <?php
                     echo "style='background:linear-gradient(to bottom right, ".$_SESSION['color']."'>";
                         ?>
                         </div>
                <label>Chose New Colours</label><br>
                <input type="color" class='colorInput' name='color1' id='1' list='colors' value="#ffffff">

                <input type="color" class='colorInput' name='color2' id='2' list='colors' value="#ffffff">
                <datalist id="colors">
  <option>#F4D03F</option>
  <option>#58D68D</option>
  <option>#ffffff</option>
  <option>#E74C3C</option>
  <option>#8E44AD</option>
<option>#FF69B4</option>
                    <option>#7FFF00</option>
                    <option>#00ffd7</option>
                    <option>#FF7373</option>
<option>#7373ff</option>
</datalist>
                <br>
                <label>New Theme</label>
                <div class='example' id='new'></div>
                
			<input type="submit" class="button" name="submit" value="Submit">
			</form>
			
				


		</div>
	</div>
</body>
</html>