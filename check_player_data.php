<?php
session_start();
include "db.php";

$user_agent = getenv("HTTP_USER_AGENT");
$sql = "SELECT * FROM `players` WHERE user_agent = '$user_agent'";
$result = mysqli_query($con,$sql);
$row_num = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

if($row_num >= 1){
    echo "ok";
}else{
    echo "not_ok";
}
?>