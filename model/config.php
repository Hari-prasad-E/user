<?php
/**
* This page is containing the details for database Connection.
*/

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "paytest";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
