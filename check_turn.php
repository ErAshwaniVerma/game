<?php
session_start();
include "db.php";

$sql_start_btn = "select * from `rooms` where room_id = '".$_SESSION['room']."' and host = '".$_SESSION['u_id']."'";
$result_start_btn= mysqli_query($con,$sql_start_btn);
$row_start_btn = mysqli_fetch_array($result_start_btn);
$row_start_btn_num = mysqli_num_rows($result_start_btn);

$sql_start_btn_2 = "select * from `pLayers` where room = '".$_SESSION['room']."' and u_char = 'king'";
$result_start_btn_2= mysqli_query($con,$sql_start_btn_2);
$row_start_btn_2_num = mysqli_num_rows($result_start_btn_2);

$sql_start_btn_3 = "select * from `pLayers` where room = '".$_SESSION['room']."' and u_id = '".$_SESSION['u_id']."'";
$result_start_btn_3= mysqli_query($con,$sql_start_btn_3);
$row_start_btn_3 = mysqli_fetch_array($result_start_btn_3);

if($row_start_btn_2_num <= 0 ){  //if there is no king
	if($row_start_btn_num >= 1){
		echo "host";
	}else{							// if there is no Host
		echo "not_host";
	}
}else{											// if there is any king
	if($row_start_btn_3['u_char'] == 'king'){
	    echo "king";
	}else{
	    echo "no_king";
	}
}
?>