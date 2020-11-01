<?php
session_start();
include "db.php";

$user_agent = getenv("HTTP_USER_AGENT");

$n=4; 
function getName($n) { 
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
}
$room = strtoupper(getName($n));

$sql = "INSERT INTO `rooms` (`user_agent`,`room_id`,`host`,`shuffle_status`) VALUES ('$user_agent','$room','".$_SESSION['u_id']."' ,'')";
if(!mysqli_query($con,$sql)){
    echo "Error SQL";
}else{
    $sql_enter_room = "UPDATE `players` SET `room`='$room' WHERE u_id = '".$_SESSION['u_id']."'";
    if(!mysqli_query($con,$sql_enter_room)){
        echo "Enter room failed";
    }else{
        $_SESSION['room']=$room;
        echo "ok";
    }
}
?>