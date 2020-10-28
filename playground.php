<meta name="viewport" content="width=device-width,initial-scale=1"/>
<?php 
session_start();
include "db.php";
include "style.php";
?>

<h1>Room Id " <?php echo $_SESSION['room'];?> "</h1>
<div class="player_container">

</div>
<script>
    var player_num = "";
     function check_new_player(){
            var req = new XMLHttpRequest();
            req.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    if(this.responseText != player_num){
                        player_num = this.responseText;
                        $(".player_container").load("players.php");
                    }
                }
            }
            req.open("POST" , "check_new_player.php", true);
            req.send();
        }

    setInterval(function(){
        check_new_player();
    },1000);
</script>