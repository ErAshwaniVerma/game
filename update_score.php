<?php
session_start();
include "db.php";

$current_date = (floor(gettimeofday(true))-6);
$sql_room = "SELECT * FROM `rooms` WHERE room_id = '".$_SESSION['room']."'";
$result_room = mysqli_query($con,$sql_room);
$row_room = mysqli_fetch_array($result_room);

$sql_players = "SELECT * FROM `players` WHERE room = '".$_SESSION['room']."' and online_status >= '".$current_date."'";
$result_players = mysqli_query($con,$sql_players);
while($row_players = mysqli_fetch_array($result_players)){
	if($row_room['winning_status'] == 'win'){
		if($row_players['u_char'] == 'king'){
			$score = 1000;
		}else if($row_players['u_char'] == 'minister'){
			$score = 500;			
		}else if($row_players['u_char'] == 'soldier'){
			$score = 100;			
		}else if($row_players['u_char'] == 'thief'){
			$score = 0;			
		}
	}else if($row_room['winning_status'] == 'lose'){
		if($row_players['u_char'] == 'king'){
			$score = 1000;
		}else if($row_players['u_char'] == 'minister'){
			$score = 0;
		}else if($row_players['u_char'] == 'soldier'){
			$score = 100;			
		}else if($row_players['u_char'] == 'thief'){
			$score = 500;			
		}
	}
	$sql = "INSERT INTO `scores`(`u_id`, `room_id`, `score`) VALUES ('".$row_players['u_id']."','".$row_players['room']."','$score')";

	if(!mysqli_query($con,$sql)){
	    echo "Failed to update score.";
	}else{
		echo "ok";
	}
}

?>