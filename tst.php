<?php
session_start();
include "db.php";
include "style.php";
$current_date = floor(gettimeofday(true));
?>
<script src="jquery.js"></script>
<style type="text/css">
    .score_board_bg{
        width: 100%;
        height: 100%;
        position: fixed;
        top:0px;
        left: 0px;
        text-align: center;
        align-items: center;
        justify-content: center;
        display: flex;
        backdrop-filter:blur(10px);
        background:rgba(0,0,0,0.5);
    }
    .score_board{
        position: absolute;
        left:0px;
        right:0px;
        align-items: center;
        justify-content: center;
        display: flex;
    }
    .score_board table tr td{
        text-align: center;
        border:0.1px solid #888;
        padding:18px;
        margin:auto;
    }
</style>
asldkjas
dasdhkasd
asdjasjkld
<div class="score_board_bg">
    <div class="score_board">
        <table>
            <tr>
                <?php 
                    $sql_name = "SELECT * FROM `players` WHERE room = '".$_SESSION['room']."'";
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
    </div>
</div>
