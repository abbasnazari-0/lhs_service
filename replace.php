<?php

$pre_config = $_REQUEST['pre_config'];
$new_config = $_REQUEST['new_config'];


include_once './db.php';



if(!isset($_REQUEST['pre_config'])){
    die("Fuck You");
}



        // UPDATE tbl_config SET config = REPLACE(config, 'speedserver.shop', 'gamelevel.world')

$sql = "UPDATE tbl_config SET config= REPLACE(`config`,'$pre_config', '$new_config')";

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . $conn->error;
}
