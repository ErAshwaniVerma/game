<?php
session_start();
include "db.php";
$current_date = (floor(gettimeofday(true))-3);
?>
<table>
    <tr>
        <?php 
            $sql_name = "SELECT * FROM `players` WHERE room = '".$_SESSION['room']."' and online_status >= '$current_date'";
            $result_name = mysqli_query($con,$sql_name);
            while($row_name = mysqli_fetch_array($result_name)){
                echo "<td style='background:orange;color:#000;font-size:15px;font-weight:bolder;'>".$row_name['uname']."</td>";
            }    
        ?>
    </tr>
    <?php
        $sql = "SELECT * FROM `scores` WHERE room_id = '".$_SESSION['room']."'";
        $result = mysqli_query($con,$sql);
        $f = 0;

        $w = 0;
        $x = 0;
        $y = 0;
        $z = 0;

        while($row = mysqli_fetch_array($result)){
            if(($f % 4) == 0){
                echo "<tr>";
            }
            if(($f % 4) == 0){
                $w = $w+$row['score'];
            }else if(($f % 4) == 1){
                $x = $x+$row['score'];
            }else if(($f % 4) == 2){
                $y = $y+$row['score'];
            }else if(($f % 4) == 3){
                $z = $z+$row['score'];
            }
            if(($f % 4) == 1 || ($f % 4) == 3){
                echo "<td style='background:#222;'>".$row['score']."</td>";
            }else{
                echo "<td>".$row['score']."</td>";
            }
            $f++;
            if(($f % 4) == 0){
                echo "</tr>";
            }                
        }
        echo "
        <tr>
            <td style='background:green;'>".$w."</td>
            <td style='background:green;'>".$x."</td>
            <td style='background:green;'>".$y."</td>
            <td style='background:green;'>".$z."</td>
        </tr>";
    ?>
</table>