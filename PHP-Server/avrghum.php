<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "sensostalker";
error_reporting(0);
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
	if (isset($_GET['hum']) ) {
		$gkff=  $_GET['hum'];
$av=0;
$sql = "SELECT humidity FROM humh  ORDER by humid DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	$i=0;
    while($row = $result->fetch_assoc()) {
		$i++;
        $av=$av+$row["humidity"];
		if ($i==240) { 
		break;}
    }
} else {
    echo "0 results";
}
$av = $av/240;
$temp=0;
if ($result->num_rows > 0) {
    // output data of each row
	$i=0;
    while($row = $result->fetch_assoc()) {
		$i++;
        $temp=$temp+pow(($row["humidity"]-$av),2);
		if ($i==240) { 
		break;}
    }
} else {
    echo "0 results";
}
$temp=$temp/240;
$temp=sqrt($temp);
$var1 = date('His');
$var2 = date("Ymd");
$my_date = strtotime($var2); 
$sql = "INSERT INTO hum (humidit, hdate, hhour,divergence)
VALUES ($av, $var2, $var1, $temp);";
if ($conn->multi_query($sql) === TRUE) {
    echo "New records created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
	}
?>