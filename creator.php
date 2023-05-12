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



$count = $_REQUEST['count'];
if(!isset($_REQUEST['count'])){
    if(!isset($_REQUEST['config_tag_id'])){
        die('fuck you');
    }
     if(strlen($_REQUEST['config_tag_id']) < 1){
        die('fuck you');
    }
    
    $config_tag_id = $_REQUEST['config_tag_id'];
    $newHash = bin2hex(openssl_random_pseudo_bytes(30)); // 20 chars
    
    $sql = "INSERT INTO tbl_user ( token, config_tag_id)
    VALUES ('$newHash', '$config_tag_id')";
    
    if ($conn->query($sql) === TRUE) {
      echo "http://local.cloudspeed.shop/lhs-global-main/index.php?user_token=$newHash <br> 🚫🚫 لطفا مراقب باشید لینک های خود را به گوشی و یا دیوایس دیگری اضافه نکنید 🚫🚫 <br>  ⛔️ چون ممکنه لینک هاتون بلاک بشه و ما مسئولیت آن را به عهده نمیگیریم <br><br>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    
    
    
    
    
    
    
}

 $config_tag_id = $_REQUEST['config_tag_id'];
 
for($i = 0; $i < $count; $i++){
    $newHash = bin2hex(openssl_random_pseudo_bytes(30)); // 20 chars

  
    $sql = "INSERT INTO tbl_user ( token, config_tag_id)
    VALUES ('$newHash', '$config_tag_id')";
    
    if ($conn->query($sql) === TRUE) {
      echo ($i+1) .  " <br> http://local.cloudspeed.shop/lhs-global-main/index.php?user_token=$newHash <br> 🚫🚫 لطفا مراقب باشید لینک های خود را به گوشی و یا دیوایس دیگری اضافه نکنید 🚫🚫 <br>  ⛔️ چون ممکنه لینک هاتون بلاک بشه و ما مسئولیت آن را به عهده نمیگیریم <br><br>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

}


mysqli_close($conn);