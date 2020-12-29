<?php
session_start();
include "db.php";

$win_status = $_REQUEST['q'];
$sql_players = "SELECT * FROM WHERE room = '".$_SESSION['room']."'";
$result_players = mysqli_query($con,$sql_players);


$current_date = (floor(gettimeofday(true))-6);

if($win_status == "win"){
	$sql_2 = "UPDATE `rooms` SET `winning_status`='win',`score_board_status` = 'true' WHERE room_id = '".$_SESSION['room']."'";
	if(mysqli_query($con,$sql_2)){
		echo "win";
	}else{
		echo "Winning SQL Error";
	}
}else if($win_status == "lose"){
	$sql_3 = "UPDATE `rooms` SET `winning_status`='lose',`score_board_status` = 'true' WHERE room_id = '".$_SESSION['room']."'";
	if(mysqli_query($con,$sql_3)){
		echo "lose";
	}else{
		echo "Losing SQL Error";
	}
}else if($win_status == "null"){
	$sql_3 = "UPDATE `rooms` SET `winning_status`='',`score_board_status` = 'false' WHERE room_id = '".$_SESSION['room']."'";
	if(mysqli_query($con,$sql_3)){
		echo "null";
	}else{
		echo "Null SQL Error";
	}
}

?>