<?php
$text = $_POST['lhs'];

include_once './db.php';


$f = explode("\n", $text);

$mysql = "DELETE from tbl_user WHERE token IN (";
$count = 0;
foreach ($f as $x) {
//   if started with http
    if (strpos($x, "http") !== 0) {
        continue;
    }
    // print($x);

  $parsed_url = parse_url($x);
  // Get the fragment
  
  parse_str($parsed_url['query'], $query);

//   // remove user_token= and after space
  $fragment = str_replace("user_token=", "", $query);

  
  $fragment = str_replace(["\u{2705}", "\u{2714}"], '', $fragment);
  $fragment = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $fragment);
  $fragment = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $fragment);
  $fragment = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $fragment);
  $fragment = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $fragment);
  //   remove _ 
  $fragment = str_replace("_", "", $fragment);
  $fragment = ($fragment['user_token']);
  $fragment = explode(" ", $fragment);
  $fragment =  $fragment[0] ;
  // get before :
  if ($fragment != "") {
    $mysql = $mysql . "'" . $fragment . "'" . ",";
    $count = $count + 1;
  }
}
$mysql = substr($mysql, 0, -1) . ");";
echo $mysql ;
echo "<br>count: " . $count;

 if ($conn->query($mysql) === TRUE) {
     echo "Record deleted successfully";
   } else {
     echo "Error updating record: " . $conn->error;
   }

?>
