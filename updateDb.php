<?php
    
    include 'dbh.inc.php';

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
 
    if(!empty($_GET['ssid']) && !empty($_GET['rssi']))
    {
    	$ssid = $_GET['ssid'];
    	$rssi = $_GET['rssi'];
 
	    $sql = "UPDATE wifidata SET rssi = ".$rssi.", update_time=now() where ssid = '".$ssid."'";
 
		if ($conn->query($sql) === TRUE) {
		    echo "OK";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
 
 
	$conn->close();

	?>