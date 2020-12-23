<?php
session_start();
include "db.php";

$current_date = (floor(gettimeofday(true))-3);

$sql = "SELECT * FROM `players` where u_id = '".$_SESSION['u_id']."' ";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);

echo $row['u_char'];

?>