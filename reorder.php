<?php
// mysql
$servername = "localhost";
$username = "root";
$password = "nazari@0794";
$dbname = "lhs";


// ????? ?????? ?? ?????? ????
$conn = mysqli_connect($servername, $username, $password, $dbname);
 
// ?? ???? ?????
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully\n";

if(isset($_GET['id'])){
  $id = $_GET['id'];
}else{
  $id = 1;
}
 
// select tbl_config 
$sql = "SELECT * FROM tbl_config where id = $id";
$result = $conn->query($sql);

$sql = "UPDATE tbl_config SET config = CASE ";

$countNumber = 1;
$ids = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $config = $row["config"];
    
    //  regex vless in string 
    if(strpos($config, "vless://") === 0) {
      // Parse the URL
      $parsed_url = parse_url($config);
      
      // Get the fragment
      $fragment = $parsed_url["fragment"];
      
      $fragment = preg_replace('/@(\d+)/', '', $fragment);
      // get all config without fragment
      $config = str_replace($parsed_url["fragment"],  $fragment, $config);
      // add new fragment
      $config = $config . " @" . strval($countNumber);
      $config = str_replace('  ', '', $config);
      
      $updatequery = $config;
       
      // update query
      $sql =  $sql . " WHEN item_id = " . $row["item_id"] . " THEN '" . $updatequery . "'";
      
    /*} elseif (strpos($config, "vmess://") === 0) {
      // Remove the vmess:// prefix and decode the base64-encoded string
      $vmess_data = base64_decode(substr($config, 8));
      // Parse the JSON data
      $vmess_json = json_decode($vmess_data, true);
      $fragment = $vmess_json['ps'];
      $fragment = preg_replace('/@(\d+)/', '', $fragment);
      $vmess_json['ps'] = $fragment . " @" . strval($countNumber);
      $config = "vmess://" . base64_encode(json_encode($vmess_json));
      $updatequery = $config;
      
      // update query
      $sql =  $sql . " WHEN item_id = " . $row["id"] . " THEN '" . $updatequery . "'";
      */
    } else {
      echo "not vless or vmess <br>";
    }
    
    $ids[] = $row["item_id"];
    $countNumber++;
  }
} else {
  echo "0 results\n";
}
$sql = $sql . " ELSE config END WHERE item_id IN (" . implode(",", $ids) . ");";
 
 

// run sql query
if ($conn->query($sql) === TRUE) {
  echo $conn->affected_rows . " record(s) updated\n";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
 
// close connection
$conn->close();
?>
