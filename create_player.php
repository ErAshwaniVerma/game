<?php
session_start();
include "db.php";
$uname = $_REQUEST['uname'];
$player_type = $_REQUEST['player_type'];
if(isset($_REQUEST['pre_room']) && !empty($_REQUEST['pre_room'])){
$pre_room = $_REQUEST['pre_room'];
}else{
    $pre_room = "";
}

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
$room = "";
if($player_type == "host"){
    $room = strtoupper(getName($n)); 
}else{
    $sql_check_room = "SELECT * FROM `players` WHERE room = '$pre_room'";
    $result_check_room = mysqli_query($con,$sql_check_room);
    $row_num_check_room = mysqli_num_rows($result_check_room);
    if($row_num_check_room <= 0){
        echo "Room Id Incorrect";
        return false;
    }else{
        $room = strtoupper($pre_room); 
    }
}
$u_id = strtolower($uname.getName($n));
$user_agent = getenv("HTTP_USER_AGENT");

$sql_check ="SELECT * FROM `players` WHERE uname = '$uname' and room='$pre_room'";
$result = mysqli_query($con,$sql_check);
$row_num = mysqli_num_rows($result);

if($row_num <=0 ){
    $sql = "INSERT INTO `players` (`uname`,`u_id`,`player_type`,`user_agent`, `room`) VALUES ('$uname','$u_id','$player_type','$user_agent','$room') ";
    if(mysqli_query($con,$sql)){
        $_SESSION['uname']=$uname;
        $_SESSION['room']=$room;
        echo "ok";
    }else{
        echo "SQL Error";
    }
}else{  
    echo "User already present in room";
}
?>