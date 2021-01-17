<?php
session_start();
include "db.php";
include "style.php";
$current_date = floor(gettimeofday(true));
?>
<script src="jquery.js"></script>

<h1 id="score_board_time" >...</h1>
<script type="text/javascript">
    var score_hide_time = 5;
    setInterval(function(){
        document.getElementById('score_board_time').innerHTML= score_hide_time ;
        if(score_hide_time == 0){
            document.getElementById('score_board_time').innerHTML= "End" ;
            //update_game_status('abort');    
        }else{
            score_hide_time--;
        }
    },1000)
</script>