<?php


include 'dbh.inc.php';

// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

$data=array();
$sql="select rssi from wifidata";
$result=$conn->query($sql);

if(mysqli_num_rows($result)>0)
{
	while ($row=mysqli_fetch_assoc($result)) {
		# code...
		$data=$row;
	}
}
    


else {
echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    
}


print_r($data);

?>