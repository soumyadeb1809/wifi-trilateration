<?php 

include 'dbh.inc.php';
// Import all the required libraries
require __DIR__ . "/lib/vendor/autoload.php";

use Tuupola\Trilateration\Intersection;
use Tuupola\Trilateration\Sphere;

// Step 1: Get location and distance of each node/AP from DB
$response = array();
$node_data = array();
$sql = "SELECT a.id,a.ssid,a.rssi,b.latitude,b.longitude FROM wifidata AS a INNER JOIN node_location AS b ON a.fk_location_id = b.pk_location_id";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
	
	while ($row=mysqli_fetch_array($result)){
		# code...
		array_push($node_data, array("id"=>$row["id"],"ssid"=>$row["ssid"],"rssi"=>$row["rssi"],"latitude"=>$row["latitude"], "longitude"=>$row["longitude"]));
	}
	
}

//Calculate the distance
function calcDistanceFromRssi($rssi)
{
	$y = pow(10, ( $rssi/10)) / 1000;
	$z = sqrt(9.6*pow(10, -8)*5*pow(10, -3)/$y);
	$distance = $z * 6;
	return $distance;
}

// Assign the distance
$node_data[0]['distance']=calcDistanceFromRssi($node_data[0]['rssi']);
$node_data[1]['distance']=calcDistanceFromRssi($node_data[1]['rssi']);
$node_data[2]['distance']=calcDistanceFromRssi($node_data[2]['rssi']);
$node_data[3]['distance']=calcDistanceFromRssi($node_data[3]['rssi']);


// Step 2: Create Sphere objects for all four nodes/APs
// Syntax: $var = new Sphere($latitude, $longitude, $distance)

$sphere1 = new Sphere($node_data[0]['latitude'],$node_data[0]['longitude'], $node_data[0]['distance']);
$sphere2 = new Sphere($node_data[1]['latitude'],$node_data[1]['longitude'], $node_data[1]['distance']);
$sphere3 = new Sphere($node_data[2]['latitude'], $node_data[2]['longitude'], $node_data[2]['distance']);
$sphere4 = new Sphere($node_data[3]['latitude'],$node_data[3]['longitude'], $node_data[3]['distance']);


// Step 3: Create a new Intersection object by passing all the Sphere objects as
// argument to the constructor

$trilateration = new Intersection($sphere1, $sphere2, $sphere3, $sphere4);


// Step 4: Call Intersection->position() method to calculate and get the coordinates of
// the intersection of all the Spheres
$point = $trilateration->position();


/////////////////////////////////////////////////////////////////////////////////
// This block is only for testing and visualisation of calculated data
/////////////////////////////////////////////////////////////////////////////////
/*
$url = "https://appelsiini.net/circles/"
     . "?c={$sphere1}&c={$sphere2}&c={$sphere3}&c={$sphere4}&m={$point}";


echo '<br><br>';     

print '<a href="'.$url.'" target="_blank">Open in map</a>';
//////////////////////////////////////////////////////////////////////////////////


// Step 5: Encode all the required data in JSON as in sample_location_response.json
// and return the data

*/

$response["ap_nodes"] = $node_data;
$pos_data["latitude"]=$point->latitude();
$pos_data["longitude"]=$point->longitude();
$response["position"]=$pos_data;

echo json_encode($response);

$conn->close();

?>


