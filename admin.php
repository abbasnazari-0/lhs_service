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


if(!isset($_REQUEST['action'])){
    die('Fuck you!');
}

$action = $_REQUEST['action'];
if($action == "add_address"){
    addAddresses($conn);
}else if($action == "get_addresses"){
    getaddresses($conn);
}else if($action == "get_configs"){
    getConfigs($conn);
  }else if($action == "update_config"){
    updateConfig($conn);
  }else if($action == "remove_config"){
    removeConfig($conn);
}else{
    addConfig($conn);
}

function updateConfig($conn){

    
  $id = $_REQUEST['id'];
  $config = $_REQUEST['config'];
  $domain_selected = $_REQUEST['domain_selected'];
  $type = $_REQUEST['type'];
  $tag_id = $_REQUEST['tag_id'];

  $sql = "UPDATE tbl_base_config SET config = '$config', type = '$type' , domain_selected= '$domain_selected', tag_id  = '$tag_id' WHERE id= $id ";


  if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $conn->error;
  }
  
  $conn->close();

}

function removeConfig($conn){
    
  $id = $_REQUEST['id'];

  // remove query
  // sql to delete a record
  $sql = "DELETE FROM tbl_base_config WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
  } else {
    echo "Error deleting record: " . $conn->error;
  }

  $conn->close();
  

}
function getConfigs($conn){
    // if tag_id isset
    if(isset($_REQUEST['tag_id'])){
      $tag_id = $_REQUEST['tag_id'];
    }else{
      $tag_id = 1;
    }

    $sql = "SELECT * FROM tbl_base_config WHERE tag_id = $tag_id";
    $result = $conn->query($sql); 
    
    if ($result->num_rows > 0) {
      // output data of each row
      $data =array();
      while($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
      echo json_encode($data);
    } else {
      echo "[]";
    }
    $conn->close();


}
function getaddresses($conn){

    // select query 
    

    $sql = "SELECT * FROM tbl_urls";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      $data =array();
      while($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
      echo json_encode($data);
    } else {
      echo "[]";
    }
    $conn->close();
}


function addAddresses($conn){
    $title =  $_REQUEST['title'];
    $address = $_REQUEST['address'];
    $type = $_REQUEST['type'];

    // create insert sql query

    $sql = "INSERT INTO tbl_urls (title, address, type)
    VALUES ('$title', '$address', '$type')";

    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();




}

function addConfig($conn){
    $config =  $_REQUEST['config'];
    $domain_selected = $_REQUEST['domain_selected'];
    $type = $_REQUEST['type'];
    $tag_id = $_REQUEST['tag_id'];

    // create insert sql query

    $sql = "INSERT INTO tbl_base_config (config, type, domain_selected, tag_id)
    VALUES ('$config', '$type', '$domain_selected', '$tag_id')";

    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();



}