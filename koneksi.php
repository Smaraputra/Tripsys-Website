<?php
    $dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$db = "id15766723_sistemtripsys";
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
	$conn1 = new mysqli($dbhost, $dbuser, $dbpass, $db);
	$conn2 = new mysqli($dbhost, $dbuser, $dbpass, $db);
	$conn3 = new mysqli($dbhost, $dbuser, $dbpass, $db);
	
	if ($conn->connect_error){
        die("Connection Failed: " . $conn->connect_error);
    }
?>