<?php

include_once './db.php';

$count = @$_REQUEST['count'];
if(!isset($_REQUEST['count']) || strlen(@$_REQUEST['count']) < 1){
  $count = 1;   
}

 $config_tag_id = $_REQUEST['config_tag_id'];
 $started = @$_REQUEST['started'];
 if( strlen(@$_REQUEST['started']) < 1 ){  $started = 1;}else{
  if($started =='1' ){
    $started = 0;
  }
 }
 $day  =  $_REQUEST['day'];


 
for($i = 0; $i < $count; $i++){
    $newHash = bin2hex(openssl_random_pseudo_bytes(30)); // 20 chars

  

    $sql = "INSERT INTO tbl_user ( token, config_tag_id, `time`, `started`, `day`)
    VALUES ('$newHash', '$config_tag_id', UNIX_TIMESTAMP(DATE_ADD(NOW(), INTERVAL $day DAY)), '$started', '$day'); ";
    

   
    if ($conn->query($sql) === TRUE) {
      echo ($i+1) .  " <br> http://local.cloudspeed.shop/lhs-global-main/index.php?user_token=$newHash <br> 🚫🚫 لطفا مراقب باشید لینک های خود را به گوشی و یا دیوایس دیگری اضافه نکنید 🚫🚫 <br>  ⛔️ چون ممکنه لینک هاتون بلاک بشه و ما مسئولیت آن را به عهده نمیگیریم <br><br>";
    } else {
      echo "Error: " . $sql . "<br>" .$conn->error;
    }

}


mysqli_close($conn);