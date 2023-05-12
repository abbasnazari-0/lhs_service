<?php


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


$config = $_REQUEST['config'];
$first = $_REQUEST['first_range'];
$secound = $_REQUEST['sec_range'];

$item_count ;
if(!isset($_REQUEST['sec_range']) || strlen($_REQUEST['sec_range'] < 1)){
    $item_count = 1;
}else{
    $item_count  = $secound-$first+1 ;
}

for($i =0; $i <  $item_count ;  $i++){
    // sql to delete a record
    $id = $first + $i;
$sql .= "INSERT INTO tbl_config (id, config)
VALUES ('$id', '$config');";

}

if ($conn->multi_query($sql) === TRUE) {
    echo "New records created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  