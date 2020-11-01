<?php 
session_start();
include "db.php";

$room_id = $_REQUEST['room_id'];
$current_date = (floor(gettimeofday(true))-3);

$sql = "SELECT * FROM `players` WHERE room = '$room_id' and online_status >= '$current_date'";
$result = mysqli_query($con,$sql);
$row_num = mysqli_num_rows($result);

echo $row_num;


?>