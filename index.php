<?php 
	// Home Page of the Application where the user can login or register for an account	

	//Connect to the database
	function __autoload($class_name) {
		require $class_name . '.php';
	}
	$datab = new DataBaseConnection();
	$datab->connectSelect();

	// Initial login page that allows users to login .
	
	session_start();
	

/*	// autoload the database class so we can easily connect to the database as required.
	function __autoload($class_name) {
		require $class_name . '.php';
	}*/
	
	$datab = new DataBaseConnection();
	$datab->connectSelect();


	if(isset($_POST['login'])) {

		$sql = "SELECT * FROM user WHERE username='" . $_POST['user'] . "' AND password='" . md5($_POST['pass']) . "'" ;
		$result = mysqli_query($datab->link,$sql);
													
		// If the query didn't run then set $queryError.
		if(!$result){
			$queryError = "Could not query the database, click button to try again";

		}else {
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			
			// If the user/pass entered is not found, set the $queryError.
			if($row==NULL){
				$queryError = 'Incorrect Username or Password, click button to try again';
			
			}else{
				// Set the id, user and pass session variables
				$_SESSION["userID"] = $row["id"];
				$_SESSION["user"] = $_POST["user"];
				$loginSuccess = "Hello " . $_SESSION['user'] . ", click the proceed button to view your links.";
			}
		}
		
	}
	
	if(isset($_GET['logout'])) {
		
			// Destroy the Session and clear all variables
			session_destroy();
			unset($_SESSION["userID"]);
			unset($_SESSION["user"]);
			unset($_SESSION["email"]);
			
	}
	

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Shortly - Login</title>
	<link rel="stylesheet" href="style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<body>
	<section id="page">
		<header>
			<h1>Shortly - the Link Shortener</h1>
		</header>
		
		<!--  Define the jquery functions -->
		<script>
		
			function showText(id, txt){
				$(id).html(txt);
				$(id).slideDown("slow");
			}

			function hideDiv(id){
				$(id).slideUp();
			}

			function showDiv(id){
				$(id).slideDown("slow");
			}

		</script>
		
		<!-- This form is for handling the register button. -->
		<form id="regButton" action='register.php' method='post'>
			<input type='submit' name='register' value='Register'/>
		</form>
			
		<section id="EntryFormHead">Login</section>
		
		<!-- This form is for user login -->
		<section id="EntryForm">

			<form action="index.php" method="post">
			
				<section class="EntryFormBox">
					<section class="EntryFormText">Username&nbsp;:&nbsp;&nbsp;&nbsp;</section>
					<section id="EntryFormInput">
						<input type='text' name='user' value='<?php if(isset($_SESSION["user"])) echo $_SESSION["user"];?>' /><br><br>
					</section>
				</section>	
				
				<section class="EntryFormBox">
					<section class="EntryFormText">Password&nbsp;:&nbsp;&nbsp;&nbsp;</section>
					<section id="EntryFormInput">
						<input type='password' name='pass' /><br><br>
					</section>
				</section>
				
				<section class="EntryFormBox">
					<section id="EntryFormOptions">
						<input type='submit' name='login' value='Login'/>
					</section>
				</section>
			</form>
		</section>
		
		<section id="LoggedIn">
			<section id="LoggedInText"></section>
			
			<section id="LoggedInLinkButton">

				<!-- If administrator has logged in -->
				<?php if($_POST["user"]=="administrator"){?>
				
					<form action="admin.php" method="get">
						<input type="submit" name="getLinks" value="Proceed"/>
					</form>
						
				<!-- If administrator has logged in -->
				<?php } else{?>
				
					<form action="links.php" method="get">
						<input type="submit" name="getLinks" value="Proceed"/>
					</form>
					
				<?php } ?>
			
			</section>
			
			<section id="LoggedInBackButton">
			
				<form action="index.php" method="get">
					<input type="submit" name="backToIndex" value="Back"/>
				</form>
				
			</section>
		</section>
		
		<?php

			//  Logged in so show the proceed to links form and hide the register button.
			if(isset($loginSuccess)){
				echo "<script>hideDiv('#regButton');</script>";
				echo "<script>hideDiv('#EntryForm');</script>";
				echo "<script>showDiv('#LoggedIn');</script>";
				echo "<script>showText('#LoggedInText','" . $loginSuccess . "');</script>";
				echo "<script>showDiv('#LoggedInLinkButton');</script>";
			}
			
			// Unable to login, show error and back button
			if(isset($queryError)){
				echo "<script>hideDiv('#EntryForm');</script>";
				echo "<script>showDiv('#LoggedIn');</script>";
				echo "<script>showText('#LoggedInText','" . $queryError . "');</script>";
				echo "<script>showDiv('#LoggedInBackButton');</script>";
			}
		?>
		
		<footer>
			<p>&copy; 2015 Shorty</p>
		</footer>
	</section>
</body>
</html>