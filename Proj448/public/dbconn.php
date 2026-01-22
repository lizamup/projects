<?php

$servername = "studentdb-maria.gl.umbc.edu";
$username = "lizam1";
$password = "lizam1";
$dbname = "lizam1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?>