<?php
    
    include 'dbh.inc.php';

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
 
    if(!empty($_GET['data']))
    {
    	$data = $_GET['data'];

   		$jsonData = json_decode($data);

   		for(int i=0; i < count($jsonData); j++){
   			$ssid = $data[i]["ssid"];
   			$rssi = $data[i]["rssi"];

   			$rssi = ($rssi == "") ? 0 : $rssi;

	    	$sql = "UPDATE wifidata SET rssi = ".$rssi.", update_time=now() where ssid = '".$ssid."'";
			$conn->query($sql)
		}
		
	}

 
	$conn->close();

?>