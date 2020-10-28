<?php
session_start();
include "db.php";
$sql = "SELECT * FROM `players` WHERE room = '".$_SESSION['room']."'";
$result = mysqli_query($con,$sql);
$row_num = mysqli_num_rows($result);

if($row_num <= 0){
    ?>
    <div class="" style="padding:20px;color:#999;text-align:center;">
        Empty
    </div>
    <?php
}else{
    while($row = mysqli_fetch_array($result)){
        ?>
        <div class="chits">
            <?php echo $row['uname']; 
            
            if($row['player_type'] == "host"){
                echo " (".$row['player_type'].")";
            }
            
            ?>
        </div>
        <?php
    }
}
?>