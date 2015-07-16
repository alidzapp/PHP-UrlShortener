<?php
$ip=$_GET["ip"];
$requestURL = "http://gcdsrv.com/~lookup/?ipadr=" . $ip;
$ipMetaDataXML = simplexml_load_file($requestURL);
//Extract info from the location member of the XML object
$hostname = $ipMetaDataXML->hostname;
$city = $ipMetaDataXML->city;
$country = $ipMetaDataXML->country;
$latlong = $ipMetaDataXML->location;
//Split the $latlong into $lat and $long
$lat = explode(",",$latlong)[0];
$long = explode(",",$latlong)[1];
$organisation = $ipMetaDataXML->organisation;
echo "Hostname: " . $hostname . "<br>";
echo "city: " . $city . "<br>";
echo "country: " . $country . "<br>";
echo "lat: " . $lat . "<br>";
echo "long: " . $long . "<br>";
echo "organisation: " . $organisation . "<br>";  
echo "ip: " . $ip;
?>