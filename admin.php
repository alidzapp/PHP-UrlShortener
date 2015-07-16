<!-- Script for extending table of short IDs -->

<?php

	// Administrator Page used to extend the Link characters used.

	// autoload the database class so we can easily connect to the database as required.
	function __autoload($class_name) {
		require $class_name . '.php';
	}

	$datab = new DataBaseConnection();
	$datab->connectSelect();
	
	// Array to hold the characters for the algorithm 
	$arr = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v",
			"w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S",
			"T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9");
	
	// Array to hold number of possible links per characters in the shortlink
	$arrLinks = array(1 => 62,2 => 3906,3 => 242234, 4 => 15018570);
	
		

	// Function to calculate the quantities to be displayed.
	function calculateQuantities($datab, $arrLinks, &$linksTotal, &$linksAvailable, &$linksTotal, &$linksUsed, &$linksNextExtend){
	
		// Get the max link from the link table, this is the number of links in the database.
		$sql = "SELECT max(id) FROM link";
		$result = mysqli_query($datab->link,$sql);
	
	
		// Check if the query didn't run
		if(!$result){
			echo "Could not create new link, database error" . mysql_error();
			die();

		}else {
			$row = mysqli_fetch_array($result, MYSQLI_NUM);
			$linksUsed =  $row[0];
		}


		// Find the available links by getting the max id from the linklookup table and taking the used links away from it.
		$sql = "SELECT max(id) FROM linklookup";
		$result = mysqli_query($datab->link,$sql);

		// Check if the query didn't run
		if(!$result){
			echo "Could not create new link, database error" . mysql_error();
			die();

		}else {
			$row = mysqli_fetch_array($result, MYSQLI_NUM);
			$linksTotal = $row[0];
			$linksAvailable =  $linksTotal - $linksUsed;
		}

	
		// Find the new available links by getting the next total links qty from the $arrLinks array and taking away the currently used links qty.
		$nextkey = array_search($linksTotal, $arrLinks);
		$nextkey++;
		$linksNextExtend = $arrLinks[$nextkey] - $linksUsed;
	}
	
	// Calculate the quantities (we need the linksTotal is the extend button was pressed)
	calculateQuantities($datab, $arrLinks, $linksTotal, $linksAvailable, $linksTotal, $linksUsed, $linksNextExtend);

	
	// If the extend button has been pressed
	if(isset($_GET['extend'])){
		
		$counter = 1;

		switch($linksTotal) {
			
			// There are 0 links in linklookup table so extend to 62
			case 0:

				// Loop for one character short url
				while ($counter<=62) {
					$short = $arr[$counter-1];

					// Save the shortlink to the linklookup table.
					$sql  =  "INSERT INTO linklookup (shortLink) VALUES('" . $short . "')";
				
					$result = mysqli_query($datab->link,$sql);
						
					// Check that the query ran ok
					if(!$result){
						echo 'Problem inserting into database: ' . mysql_error();
						die();
					}
				
					$counter++;
				}
				break;

				
			// There are 62 links in linklookup table so extend to 3906 i.e 3844 more
			case 62:

				// Loop for two character short url
				// 62+(62*62) = 3906

				$q = 1;
				$r = 1;	

				while ($counter<=3844) {
					$short = $arr[$q-1] . $arr[$r-1];

					// Save the shortlink to the linklookup table.
					$sql  =  "INSERT INTO linklookup (shortLink) VALUES('" . $short . "')";
				
					$result = mysqli_query($datab->link,$sql);
				
					// Check that the query ran ok
					if(!$result){
						echo 'Problem inserting into database: ' . mysql_error();
						die();
					}
		
					// If the rightmost character can be incremented
					if($r+1 <= 62) {
						$r++;
					}
		
					// Increment the first character and set the second character to 1 
					else {
						$q++;
						$r = 1;
					}
		
					$counter++;
				}
				break;

	
			// There are 3906 links in linklookup table so extend to 242234 i.e 238328 more
			case 3906:

				// Loop for three character short url
				// 62+(62*62)+(62*62*62) = 242234

				$q = 1;
				$r = 1;
				$s = 1;
	
				while ($counter<=238328) {
					$short = $arr[$q-1] . $arr[$r-1] . $arr[$s-1];

					// Save the shortlink to the linklookup table.
					$sql  =  "INSERT INTO linklookup (shortLink) VALUES('" . $short . "')";
				
					$result = mysqli_query($datab->link,$sql);
				
					// Check that the query ran ok
					if(!$result){
						echo 'Problem inserting into database: ' . mysql_error();
						die();
					}
	
					// If the rightmost character can be incremented
					if($s+1 <= 62) {
						$s++;
					}
	
					else {
			
						// If the second from right character can be incremented
						if($r+1 <= 62) {
							$r++;
							$s = 1;
						}
			
						else {
				
							// Increment the third from right character
							$q++;
							$r = 1;
							$s = 1;
						}
					}
	
					$counter++;
				}
				break;

	
			// There are 242234 links in linklookup table so extend to 15018570 i.e 14776336 more
			case 242234:

				// Loop for four character short url
				// 62+(62*62)+(62*62*62)+(62*62*62*62) = 15018570
	
				$counter = 242234;
				$q = 1;
				$r = 1;
				$s = 1;
				$t = 1;
	
				while ($counter<=14776336) {
					$short = $arr[$q-1] . $arr[$r-1] . $arr[$s-1] . $arr[$t-1];

					// Save the link to the linklookup table.
					$sql  =  "INSERT INTO linklookup (shortLink) VALUES('" . $short . "')";
				
					$result = mysqli_query($datab->link,$sql);
				
					// Check that the query ran ok
					if(!$result){
						echo 'Problem inserting into database: ' . mysql_error();
					}
		
					// If the rightmost character can be incremented
					if($t+1 <= 62) {
						$t++;
					}
	
					else {
				
						// If the second from right character can be incremented
						if($s+1 <= 62) {
							$s++;
							$t = 1;
						}
				
						else {
		
							// If the third from right character can be incremented
							if($r+1 <= 62) {
								$r++;
								$s = 1;
								$t = 1;
							}
				
							else {
					
								// Increment the fourth from right character
								$q++;
								$r = 1;
								$s = 1;
								$t = 1;
							}
						}
					}
	
					$counter++;
				}
				break;
		}
		
	}
	
	
	// Calculate the quantities to be displayed.
	calculateQuantities($datab, $arrLinks, $linksTotal, $linksAvailable, $linksTotal, $linksUsed, $linksNextExtend);
	
	
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Shortly - Admin</title>
	<link rel="stylesheet" href="style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<body>
	<section id="pageAdmin">
		<header>
			<h1>Shortly - the Link Shortener</h1>
		</header>
		
		<section id="pageHead">
			Welcome Administrator
		</section>
		
		<section id="AdminUsedBox">
			<section class="AdminBoxText">
				Links Used
			</section>
			<section class="AdminBoxQty">
				<input type="text" value="<?php echo $linksUsed;?>" readonly />
			</section>
		</section>
		
		<section id="AdminAvailableBox">
			<section class="AdminBoxText">
				Links Available
			</section>
			<section class="AdminBoxQty">
				<input type="text" value="<?php echo $linksAvailable;?>" readonly />
			</section>
		</section>
		
		<section id="AdminExtendBox">
			<section class="AdminBoxText">
				Next Extend - Available Links
			</section>
			<section class="AdminBoxQty">
				<input type="text" value="<?php echo $linksNextExtend;?>" readonly />
			</section>
		</section>
		
		<section id="AdminButtons">
		
			<section id="AdminButtonsExtend">
				<form action="admin.php" method="get">
					<input type="submit" name="extend" value="Extend" />
				</form>
			</section>
			
			<section id="AdminButtonsLogout">
				<form action="index.php" method="get">
					<input type="submit" name="logout" value="Logout" />
				</form>
			</section>
			
		</section>
		
	</section>
</body>
</html>