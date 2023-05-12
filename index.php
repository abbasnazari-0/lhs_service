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

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

if(!isset($_REQUEST['user_token'])){
    die("Fuck You");
}
$user_token = $_REQUEST['user_token'];

if(checkIP($conn,$ip) == true){
 // die(base64_encode("vless://707c8b79-2eee-46e2-87d6-504b7a0cc4vv@gdgs.dgsdgds:3543?sni=gdgs.dgsdgds&security=tls&type=grpc&serviceName=ASDcME1o#You%20Have%20Not%20Credit%20%7C%20Please%20Contact%20Support%20Of%20Us"));
}
if(checkHistoryLog($conn,$ip, $user_token) == true){
 // die(base64_encode("vless://707c8b79-2eee-46e2-87d6-504b7a0cc4vv@gdgs.dgsdgds:3543?sni=gdgs.dgsdgds&security=tls&type=grpc&serviceName=ASDcME1o#You User Too Request in this day"));
}

//ip-----------------------------
$ip_address = $_SERVER['REMOTE_ADDR'];
$url = "https://api.iplocation.net/?ip=".$ip_address;
$data = file_get_contents($url);
$response = json_decode($data, true);
$txt =  "Your ISP: " . $response['isp'];
$cc =  "your country is : " . $response['country_code2'];

$myfile = fopen("newfile.txt", "r") or die("Unable to open file!");

fwrite($myfile,"\n". $txt . "\n" . $cc);
//ip-----------------------------

 
$sql = "SELECT tbl_user.*,tbl_config.*  FROM tbl_user INNER JOIN tbl_config ON tbl_user.config_tag_id = tbl_config.id  Where tbl_user.token = '$user_token' ORDER BY item_id DESC ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  $data="";
  while($row = mysqli_fetch_assoc($result)) {
    $data .= $row["config"]."\n" ;

  }
  echo base64_encode($data);
  
} else {
  echo base64_encode("vless://707c8b79-2eee-46e2-87d6-504b7a0cc4vv@gdgs.dgsdgds:3543?sni=gdgs.dgsdgds&security=tls&type=grpc&serviceName=ASDcME1o#You%20Have%20Not%20Credit%20%7C%20Please%20Contact%20Support%20Of%20Us");
}


$sql = "INSERT INTO tbl_log ( token, ip)
VALUES ('$user_token', '$ip')";

if ($conn->query($sql) === TRUE) {
  echo "";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

function checkIP($conn, $ip){
  $sql = "SELECT * FROM tbl_server_list WHERE ip = '$ip'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    return true;
  } else {
    return false;
  }
}
function checkHistoryLog($conn, $ip, $user_token){
  $sql = "SELECT * FROM tbl_log where token = '$user_token' AND DATE(`date_update`) = CURDATE() ";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 1000 ) {
    return true;
  } else {
    return false;
  }

}




mysqli_close($conn);