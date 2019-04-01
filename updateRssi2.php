<?php
    
    include 'dbh.inc.php';

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
 
    if(!empty($_GET['data']))
    {
    	$data = $_GET['data'];
   		
   		echo "received data: ".$data."<br><br>";

   		echo "json decoded: ".json_decode($data)."<br><br>";

   		echo "json encoded: ".json_encode($data)."<br><br>";

 /*
	    $sql = "UPDATE wifidata SET rssi = ".$rssi.", update_time=now() where ssid = '".$ssid."'";
 
		if ($conn->query($sql) === TRUE) {
		    echo "OK";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
 */
 
	$conn->close();

	?>