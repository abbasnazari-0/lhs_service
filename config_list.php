<?php
date_default_timezone_set("Asia/Tehran");

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

 if(isset($_GET['id'])){
    $id = $_GET['id'];
  }else{
    $id = 1;
 }
$sql = "SELECT  DISTINCT  config, item_id FROM tbl_config WHERE id = '$id'  ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  $data;
  while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }  
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Config List</title>
</head>
<body>

<div id="myBox"></div>
    <?php
    foreach($data as $item){
        // each item example
        //  vless://fc80e3cc-2c09-456f-d124-88c600823892@private.gamefasion.online:2087?path=%2F&security=tls&encryption=none&host=dl7.gamefasion.online&type=ws&sni=dl7.gamefasion.online#Finland+High+speed+%F0%9F%87%AB%F0%9F%87%AE
        // get beetwen @ and :
        $url = explode("@",$item["config"]); 
        $url = explode("?",$url[1]);
         
        
        // get # and after

        $config = explode("#",$item["config"]);

        echo urldecode($config[1])."<br>";



        // show text with small size
        echo "<a href='".$item["config"]."'>".$url[0]."</a><br>";
        $id = $item["item_id"];
        // open in new tab
    
        echo '<a href="http://37.152.182.34/lhs-global-main/replace_config_list.php?config_id='.$id.'" target="_blank">Edit This Config</a>';
    
    
   


        echo "<hr>";
        // echo "<small>".$item["config"]."</small><br><br>";
        // echo $item["config"]."<br><br>";

    }
    ?>
 
   
</body>
</html>