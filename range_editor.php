<?php

include_once './db.php';

$config_id = "";

$config = $_REQUEST['config'];
$first = @$_REQUEST['first_range'];
$secound = @$_REQUEST['sec_range'];
$com_rang = @$_REQUEST['com_rang'];

if(!isset($_REQUEST['com_rang']) || strlen($_REQUEST['com_rang']) < 1){
    $item_count ;
    if(!isset($_REQUEST['sec_range']) || strlen($_REQUEST['sec_range'] < 1)){
        $item_count = 1;
    }else{
        $item_count  = $secound-$first+1 ;
    }
    for($i =$first; $i <=  $secound ;  $i++){
        $config_id .= "".$i . ",";
    }
    $config_id  = substr($config_id, 0, -1);

}else{
    $config_id = $com_rang;
}


    // sql to delete a record
$sql = "INSERT INTO tbl_config (id, config)
VALUES ('$config_id', '$config');";

die($sql);


if ($conn->multi_query($sql) === TRUE) {
    echo "New records created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  