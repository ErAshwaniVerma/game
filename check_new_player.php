<?php
session_start();
include "db.php";

$sql = "SELECT * FROM `players` WHERE room = '".$_SESSION['room']."'";
$result = mysqli_query($con,$sql);
$row_num = mysqli_num_rows($result);

echo $row_num;

?>