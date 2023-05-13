<?php
date_default_timezone_set("Asia/Tehran");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lhs";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>