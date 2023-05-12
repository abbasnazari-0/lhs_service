<?php

$pre_config = $_REQUEST['pre_config'];
$new_config = $_REQUEST['new_config'];


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


if(!isset($_REQUEST['pre_config'])){
    die("Fuck You");
}



        UPDATE tbl_config SET config = REPLACE(config, 'speedserver.shop', 'gamelevel.world')

$sql = "UPDATE tbl_config SET config= REPLACE(`config`,'$pre_config', '$new_config')";

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . $conn->error;
}
