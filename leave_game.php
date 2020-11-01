<?php
session_start();
include "db.php";
include "style.php";

$sql = "UPDATE `players` SET `room`='' WHERE u_id = '".$_SESSION['u_id']."'";
if(!mysqli_query($con,$sql)){
    echo "Error while leaving..";
}else{
    session_destroy();
    ?>
    <script>
        document.location = "index.php";
    </script>
    <?php
}
?>
<h1>Leaving...</h1>
