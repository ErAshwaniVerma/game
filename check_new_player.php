<?php
session_start();
include "db.php";
$current_date = (floor(gettimeofday(true))-6);

$sql = "SELECT * FROM `players` WHERE room = '".$_SESSION['room']."' and online_status >= '$current_date'";
$result = mysqli_query($con,$sql);
$row_num = mysqli_num_rows($result);

echo $row_num;

?>