<?php
// Database connection parameters
$host = 'localhost'; // Change this to your database host
$username = 'root'; // Change this to your database username
$password = ''; // Change this to your database password
$database = 'Journal'; // Change this to your database name

// Create connection
$db = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
