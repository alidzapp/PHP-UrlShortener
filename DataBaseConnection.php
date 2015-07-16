<?php

	// Script to handle the database connections.
	
	class DataBaseConnection{
		
		var $link;
		
		//Function to create the link to our databases and select the shortly database. 
		function connectSelect(){

			$this->link = mysqli_connect("localhost", "root", "mysql", "shorty");
			 
			// If we couldn't connect to the Database
			if (mysqli_connect_errno()){
				echo "Could not connect: " . mysqli_connect_errno();
				die();
				
			}
	
		}
	}
?>