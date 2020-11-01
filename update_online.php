<?php
session_start();
include "db.php";

$current_date = floor(gettimeofday(true));

$sql = "UPDATE `players` SET `online_status`='$current_date' WHERE u_id = '".$_SESSION['u_id']."'";
if(!mysqli_query($con,$sql)){
    echo "failed to update online status";
}

?>