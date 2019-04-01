<?php 

include 'dbh.inc.php';
// Import all the required libraries
require __DIR__ . "/lib/vendor/autoload.php";

use Tuupola\Trilateration\Intersection;
use Tuupola\Trilateration\Sphere;

// Step 1: Get location and distance of each node/AP from DB
$response = array();
$node_data = array();
$sql = "SELECT a.id,a.ssid,a.rssi,b.latitude,b.longitude FROM wifidata AS a INNER JOIN node_location AS b ON a.fk_location_id = b.pk_location_id WHERE a.rssi != 0 AND a.id < 5";

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
{	$distance = -1;
	if($rssi != 0){
		$y = pow(10, ( $rssi/10)) / 1000;
		$z = sqrt(9.6*pow(10, -8)*5*pow(10, -3)/$y);
		$distance = $z * 6;
	}
	return $distance;
}

// Assign the distance
for($i = 0; $i < count($node_data); $i++){
	$node_data[$i]['distance']=calcDistanceFromRssi($node_data[$i]['rssi']);
}


// Step 2: Create Sphere objects for all four nodes/APs
// Syntax: $var = new Sphere($latitude, $longitude, $distance)

$spheres = array();

foreach($node_data as $node){

	$sphere = new Sphere($node['latitude'], $node['longitude'], $node['distance']);
	array_push($spheres, $sphere);

}


// Step 3: Create a new Intersection object by passing all the Sphere objects as
// argument to the constructor

$trilateration = new Intersection($spheres);

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


