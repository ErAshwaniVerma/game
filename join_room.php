<?php
session_start();
include "db.php";

$user_agent = getenv("HTTP_USER_AGENT");
$room = strtoupper($_REQUEST['room']);
$current_date = (floor(gettimeofday(true))-3);

$sql_check_room = "SELECT * FROM `rooms` WHERE room_id = '$room'";
$result = mysqli_query($con,$sql_check_room);
$row_num = mysqli_num_rows($result);

$sql_check_player_num = "SELECT * FROM `players` WHERE room = '$room' and online_status >= '".$current_date."'";
$result_check_player_num = mysqli_query($con,$sql_check_player_num);
$row_check_player_num = mysqli_num_rows($result_check_player_num);

if($row_check_player_num <= 3){
    if($row_num >= 1 ){
        $sql_enter_room = "UPDATE `players` SET `room`='$room' WHERE u_id = '".$_SESSION['u_id']."'";
        if(!mysqli_query($con,$sql_enter_room)){
            echo "Enter room failed";
        }else{
            $_SESSION['room']=$room;
            echo "ok";
        }
    }else{
        echo "Incorrect Room ID";
    }
}else{
    echo "Room full";
}
?>