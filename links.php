<?php

	// Page that allows the user to maintain their links and password.
	
	session_start();
	
	// autoload the database class so we can easily connect to the database as required.
	function __autoload($class_name) {
		require $class_name . '.php';
	}

	$datab = new DataBaseConnection();
	$datab->connectSelect();
	
	// Function to check that the password is valid and that they match. 
	function checkEntries(&$arr){
			
		// If pass length <10 or pass has no numbersthen report as bad
		if(strlen($_POST['newPass'])<10 || preg_match("/\d/", $_POST['newPass'])==0){
			$arr["newPass"] = "Password must be at least 10 long with one number";
		}
			
		// Check if the confirm password is the same as the new password
		if($_POST['newPass'] != $_POST['confirmNewPass']){
	
			$arr["confirmPass"] = "New Password and Confirm passwords must match";
		}
		
		// If new password is valid and has been confirmed correctly
		if(!empty($arr["newPass"]) || !empty($arr["confirmNewPass"])){
			return false;
		} else{
			return true;
		}
					
	}


	// Create an array to hold invalid entries for Registration
	$validationArray = array("newPass" => "", "confirmPass" => "", "email" => "");
	
	
	// If the user submitted a password change
	if(isset($_POST['passwordChange'])){
		
		// Check the validity of the entries
		$entryOk = checkEntries($validationArray);

		// New Password has been validated so make the changes to the database and the session variable.
		if($entryOk) {

			// Save the new password to the database
			$sql =  "UPDATE user SET password = '" . md5($_POST['newPass']) . "' WHERE username = '" . $_SESSION['user'] . "'";
			
			$result = mysqli_query($datab->link,$sql);

			// Check that the query ran ok
			if(!$result){
				$savePassMsg = "Could not save, database error";
			
			// If updated then update the Session variables to reflect the changes on the form
			}else{

				// Update the message variable for display to the user.
				$savePassMsg = "Password changed, click BACK to go back to Links";
				
				// Change the session password variable
				$_SESSION["pass"] = $_POST['newPass'];
				
			}

		}
	}
	
	if(isset($_POST["NewURLGetLink"])){
		
		// Need to check first if the URL is already in the link table.
		$sql = "SELECT * FROM link WHERE url='" . $_POST['newURL'] . "' ";
		$result = mysqli_query($datab->link,$sql);
				
		// Check if the query didn't run
		if(!$result){
			$savePassMsg = "Could not create new link, database error";
				
		}else {
					
			// If URL already has a shortlink
			if (!is_null($row = mysqli_fetch_assoc($result))) {
				
				// Store the id and the shortLink
				$thisLink = $row["shortlink"];
				$thisId = $row["id"];
			
				// Before we assign this link to this user we need to check if the user already has this link
				$sql = "SELECT * FROM userlink WHERE userid=" . $_SESSION['userID'] . " AND linkid=" . $thisId;
				$result = mysqli_query($datab->link,$sql);
				
				// Check if the query didn't run
				if(!$result){
					$savePassMsg = "Could not create new link, database error";
				
				}else {
					
					// If shortlink not already assigned to this user
					if (is_null($row = mysqli_fetch_assoc($result))) {		

						// Save the association of the link with the current user.
						$sql =  "INSERT INTO userlink(userId, linkId) VALUES('" . $_SESSION['userID'] . "', '" . $thisId . "')";
				
						$result = mysqli_query($datab->link,$sql);
			
						// Check if the query didn't run
						if(!$result){
							$savePassMsg = "Could not create new link, database error";

						// Link relationship saved so set the $newShorty variable so it can be displayed to the user.
						}else{
							$newShorty = $thisLink;
						}
					
					//User already has this shortlink so just display it as it won't necessarily appear on the top of the links 
					} else {
						$newShorty = $thisLink;
					}
				}
			} else{
		
				// Save the new link to the link table in the database.
				$sql =  "INSERT INTO link(url, uses) VALUES('" . $_POST['newURL'] . "', 0)";
					
				$result = mysqli_query($datab->link,$sql);
		
				// Check if the query didn't run
				if(!$result){
					$savePassMsg = "Could not create new link, database error";
				}
		
				else{
		
					// Get the new links id from the link table
					$sql = "SELECT * FROM link WHERE url='" . $_POST['newURL'] . "' ";
					$result = mysqli_query($datab->link,$sql);
					
					// Check if the query didn't run
					if(!$result){
						$savePassMsg = "Could not create new link, database error";
			
					}else {
						$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
						$linkID = $row["id"];
						
					
						// Find the id in the linklookup table and get the shortLink
						$sql = "SELECT * FROM linklookup WHERE id='" . $linkID . "' " ;
						$result = mysqli_query($datab->link,$sql);
					
						// Check if the query didn't run
						if(!$result){
							$savePassMsg = "Could not create new link, database error";
							
						}else {
							$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
							$newShorty = $row["shortLink"];
					
							// Save the shortid to the link table
							$sql =  "UPDATE link SET shortlink = '" . $newShorty . "' WHERE id = '" . $linkID . "'";
							
							$result = mysqli_query($datab->link,$sql);
					
							// Check that the query ran ok
							if(!$result){
								$savePassMsg = "Could not save, database error";
							
							}else{
						
								// Save the association of this new link with the current user.
								$sql =  "INSERT INTO userlink(userId, linkId) VALUES('" . $_SESSION['userID'] . "', '" . $linkID . "')";
							
								$result = mysqli_query($datab->link,$sql);
						
								// Check if the query didn't run
								if(!$result){
									$savePassMsg = "Could not create new link, database error";
								}
						
								else{ 
						
									// Link saved so go back to the Links list page where the new link will be at the top..
								}
							}
						}
					}
				}
			}
		}
	}
	
	if(isset($_GET["delete"])){
		
		// Delete the record from the userlink table that associates the link with this user.
		$sql =  "DELETE FROM userlink WHERE linkId=" . $_GET['delete'] . " AND userId=" . $_SESSION['userID'];
		$result = mysqli_query($datab->link,$sql);
		// Check if the query didn't run
		if(!$result){
			$savePassMsg = "Could not delete your link, database error";
		}
	}	
	
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Shortly - Links</title>
	<link rel="stylesheet" href="style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<body>
	<section id="pageList">
		<header>
			<h1>Shortly - the Link Shortener</h1>
		</header>
		
		<script>

			function showDiv(id){
				$(id).slideDown("slow");
			}

			function errorText(id, txt){
				$(id).html(txt);
				$(id).slideDown("slow");
			}

			function hideDiv(id){
				$(id).slideUp();
			}

			</script>
		
		
		<section id="pageHead"><?php echo $_SESSION["user"];?></section>
		
		<section id="LinksButtonsBox">
			
			<section class="LinksButton">
				<!-- Bring up the Change Password Box on this page -->
				<form action="links.php" method="get">
					<input type='submit' name='changePass' value='Change Password'/>
				</form>
			</section>
						
			<section class="LinksButton">
				<form action="links.php" method="get">
					<!-- Bring up the Create New Link Box on this page -->
					<input type='submit' name='createNew' value='Create New Link'/>
				</form>
			</section>
			
			<section class="LinksButton">
				<!-- Send the user back to the login page -->
				<form action="index.php" method="get">
					<input type='submit' name='logout' value='Logout'/>
				</form>
			</section>
					
		</section>
		
		<section id="LinksList">
			
			<?php
			
				// Get the Links for this user in reverse order (last entered is first).
				$sql = "SELECT * FROM link WHERE id IN (SELECT linkid FROM userlink WHERE userid=" . $_SESSION['userID'] . ") ORDER BY id DESC";
				$result = mysqli_query($datab->link,$sql);
				
				// Check if the query didn't run
				if(!$result){
					$savePassMsg = "Could not create new link, database error";
						
				}else {
					
					$counter = 1;
					while($rowLinks = mysqli_fetch_assoc($result)){
						  
			?>
			
						<section class="LinksShort"> 
							<input type="text" name="<?php $rowLinks['shortlink'];?>" value="<?php echo "http://www.gcdsrv.com/~s2887759/sswd/urls/a.php?a=" . $rowLinks['shortlink'];?>" size="60" readonly/>
						</section>
						
						<section class="LinksURL">
							<input type="text" name="<?php echo $rowLinks['shortlink'];?>" value="<?php echo $rowLinks['url'];?>" size="100" readonly/>
						</section>
						
						<!-- For the delete link (displayed as a button) recall this page passing the link id to be deleted -->
						<section id="LinksDelete">
							<?php echo "<a href='http://www.gcdsrv.com/~s2887759/sswd/urls/links.php?delete=" . $rowLinks['id'] . "'" ?> >Delete</a>
						</section>
						
						<!-- For the analyse link (displayed as a button) open the analyse page passing the userlink id to be deleted -->
						<section id="LinksAnalyse">
							<?php echo "<a href='http://www.gcdsrv.com/~s2887759/sswd/urls/analyse.php?analyse=" . $rowLinks['id'] . "'" ?> >Analyse</a>
						</section>
			
			<?php
						$counter++;
					}
				} 
			?>
		</section>
		
		<section id="ChangePassForm">
		
			<form action="links.php" method="post">
			
				<section class="EntryFormBox">
					<section class="EntryFormText">New Password&nbsp;:&nbsp;&nbsp;&nbsp;</section>
					<section class="EntryFormInput">
						<input type='password' name='newPass' value='<?php echo $_POST["newPass"];?>' maxlength="20" />
					</section>
				</section>
				<section id="errorNewPass"></section>
				
				<section class="EntryFormBox">
					<section class="EntryFormText">Confirm Password&nbsp;:&nbsp;&nbsp;&nbsp;</section>
					<section class="EntryFormInput">
						<input type='password' name='confirmNewPass' value='<?php echo $_POST["confirmNewPass"];?>' maxlength="20" />
					</section>
				</section>
				<section id="errorConfirmNewPass"></section>
				
				<section id="PasswordChangeOptions">
					<section id="EntryFormOptions1">
							<input type='submit' name='passwordChange' value='Change Password'/>
					</section>	
					<section id="EntryFormOptions2">
						<input type='submit' name='cancelPasswordChange' value='Cancel'/>
					</section>
				</section>
				
				<section id="PasswordChangedOptions">
					<section id="PassChanged"></section>
					<section id="PassChangedBack">	
						<input type='submit' name='BackToLinks' value='Back'/>
					</section>
				</section>
			
			</form>
		
		</section>
			
		<section id="CreateNewForm">

			<form action="links.php" method="post">
			
				<section class="EntryFormBox">
					<section class="URLFormText">URL&nbsp;:&nbsp;&nbsp;&nbsp;</section>
					<section class="URLFormInput">
						<input type='text' name='newURL' size="100" maxlength="150" />
					</section>
				</section>
				 
				<section class="EntryFormBox">
					<section id="EntryFormOptions1">
						<input type='submit' name='NewURLGetLink' value='Create Link'/>
					</section>
					<section id="EntryFormOptions2">
						<input type='submit' name='NewURLCancel' value='Cancel'/>
					</section>
				 
				</section>
				
			</form>
			
		</section>
		
		<section>
		
			<section id="NewShortyForm">
				<section id="NewShortyText"></section>
				<section id="NewShortyOptions">
					<form action="links.php" method="get">
						<input type='submit' name='BackToLinks' value='Back'/>
					</form>
				</section>
			</section>
		
		</section>
		
		<?php

			// If the user wants to change their password or has just changed their password.
			if(isset($_GET['changePass']) || isset($_POST['passwordChange'])){
				echo "<script>showDiv('#ChangePassForm');</script>";
			}
			
			// If invalid new password entered
			if($validationArray["newPass"]!=""){
				echo "<script>errorText('#errorNewPass','" . $validationArray["newPass"] . "');</script>";
			}
			
			// If invalid password confirmation was entered
			if($validationArray["confirmPass"]!=""){
				echo "<script>errorText('#errorConfirmNewPass','" . $validationArray["confirmPass"] . "');</script>";
			}

			// If Changed Password was submitted and was valid
			if(isset($savePassMsg)){
				echo "<script>hideDiv('#PasswordChangeOptions');</script>";
				echo "<script>showDiv('#PasswordChangedOptions');</script>";
				echo "<script>errorText('#PassChanged','" . $savePassMsg . "');</script>";

			}
			
			//If the user wants to create a new link
			if(isset($_GET["createNew"])){
				echo "<script>showDiv('#CreateNewForm');</script>";
			}
			
			if(isset($newShorty)){
				echo "<script>showDiv('#NewShortyForm');</script>";
				echo "<script>errorText('#NewShortyText','Shortlink: http://www.gcdsrv.com/~s2887759/sswd/urls/a.php?a=" . $newShorty . "');</script>";
			}
					
		?>
		
		<footer>
			<p>&copy; 2015 Shorty</p>
		</footer>
	</section>
</body>
</html>