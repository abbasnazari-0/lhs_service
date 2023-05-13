<?php 
date_default_timezone_set("Asia/Tehran");

include_once './db.php';

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

 
// $sql = "SELECT tbl_user.*,tbl_config.*  FROM tbl_user INNER JOIN tbl_config ON tbl_user.config_tag_id = tbl_config.id  Where tbl_user.token = '$user_token' ORDER BY sort_id ASC ";
// $sql = "SELECT * FROM tbl_user WHERE tbl_user.token = '$user_token';";

$tag_id = (getUserTagID($user_token));
if($tag_id == 0){
    echo base64_encode("vless://707c8b79-2eee-46e2-87d6-504b7a0cc4vv@gdgs.dgsdgds:3543?sni=gdgs.dgsdgds&security=tls&type=grpc&serviceName=ASDcME1o#You%20Have%20Not%20Credit%20%7C%20Please%20Contact%20Support%20Of%20Us");
}else{

    $sql = "SELECT tbl_urls.id, tbl_urls.title, tbl_urls.address, tbl_urls.type, tbl_base_config.config, GROUP_CONCAT(DISTINCT JSON_EXTRACT(tbl_base_config.domain_selected, CONCAT('$[', numbers.n, ']'))) AS domain_selected, tbl_base_config.tag_id
    FROM tbl_urls
    JOIN tbl_base_config ON JSON_CONTAINS(tbl_base_config.domain_selected, CAST(tbl_urls.id AS JSON), '$')
    JOIN (SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS numbers ON JSON_EXTRACT(tbl_base_config.domain_selected, CONCAT('$[', numbers.n, ']')) IS NOT NULL
    WHERE tbl_base_config.tag_id = '$tag_id'
    GROUP BY tbl_urls.id, tbl_urls.title, tbl_urls.address, tbl_urls.type, tbl_base_config.config, tbl_base_config.type, tbl_base_config.tag_id 
  
    ";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
    // output data of each row
      $data="";
    
    while($row = mysqli_fetch_assoc($result)) {
        $config = $row["config"];

        
        // check $config started with vless 
        if (strpos($config, 'vless://') !== false) {
            // replace addresess which started from @ to ? with regex 
            $replacement = "@". $row["address"] ."?";
            $config = preg_replace('/@.*\?/', $replacement, $config);            


            $parsedUrl = parse_url($config);

            $oldFragment = $parsedUrl['fragment'];


            $newFragment  = $row["title"];
            $config = preg_replace('/#.*$/',"#". $oldFragment   . ' '. $newFragment, $config);


            $data .= $config."\n" ;
        }else if (strpos($config, 'vmess://') !== false) {
            // remove vmess:// from config
            $config = str_replace("vmess://", "", $config);
            // decode base64
            $config = base64_decode($config);
            // decode json
            $config = json_decode($config, true);
            // replace address
            $config['add'] = $row["address"];
            // replace  title
            $config['ps'] = $row["title"];

            // encode json
            $config = json_encode($config);
            // encode base64
            $config = base64_encode($config);
            // add vmess://
            $config = "vmess://".$config;
            
            
            $data .= $config."\n" ;

        }
        
    
        




    }
    
    echo base64_encode($data);
    
    } else {
    echo base64_encode("vless://707c8b79-2eee-46e2-87d6-504b7a0cc4vv@gdgs.dgsdgds:3543?sni=gdgs.dgsdgds&security=tls&type=grpc&serviceName=ASDcME1o#You%20Have%20Not%20Credit%20%7C%20Please%20Contact%20Support%20Of%20Us");
    }
}




$sql = "INSERT INTO tbl_log ( token, ip)
VALUES ('$user_token', '$ip')";

if ($conn->query($sql) === TRUE) {
  echo "";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

function getUserTagID($user_token){
    $sql = "SELECT * FROM tbl_user WHERE tbl_user.token = '$user_token' LIMIT 1";
    $result = mysqli_query($GLOBALS['conn'], $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
//   $data="";
    $tag_id = "";
  while($row = mysqli_fetch_assoc($result)) {
    $tag_id = $row['config_tag_id'];
  }
//   print_r($data);
//   echo base64_encode($data);
  return $tag_id;
} else {
    return 0;
}

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