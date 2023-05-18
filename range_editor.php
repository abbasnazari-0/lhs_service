<?php

include_once './db.php';

$config_id = "";

$config = $_REQUEST['config'];
$first = @$_REQUEST['first_range'];
$secound = @$_REQUEST['sec_range'];
$com_rang = @$_REQUEST['com_rang'];
$operator = @$_REQUEST['operator'];
$country = @$_REQUEST['country'];
if(isset($_REQUEST['cloudflare'])){ $isCloudFlare = @$_REQUEST['cloudflare']; } else{ $isCloudFlare = "normal" ;}

if(!isset($_REQUEST['com_rang']) || strlen($_REQUEST['com_rang']) < 1){
    $item_count ;
    if(!isset($_REQUEST['sec_range']) || strlen($_REQUEST['sec_range'] < 1)){
        $config_id = $first ;
    }else{
        for($i =$first; $i <=  $secound ;  $i++){
            $config_id .= "".$i . ",";
        }
    }
    $config_id  = substr($config_id, 0, -1);
    

}else{
    $config_id = $com_rang;
}

$config_id = str_replace(" ","" , $config_id);

    // sql to delete a record
$sql = "INSERT INTO tbl_config (id, config, operator, type, country)
VALUES ('$config_id', '$config', '$operator', '$isCloudFlare', '$country');";


if ($conn->multi_query($sql) === TRUE) {
    echo "New records created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  