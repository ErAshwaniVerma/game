<?php
session_start();
include "db.php";
$uname = $_REQUEST['uname'];

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
$u_id = strtolower($uname.getName($n));
$user_agent = 'user_'.$u_id;
setcookie('user_agent', $user_agent, time() + (86400 * 30), "/");


$sql_check ="SELECT * FROM `players` WHERE u_id = '$u_id'";
$result = mysqli_query($con,$sql_check);
$row_num = mysqli_num_rows($result);

if($row_num <=0 ){
    $sql = "INSERT INTO `players` (`uname`,`u_id`,`u_char`,`user_agent`, `room`) VALUES ('$uname','$u_id','','$user_agent','') ";
    if(mysqli_query($con,$sql)){
        $_SESSION['uname']=$uname;
        $_SESSION['u_id']=$u_id;
        echo "ok";
    }else{
        echo "SQL Error";
    }
}else{  
    echo "User already exist";
}
?>