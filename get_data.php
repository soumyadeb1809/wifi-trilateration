<?php 

// Import all the required libraries
require __DIR__ . "lib/vendor/autoload.php";

use Tuupola\Trilateration\Intersection;
use Tuupola\Trilateration\Sphere;

// Step 1: Get location and distance of each node/AP from DB


// Step 2: Create Sphere objects for all four nodes/APs
// Syntax: $var = new Sphere($latitude, $longitude, $distance)

$sphere1 = new Sphere(20.356531, 85.820000, 28);
$sphere2 = new Sphere(20.356521, 85.820346, 25);
$sphere3 = new Sphere(20.356253, 85.820336, 20);
$sphere4 = new Sphere(20.356272, 85.820021, 20);


// Step 3: Create a new Intersection object by passing all the Sphere objects as
// argument to the constructor

$trilateration = new Intersection($sphere1, $sphere2, $sphere3, $sphere4);


// Step 4: Call Intersection->position() method to calculate and get the coordinates of
// the intersection of all the Spheres
$point = $trilateration->position();


/////////////////////////////////////////////////////////////////////////////////
// This block is only for testing and visualisation of calculated data
/////////////////////////////////////////////////////////////////////////////////
print_r($point);

$url = "https://appelsiini.net/circles/"
     . "?c={$sphere1}&c={$sphere2}&c={$sphere3}&c={$sphere4}&m={$point}";


echo '<br><br>';     

print '<a href="'.$url.'" target="_blank">Open in map</a>';
//////////////////////////////////////////////////////////////////////////////////


// Step 5: Encode all the required data in JSON as in sample_location_response.json
// and return the data


?>


