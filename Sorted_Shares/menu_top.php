<div class="menu_top">
	<?php ini_set('display_errors', '1');?>
	<a href='index.php'>
		<img src="icons/logo(black).png" class="logoImg">
		<h1 class="logoText">Sorted Shares</h1>
	</a>
	<?php
	$sql = "SELECT * FROM Users WHERE UserID = :id ;";
	$stmt = $GLOBALS['db']->prepare($sql);
	$stmt->bindValue(':id', $_SESSION['id'], SQLITE3_INTEGER);
	$items = $stmt->execute()->fetchArray();
	?>
	<img src='icons/expandM(black).png' class="dropbtn dropImg" onclick="myFunction()" >
	<div class="dropdown">
		<div onclick="myFunction()" class="dropbtn">
			<?php echo htmlspecialchars($items['username'], ENT_QUOTES, 'utf-8');?>
				
		</div>
	</div>
	<div id="myDropdown" class="dropdown-content">
		<a href="changePassword.php">Change Password</a>
		<a href="profilePic.php">Add/Change Profile Picture</a>
		<a href="newColor.php">Change Background Colour</a>
		<a href="paypalLink.php">Link PayPal.Me</a>
			<?php
			if($_SESSION['link'] != null){
				echo "<img src = 'icons/paypal.png' class='addImage profileImg' id='createGroupsImage' style='height:auto;width:4vw;display:inline-block; position:absolute;bottom:1vw;right:0;z-index:100;'>";        
			} 
			?>
		<a href="logout.php">Logout</a>
	</div>
	<?php
	echo "<img src='profilePictures/".$items['profileLink']."' class='dropbtn profileImg' style='width:2.6vw' onclick='myFunction()' >";
	?>
    
	<div class="tooltip dropbtn dropImg" style="height:100%;display:inline-block;float:right;">
		<a href='help.php'>
			<img src = "icons/help(black).png" class="addImage profileImg" id="createGroupsImage" style="height:auto;width:100%;">
		</a>
		<span class="tooltiptext">Help Page</span>
	</div>

</div>
			
<script>
	function myFunction() {
		document.getElementById("myDropdown").classList.toggle("show");
	}
	// Close the dropdown if the user clicks outside of it
	window.onclick = function(event) {
		if (!event.target.matches('.dropbtn')) {
			var dropdowns = document.getElementsByClassName("dropdown-content");
			var i;
			for (i = 0; i < dropdowns.length; i++) {
				var openDropdown = dropdowns[i];
				if (openDropdown.classList.contains('show')) {
					openDropdown.classList.remove('show');
				}
			}
		}
	}
	</script>
	
