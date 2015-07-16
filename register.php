<?php

	// Registration page that allows users to Registr.
	
	session_start();
	
	// If a person registers then save their details to the session so that it is there when they go back to the login page.
	if(isset($_POST["newUser"])){
		$_SESSION["user"] = $_POST["user"];
		$_SESSION["email"] = $_POST["email"];
	}

	// autoload the database class so we can easily connect to the database as required.
	function __autoload($class_name) {
		require $class_name . '.php';
	}
	
	$datab = new DataBaseConnection();
	$datab->connectSelect();
	
	function checkEntries(&$arr){
			
		// If user length <6 then report as bad
		if(strlen($_POST['user'])<6){
					
			$arr["user"] = "Username must be greater than 6 characters long ";
		
		}
			
		// If pass length <10 or pass has no numbersthen report as bad
		if(strlen($_POST['pass'])<10 ||
			preg_match("/\d/", $_POST['pass'])==0){
				
			$arr["pass"] = "Password must be at least 10 long with one number";
		}
			
		// Check that a valid e-mail was entered, otherwiase report as bad
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				
			$arr["email"] = "You must enter a valid e-mail address";
		}
			
		// If any bad entries then return false, else true.
		if(!empty($arr["user"]) || !empty($arr["pass"]) || !empty($arr["email"])){
			return false;
		} else{
			return true;
		}
			
	}
	

	// Create an array to hold invalid entries for Registration
	$validationArray = array("user" => "", "pass" => "", "email" => "");
	
	// If new user has submitted registration details.
	if(isset ($_POST['newUser'])){
				
		// Check the validity of the entries
		$entryOk = checkEntries($validationArray);
		
		
		//
		$sql = "SELECT * FROM user WHERE username='" . $_POST["user"] . "'" ;
		$result = mysqli_query($datab->link,$sql);
		
		// If the query didn't run then set $queryError.
		if(!result){
			$validationArray["user"] = "Could not query the database, click button to try again";
			
		}else{
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			
			// If the new user's user name is already used..
			if($row!=NULL){
				$validationArray["user"] = "Someone is already using this user, please enter another";
			
			}else{
		
				if($entryOk) {
		
		
					//Check if this user is already in the database
			
					// If fields are validated then encrypt the password and save the new user.
					$pass = md5($_POST['pass']);
		
					$sql =  "INSERT INTO user(username, password, email) VALUES('" . $_POST['user'] . "', '";
					$sql .= $pass . "', '";
					$sql .= $_POST['email'] . "')";
									
					$result = mysqli_query($datab->link,$sql);
	
					// Check if the query didn't run
					if(!result){
						$registrationError = "Could not save to the database!!!";
					}else {
						$registrationSuccess = "Login details e-mailed, please login";
					}
				}
			}
		}
	}
?>




<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Shortly - Registration</title>
	<link rel="stylesheet" href="style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<body>
	<section id="page">
		<header>
			<h1>Shortly - the Link Shortener</h1>
		</header>

		<script>
		
			function errorText(id, txt){
				$(id).html(txt);
				$(id).slideDown("slow");
			}

		</script>
 	
		
		<section id="EntryFormHead">Registration</section>
		
		<!-- This form is for user login -->
		
		<section id="EntryForm">
		
		
			<form action="register.php" method="post">
			
				<section class="EntryFormBox">
					<section class="EntryFormText">Username&nbsp;:&nbsp;&nbsp;&nbsp;</section>
					<section class="EntryFormInput">
						<input type='text' name='user' value='<?php if(isset($_SESSION["user"])) echo $_POST["user"];?>' maxlength="20" />
					</section>
				</section>
				<section id="errorUserEntry"></section>
			
				<section class="EntryFormBox">
					<section class="EntryFormText">Password&nbsp;:&nbsp;&nbsp;&nbsp;</section>
					<section class="EntryFormInput">
						<input type='password' name='pass' value='<?php if(isset($_SESSION["pass"])) echo $_POST["pass"];?>' maxlength="20" />
					</section>	
				</section>
				<section id="errorPassEntry"></section>

 				<section class="EntryFormBox">
					<section class="EntryFormText">E-Mail&nbsp;:&nbsp;&nbsp;&nbsp;</section>
					<section class="EntryFormInput">
						<input type='text' name='email' value='<?php if(isset($_SESSION["email"])) echo $_POST["email"];?>' maxlength="30" />
					</section>
				</section>
				<section id="errorEmailEntry"></section>
		 	
				<section class="EntryFormBox">
					<section id="EntryFormOptions1">
						<input type='submit' name='newUser' value='Register'/>
					</section>	
				
			</form>
			
			<form action="index.php" method="post">
				<section id="EntryFormOptions2">
					<input type='submit' name='loginReg' value='Login'/>
				</section>
				</section>
			</form>
					
			<section id="RegistrationNotice"></section>
			
		</section>
 		
		<?php 
			
			// If invalid user entered
			if($validationArray["user"]!=""){
				echo "<script>errorText('#errorUserEntry','" . $validationArray["user"] . "');</script>";
			}
			
			// If invalid password entered
			if($validationArray["pass"]!=""){
				echo "<script>errorText('#errorPassEntry','" . $validationArray["pass"] . "');</script>";
			}

			// If invalid email entered
			if($validationArray["email"]!=""){
				echo "<script>errorText('#errorEmailEntry','" . $validationArray["email"] . "');</script>";
			}
			
			// Notify the user on a successful registration
			if(isset($registrationSuccess)){
				$emailMessage = "You have successfully registered at Shorty, your username is: " . $_POST["user"] . " and your password is: " . $_POST["pass"] . ".";
				mail($_POST["email"], 'Shorty Registration', $emailMessage);
				echo "<script>errorText('#RegistrationNotice','" . $registrationSuccess . "');</script>";
			}
			
			// Notify the user if we could not save them to the database
			if(isset($registrationError)){
				echo "<script>errorText('#RegistrationNotice','" . $registrationError . "');</script>";
			}
			
		?>
 
		<footer>
			<p>&copy; 2015 Shorty</p>
		</footer>
	</section>
</body>
</html>