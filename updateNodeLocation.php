<?php
    
require 'dbh.inc.php';

$response = array();

$ssid = $_GET["ssid"];
$lat = $_GET["lat"];
$lng = $_GET["lng"];


$change_query = "UPDATE `node_location` SET latitude = $lat, longitude = $lng WHERE pk_location_id = (SELECT fk_location_id FROM wifidata WHERE ssid = '$ssid')";
if(mysqli_query($conn, $change_query)){
    $response["result"] = "SUCCESS";
    $response["message"] = "Position updated";
}
else{
    $response["result"] = "FAILED";
    $response["message"] = "".mysqli_error($conn);
    echo mysqli_error($conn);
}

echo json_encode($response);

?>