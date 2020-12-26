<?php
session_start();
include "db.php";

$sql = "SELECT * FROM `rooms` where room_id = '".$_SESSION['room']."' ";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);

echo $row['score_board_status'];

?>