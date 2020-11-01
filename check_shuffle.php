<?php 
session_start();
include "db.php";

$sql = "SELECT * FROM `rooms` WHERE room_id = '".$_SESSION['room']."'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);

echo $row['shuffle_status'];

?>