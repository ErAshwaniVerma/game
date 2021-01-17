<?php 
session_start();
include "db.php";
$u_char = array("king","soldier","minister","thief");
$n = 0;
$current_date = (floor(gettimeofday(true))-6);

$sql = "SELECT * FROM `players` WHERE room = '".$_SESSION['room']."' and online_status >= '$current_date'  ORDER BY RAND()";
$result = mysqli_query($con,$sql);
$row_num = mysqli_num_rows($result);

if($row_num == 4){
    while($row = mysqli_fetch_array($result)){
        $sql_update = "UPDATE `players` SET `u_char`='".$u_char[$n]."' WHERE u_id='".$row['u_id']."'";
        if(!mysqli_query($con,$sql_update)){
            echo "Update u_char error";
        }
        $n++;
    }
}else{
    echo "abort";
}
?>