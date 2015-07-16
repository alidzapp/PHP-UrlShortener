<?php

	// Page to load a google map of the latitude and longitude that are passed as get parameters
	$lat = $_GET["lat"];
	$long = $_GET["long"];
	$ip = $_GET["ip"];
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $ip . "'s "?>Map</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        height: 95%;
        width: 95%;
        margin: 2em auto;
        padding: 0px;
        background-color:#4E4343;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
    function initialize() {
    	  var myLatlng = new google.maps.LatLng(<?php echo $lat;?>,<?php echo $long;?>);
    	  var mapOptions = {
    	    zoom: 6,
    	    center: myLatlng
    	  }
    	  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    	  var marker = new google.maps.Marker({
    	      position: myLatlng,
    	      map: map,
    	  });
    	}

    	google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>

center: new google.maps.LatLng(<?php echo $lat;?>, <?php echo $long;?>)