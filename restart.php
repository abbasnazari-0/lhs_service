<?php
$urls = array(
  "http://173.230.158.41:4000/user_item_count",
  "http://198.74.50.69:4000/user_item_count",
  "http://45.79.249.4:4000/user_item_count",
  "http://176.58.98.121:4000/user_item_count",
  "http://5.161.181.35:4000/user_item_count",
  "http://95.216.144.146:4000/user_item_count",
  "http://5.78.45.44:4000/user_item_count",
  "http://5.161.186.40:4000/user_item_count",
  "http://65.21.57.243:4000/user_item_count",
  "http://65.21.5.28:4000/user_item_count",
  "http://142.132.236.191:4000/user_item_count",
  "http://65.21.0.132:4000/user_item_count",
  "http://37.48.109.64:4000/user_item_count",
  "http://212.64.223.199:4000/user_item_count",
  "http://78.135.88.62:4000/user_item_count",
  "http://213.238.167.106:4000/user_item_count",
  "http://212.64.223.194:4000/user_item_count",
  "http://51.195.246.172:4000/user_item_count",
  "http://51.38.79.189:4000/user_item_count",
  "http://5.135.4.77:4000/user_item_count",
  "http://213.32.41.101:4000/user_item_count",
  "http://5.135.4.95:4000/user_item_count",
  "http://51.89.71.175:4000/user_item_count",
  "http://51.89.71.174:4000/user_item_count",
  "http://135.125.178.48:4000/user_item_count",
  "http://51.222.239.113:4000/user_item_count",
  "http://87.248.129.219:4000/user_item_count",
  "http://82.115.18.48:4000/user_item_count"
);

foreach ($urls as $url) {
  echo file_get_contents($url, "") . "<br>";
}
?>
