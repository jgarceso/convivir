<?php

echo "tetstst";

$base_url = "https://maps.googleapis.com/maps/api/geocode/json?";

$address = utf8_decode("Miraflores 806, Chimbarongo, Chile");
$request_url = $base_url . "address=" . urlencode($address);
echo $request_url;
echo "</br>";
$csv = file_get_contents($request_url) or die("url not loading");
$obj = json_decode($csv, true);
echo $obj['status'];
echo "</br>";
echo $obj['results'][0]['geometry']['location']['lat'];
echo "</br>";
echo $obj['results'][0]['geometry']['location']['lng'];
/*$csvLine = explode(",", $csv);
$status = $csvLine[0];
$lat = $csvLine[2];
$lng = $csvLine[3];

echo $status;
echo "</br>";
echo $lat;
echo "</br>";
echo $lng;*/
?>