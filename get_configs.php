<?php 
date_default_timezone_set("Asia/Tehran");




include_once './db.php';


$sql = "SELECT * FROM tbl_config WHERE operator = 'mci' and type = 'cloudflare'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    
    $checkedForFirst = false;
    $data=array();
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);
    
    } else {
    echo "0 results";
    }
