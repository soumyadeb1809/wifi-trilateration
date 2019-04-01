<?php
    
    include 'dbh.inc.php';

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
 
    if(!empty($_GET['data']))
    {
    	$data = $_GET['data'];

   		$jsonData = json_decode($data, true);

   		for($i=0; $i < count($jsonData); $i++){

   			$ssid = $jsonData[$i]["ssid"];
   			$rssi = $jsonData[$i]["rssi"];

   			$rssi = ($rssi == "") ? 0 : $rssi;

	    	$sql = "UPDATE wifidata SET rssi = ".$rssi.", update_time=now() where ssid = '".$ssid."'";
			$conn->query($sql);

		}

		echo "OK";
		
	}

 
	$conn->close();

?>