<?php 
session_start();
include "db.php";

$st = $_REQUEST['st'];

$sql = "UPDATE `rooms` SET `shuffle_status`='$st' WHERE room_id= '".$_SESSION['room']."'";
if(mysqli_query($con,$sql)){
    echo "ok";
}else{
    echo "Shuffle status failed";
}

?>