<?php

$config = $_REQUEST['config'];


include_once './db.php';


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
