<?php
session_start();
include "db.php";

$sql_start_btn = "select * from `pLayers` where room = '".$_SESSION['room']."' and u_id = '".$_SESSION['u_id']."'";
$result_start_btn= mysqli_query($con,$sql_start_btn);
$row_start_btn = mysqli_fetch_array($result_start_btn);

if($row_start_btn['u_char'] == 'king'){
    echo "ok";
}else{
    echo "no_ok";
}
?>