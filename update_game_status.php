<?php 
session_start();
include "db.php";

$st = $_REQUEST['st'];

$sql = "UPDATE `rooms` SET `game_status`='$st' WHERE room_id= '".$_SESSION['room']."'";
if(mysqli_query($con,$sql)){
    echo "ok";
}else{
    echo "Game status failed";
}

?>