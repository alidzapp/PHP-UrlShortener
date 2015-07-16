<?php
	// Script to show the analysis for @author edel

	// autoload the database class so we can easily connect to the database as required.
	function __autoload($class_name) {
		require $class_name . '.php';
	}

	$datab = new DataBaseConnection();
	$datab->connectSelect();


	// Store the Link id from the Get parameter
	$linkId = $_GET["analyse"];
	
	
	// Get the shortlink and the url for this id from the link table
	$sql = "SELECT * FROM link WHERE id=" . $linkId;
	$result = mysqli_query($datab->link,$sql);
	
	// Check if the query didn't run
	if(!result){
		echo "Database error" . mysql_errno($datab->link);
		die();
	
	}else {
			
		// id will be in table so no need to check
		$row = mysqli_fetch_assoc($result);
	
		// Store the id and the shortLink
		$shortLink = $row["shortlink"];
		$url = $row["url"];
	}
	
	
	// Get the number of users that have this link
	$sql = "SELECT COUNT(*) AS userTotal FROM userlink WHERE linkId=" . $linkId;
	$result = mysqli_query($datab->link,$sql);
	$total = mysqli_fetch_assoc($result);
	$linkUsers = $total['userTotal'];
	
	// Check if the query didn't run
	if(!$result){
		echo "Database error" . mysql_errno($datab->link);
		die();			
	}


	// Get the number of times that this link was used
	$sql = "SELECT COUNT(*) AS usedTotal FROM logs WHERE linkId=" . $linkId;
	$result = mysqli_query($datab->link,$sql);
	$total = mysqli_fetch_assoc($result);
	$linkUses = $total['usedTotal'];
	
	// Check if the query didn't run
	if(!$result){
		echo "Database error" . mysql_errno($datab->link);
		die();
	}


	// Get the latest date that this link was used on
	$sql = "SELECT MAX(timestamp) AS lastdate FROM logs WHERE linkId=" . $linkId;
	$result = mysqli_query($datab->link,$sql);
	$res = mysqli_fetch_assoc($result);
	$linkLast = $res['lastdate'];
	$linkLast = substr($linkLast, 8, 2) . " - " . substr($linkLast, 5, 2) . " - " . substr($linkLast, 0, 4);
	
	// Check if the query didn't run
	if(!$result){
		echo "Database error" . mysql_errno($datab->link);
		die();
	}


	// Get the logs for this link and put them in a variable called $logsList
	$sql = "SELECT * FROM logs WHERE linkId=" . $linkId;
	$logsList = mysqli_query($datab->link,$sql);
		
	// Check if the query didn't run
	if(!$result){
		echo "Database error" . mysql_errno($datab->link);
		die();
	}
	
	
	// I had to re-run the same query as above to get the logs for this link again because when I copied the result set to another variable and looped through it then both result sets were at the bottom of the results.
	// Get the logs for this link and put them in a variable called $listLogs.
	$sql = "SELECT * FROM logs WHERE linkId=" . $linkId;
	$listLogs = mysqli_query($datab->link,$sql);
	
	// Check if the query didn't run
	if(!$result){
		echo "Database error" . mysql_errno($datab->link);
		die();
	}
	
	// Array that will hold the 2hourly values
	$arrayTimes = array("0" => 0, "2"=>0, "4"=>0, "6"=>0, "8"=>0, "10"=>0, "12"=>0, "14"=>0, "16"=>0, "18"=>0, "20"=>0, "22"=>0 );
	 
	// Loop through the $listLogs resultset and update the array
	while($rowLogs = mysqli_fetch_assoc($listLogs)){
		$hour = substr($rowLogs['timestamp'],11,2);
		
		// Increment the appropriate value in the array
		if($hour < 2){
			$arrayTimes["0"]++;
		}else if($hour < 4){
			$arrayTimes["2"]++;
		}else if($hour < 6){
			$arrayTimes["4"]++;
		}else if($hour < 8){
			$arrayTimes["6"]++;
		}else if($hour < 10){
			$arrayTimes["8"]++;
		}else if($hour < 12){
			$arrayTimes["10"]++;
		}else if($hour < 14){
			$arrayTimes["12"]++;
		}else if($hour < 16){
			$arrayTimes["14"]++;
		}else if($hour < 18){
			$arrayTimes["16"]++;
		}else if($hour < 20){
			$arrayTimes["18"]++;
		}else if($hour < 22){
			$arrayTimes["20"]++;
		}else if($hour < 24){
			$arrayTimes["22"]++;
		}
	}
	
	
	// Get the 10 cities that have used the link the most. 
	$sql = "SELECT linkId, city, COUNT(*) AS total FROM logs GROUP BY city HAVING linkId=" . $linkId . " ORDER BY total DESC, city ASC LIMIT 10";
	$result = mysqli_query($datab->link,$sql);
	
	// Check if the query didn't run
	if(!$result){
		echo "Database error" . mysql_errno($datab->link);
		die();
	}
	
	// Arrays that will hold the city names and their percentages (calculated using the $linkUses variable)
	$arrayCityNames = array();
	$arrayCityPercents = array();
	$cityCount = 0;
	$percentUsed = 0;
	
	// Loop through the $listLogs resultset and add to both the arrays
	while($rowLogs = mysqli_fetch_assoc($result)){
		$cityCount++;
		array_push($arrayCityNames, $rowLogs["city"]);
		$percent = round( ($rowLogs["total"] / $linkUses) * 100, 2);
		array_push($arrayCityPercents, $percent);
		$percentUsed += $percent; 
	}

	// If there are others cities that are not included then add an "Others" element with their combined % for the graph
	if($percentUsed < 99) {
		array_push($arrayCityNames, "Others");
		array_push($arrayCityPercents, 100-$percentUsed);
	}
	
	
	// Get the 10 countries that have used the link the most.
	$sql = "SELECT linkId, country, COUNT(*) AS total FROM logs GROUP BY country HAVING linkId=" . $linkId . " ORDER BY total DESC, country ASC LIMIT 10";
	$result = mysqli_query($datab->link,$sql);
	
	// Check if the query didn't run
	if(!$result){
		echo "Database error" . mysql_errno($datab->link);
		die();
	}
	
	// Arrays that will hold the country names and their percentages (calculated using the $linkUses variable)
	$arrayCountryNames = array();
	$arrayCountryPercents = array();
	$countryCount = 0;
	$percentUsed = 0;
	
	// Loop through the $listLogs resultset and add to both the arrays
	while($rowLogs = mysqli_fetch_assoc($result)){
		$countryCount++;
		array_push($arrayCountryNames, $rowLogs["country"]);
		$percent = round( ($rowLogs["total"] / $linkUses) * 100, 2);
		array_push($arrayCountryPercents, $percent);
		$percentUsed += $percent;
	}
	
	// If there are others countries that are not included then add an "Others" element with their combined % for the graph
	if($percentUsed < 99) {
		array_push($arrayCountryNames, "Others");
		array_push($arrayCountryPercents, 100-$percentUsed);
	}
	
	
	//If no one has used this link then set the $unused variable to true so we don't show the graphs or the list.
	if($percentUsed==0){
		$unused = true;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Shortly - Admin</title>
	<link rel="stylesheet" href="style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/highcharts-3d.js"></script>
	<script src="http://code.highcharts.com/modules/exporting.js"></script>
</head>
<body>
	<section id="pageAnalysis">
	
		<header>
			<h1>Shortly - the Link Shortener</h1>
		</header>

		<section id="backButton">
			<form action="links.php" method="post">
				<input type="submit" value="BACK"/>
			</form>
		</section>
		
		<section id="headingBox">
		
			<section id="headingBoxLeft">
				ShortLink -<br>
				Full URL -
			</section>
			
			<section id="headingBoxRight">
				<span class="AnalsysisResults"><?php echo "http://www.gcdsrv.com/~s2887759/sswd/urls/a.php?a=" . $shortLink;?><br></span>
				<span class="AnalsysisResults"><?php echo $url;?></span>
			</section>
			
		</section>
		
		<section id="AnalysisUsage">
			
			<section id="AnalysisUsers">
				USERS WITH THIS LINK<br>
				<span class="AnalsysisResults"><?php echo $linkUsers?></span>
			</section>
			
			<section id="AnalysisUses">
				TIMES THIS LINK WAS USED<br>
				<span class="AnalsysisResults"><?php echo $linkUses?></span>
			</section>
			
			<section id="AnalysisLast">
				LAST DATE LINK WAS USED<br>
				<span class="AnalsysisResults"><?php echo $linkLast?></span>
			</section>
			
			<?php
				// If no one has used this link then don't show the graphs or the list.
				if (!$unused){ 
			?>
			
			<!-- Analysis Usage every 2 hours - Bar Chart -->
			<section id="AnalysisHours">
			
				<!-- Load a highcharts 3d bar chart and give it the hourly data Ref: "http://www.highcharts.com/demo/3d-column-null-values"-->
				<script>
					$(function () {
	    				$('#AnalysisHours').highcharts({
	        				chart: {
	            				type: 'column',
	            				margin: 75,
	            	            options3d: {
	            					enabled: true,
	            					alpha: 10,
	                				beta: 25,
	                				depth: 70
	            				}
	        				},
	        				title: {
	        					text: 'Shortlink Usage in two hour divisions'
	        				},
	        				subtitle: {
	        					text: 'Server Time'
	        				},
	        				plotOptions: {
	        					column: {
	        						depth: 25
	        					}
	        				},
	        				xAxis: {
	        					categories: ['00-02', '02-04', '04-06', '06-08', '08-10', '10-12', '12-14', '14-16', '16-18', '18-20', '20-22', '22-00']
	        				},
	        				yAxis: {
	        					title: {
	        						text: 'Number of Times'
	        					}
	        				},
	        				series: [{
	        					name: 'Times Used',
	        					data: [<?php echo $arrayTimes["0"] . ", " . $arrayTimes["2"] . ", " . $arrayTimes["4"] . ", " . $arrayTimes["6"] . ", " . $arrayTimes["8"] . ", " . $arrayTimes["10"] . ", " . $arrayTimes["12"] . ", " . $arrayTimes["14"] . ", " . $arrayTimes["16"] . ", " . $arrayTimes["18"] . ", " . $arrayTimes["20"] . ", " . $arrayTimes["22"] ?>],
	        					showInLegend: false
	        				        					
	        				}]
	        			});
	    			});
				</script>
						
			</section>
			
			
			<!-- Analysis Top 10 cities where the link is being used - Pie Chart -->
			<section id="AnalysisCity">
			
				<!-- Load a highcharts 3d pie bar chart and give it the top city info Ref: "http://www.highcharts.com/demo/3d-pie"-->
				<script>
					$(function () {
	    				$('#AnalysisCity').highcharts({
	        				chart: {
	            				type: 'pie',
	            				options3d:{
	                				enabled: true,
	                				alpha: 45,
	                				beta: 0
	            				}
	        				},
	        				title: {
	            				text: 'Top Shortlink usage by City'
					        },
					        tooltip: {
					            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					        },
					        plotOptions: {
					            pie: {
					                allowPointSelect: true,
					                cursor: 'pointer',
					                depth: 35,
					                dataLabels: {
					                    enabled: true,
					                    format: '{point.name}'
					                }
					            }
					        },
					        series: [{
					            type: 'pie',
					            name: 'Usage share',
					            data: [
							            
							        <?php 
							        	// Slice the biggest/first one
							        	echo "{name: '" . $arrayCityNames[0] . "', y: " . $arrayCityPercents[0] . ", sliced: true, selected: true}";
							        	
							        	// Remove the biggest/first one 
							        	array_shift($arrayCityNames);
							        	array_shift($arrayCityPercents);
							        	
							        	// Loop through both arrays, putting them in the pie chart
							        	$counter = 0;
							        	while ($counter <= count($arrayCityNames)) {
							        		echo ", ['" . $arrayCityNames[$counter] . "', " . $arrayCityPercents[$counter] . "]";
							        		$counter++;
							        	} 
							        ?>
					                
					            ]
					        }]
					    });
					});
				</script>
			</section>
			
			
			<!-- Analysis Top 10 countries where the link is being used - Pie Chart -->						
			<section id="AnalysisCountry">
			
				<!-- Load a highcharts 3d pie bar chart and give it the top country info Ref: "http://www.highcharts.com/demo/3d-pie"-->
				<script>
					$(function () {
	    				$('#AnalysisCountry').highcharts({
	        				chart: {
	            				type: 'pie',
	            				options3d:{
	                				enabled: true,
	                				alpha: 45,
	                				beta: 0
	            				}
	        				},
	        				title: {
	            				text: 'Top Shortlink usage by Country'
					        },
					        tooltip: {
					            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					        },
					        plotOptions: {
					            pie: {
					                allowPointSelect: true,
					                cursor: 'pointer',
					                depth: 35,
					                dataLabels: {
					                    enabled: true,
					                    format: '{point.name}'
					                }
					            }
					        },
					        series: [{
					            type: 'pie',
					            name: 'Usage share',
					            data: [
							            
							        <?php 
							        	// Slice the biggest/first one
							        	echo "{name: '" . $arrayCountryNames[0] . "', y: " . $arrayCountryPercents[0] . ", sliced: true, selected: true}";
							        	
							        	// Remove the biggest/first one 
							        	array_shift($arrayCountryNames);
							        	array_shift($arrayCountryPercents);
							        	
							        	// Loop through both arrays, putting them in the pie chart
							        	$counter = 0;
							        	while ($counter <= count($arrayCountryNames)) {
							        		echo ", ['" . $arrayCountryNames[$counter] . "', " . $arrayCountryPercents[$counter] . "]";
							        		$counter++;
							        	} 
							        ?>
					                
					            ]
					        }]
					    });
					});
				</script>
			</section>
			
			
			<section id="UsesList">
	
				<table>
					
					<tr>
						<th>IP</th>
						<th>Date</th>
						<th>Time</th>
						<th>City</th>
						<th>Country</th>
						<th>Latitude</th>
						<th>Longitude</th>
						<th>Hostname</th>
						<th>Organization</th>
						<th>Map</th>
					</tr>
					
					<?php

						// Output the logs from the $logsList variable into the table
						while($rowLogs = mysqli_fetch_assoc($logsList)){
							
							// Extract the date and time from the timestamp
							$theDate = substr($rowLogs['timestamp'], 8, 2) . " - " . substr($rowLogs['timestamp'], 5, 2) . " - " . substr($rowLogs['timestamp'], 0, 4);
							$theTime = substr($rowLogs['timestamp'], 11);
							echo "<tr>";
								echo "<td>" . $rowLogs['ip'] . "</td>";
								echo "<td>" . $theDate . "</td>";
								echo "<td>" . $theTime . "</td>";
								echo "<td>" . $rowLogs['city'] . "</td>";
								echo "<td>" . $rowLogs['country'] . "</td>";
								echo "<td>" . $rowLogs['latitude'] . "</td>";
								echo "<td>" . $rowLogs['longitude'] . "</td>";
								echo "<td>" . $rowLogs['hostname'] . "</td>";
								echo "<td>" . $rowLogs['organisation'] . "</td>";
								// Make the final table column be a link to a google map of the  ip's lat and long 
								echo "<td>" . "<a href='http://www.gcdsrv.com/~s2887759/sswd/urls/map.php?ip=" . $rowLogs['ip'] . "&lat=" . $rowLogs['latitude'] . "&long=" . $rowLogs['longitude'] . "' . target='_blank'><img src='map-icon-small.png' alt='MAP'</a>" . "</td>";
							echo "</tr>";
						}					
					?>						
									
				</table>
				
			</section>
			
			<?php
				// End of the condition to not show the graphs or the list.
				} 
			?>
			
		</section>
	
		<footer>
			<p>&copy; 2015 Shorty</p>
		</footer>
		
	</section>
		
</body>
</html>