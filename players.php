<?php
session_start();
include "db.php";
$current_date = (floor(gettimeofday(true))-3);

$sql = "SELECT * FROM `players` WHERE room = '".$_SESSION['room']."' and online_status >= '$current_date'";
$result = mysqli_query($con,$sql);
$row_num = mysqli_num_rows($result);
$id = array("one","two","three","four");
$n = 0;

if($row_num <= 0){
    ?>
    <div class="" style="padding:20px;color:#999;text-align:center;width:100%;">
        Empty
    </div>
    <?php
}else{
    while($row = mysqli_fetch_array($result)){
        if(($n % 2) == 0){
            echo "<div class='row'>";
        }
        ?>
        <div style="background:green;" class="chits <?php echo $id[$n];?>" id="<?php echo $row['u_char'];?>">
            <table>
            <?php echo '<tr><td><h2>'.$row['uname'].'</h2></td></tr>';?>
            <?php if($row['u_char'] != 'thief' && $row['u_char'] != 'soldier'){echo '<tr><td><h5>('.ucfirst(strtolower($row['u_char'])).')</h5></td></tr>';}?>
            </table>
        </div>
        <?php
        $n++;
        if(($n % 2) == 0){
            echo "</div>";
        }
    }
}
?>