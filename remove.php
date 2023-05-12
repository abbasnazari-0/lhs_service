<?php

$config = $_REQUEST['config'];


$servername = "localhost";
$username = "root";
$password = "nazari@0794";
$dbname = "lhs";




// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


if(!isset($_REQUEST['config'])){
    die("Fuck You");
}



// sql to delete a record
$sql = "DELETE FROM tbl_config WHERE config LIKE '%$config%'";

if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}
