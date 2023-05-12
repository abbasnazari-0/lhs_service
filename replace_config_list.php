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
if(isset($_REQUEST['configed'])){
    $sql = "UPDATE tbl_config SET config = '".$_REQUEST['config']."' WHERE item_id = ".$_REQUEST['config_id'];
    if (mysqli_query($conn, $sql)) {
        die("You Have Configed <br> please close this page, "); 
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

}
$sql = "SELECT  config FROM tbl_config WHERE item_id = ".$_REQUEST['config_id'] . " LIMIT 1";
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
    <title>Replace Config List</title>

<body>
<form method="post">
<textarea name="config" placeholder="config" style="width: 683px; height: 228px;"><?php echo $data[0]['config'] ?></textarea>
<br>
<input type="hidden" value="configed" name="configed">
<input type="submit" value="Submit">
</form>
</body>


</html>