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


$configs = $_REQUEST['configs'];

$data = json_decode(base64_decode($configs), true);


$configs = [];
foreach ($data as $value) {
    $configs[] =  $value['config'];
}

$config_id = rand(1500,1000000000);


for($i =0; $i <  count($configs) ;  $i++){
    // sql to delete a record
$sql_config .= "INSERT INTO tbl_config (id, config)
VALUES ('$config_id', '" . ($configs[$i]) ."');";

}

if ($conn->multi_query($sql_config) === TRUE) {
     
    $newHash = bin2hex(openssl_random_pseudo_bytes(30)); // 20 chars
    
    $sql_user = "INSERT INTO tbl_user ( token, config_tag_id)
    VALUES ('$newHash', '$config_id')";
    
    if ($conn->query($sql_user) === TRUE) {
      echo "http://local.cloudspeed.shop/lhs-global-main/index.php?user_token=$newHash";
    } else {
      echo "Error  2: " . $sql_user . "<br>" . $conn->error;
    }


     




     
     
     
     
     
     
     
  } else {
    echo "Error  3: " . $sql_config . "<br>" . $conn->error;
 }
  
  