<?php
session_start();
include "db.php";

$win_status = $_REQUEST['q'];

$current_date = (floor(gettimeofday(true))-3);

if($win_status == "ok"){
	$sql_2 = "UPDATE `rooms` SET `winning_status`='win' WHERE room_id = '".$_SESSION['room']."'";
	if(mysqli_query($con,$sql_2)){
		echo "ok";
	}else{
		echo "Winning SQL Error";
	}
}else{
	$sql_3 = "UPDATE `rooms` SET `winning_status`='lose' WHERE room_id = '".$_SESSION['room']."'";
	if(mysqli_query($con,$sql_3)){
		echo "ok";
	}else{
		echo "Losing SQL Error";
	}
}

?>