<?php 
session_start();
include "db.php";
include "style.php";
if(!isset($_SESSION['u_id']) && empty($_SESSION['u_id'])){
    ?>
    <script>
        document.location = "index.php";
    </script>
    <?php
}
?>
<div class="main_container">
    <button class="danger_btn" onclick="leave_game();">Leave Game</button>
    <button class="danger_btn" style="background:dodgerblue;margin-right:10px;" onclick="shuffle();">Shuffle</button>
    <h3>Room Id : <?php echo $_SESSION['room'];?><br>Name : <?php echo $_SESSION['uname'];?></h3>
    <div class="player_container">

    </div>
</div>
<div class="waiting_div">
    <div class="waiting_div_dialogue">
        <h3 class="waiting_player_counts">NaN</h3>
        <h2>Waiting for other players...</h2><br>
        <div class="waiting_players_div">
        </div>
    </div><br>
    <button class="start_button" onclick="update_game_status(`true`);" disabled="disabled">Start</button>
</div>
<div class="dialogue_box">
    <button class="skip_dialogue_box" onclick="skip_typing();">Skip</button>
    <button class="close_dialogue_box" onclick="close_dialogue_box()" style="display:none;">Close</button>
    <div class="character_div"></div>
    <div class="msg_div">
        <span style="font-size:25px;font-weight:bold;">King... </span><br><br>
        <span class="dialogue_msg" id="dialogue_msg">
        </span>
    </div>
</div>
<script>
    window.onbeforeunload = function(){
        return "Dude, are you sure you want to leave?";
    }
var shuffle_status,player_num,online_status,dialouge_status,game_status;
    var i = 0;
    var txt = 'Help!,Help!..!!, Someone stole my gold from my castle.., he who will find the thief, will be rewarded with 10 gold bricks..';
    var speed = 50;
    function typeWriter(){
        if(i < txt.length){
            document.getElementById("dialogue_msg").innerHTML += txt.charAt(i);
            i++;
            setTimeout(typeWriter, speed);
        }else{
            $(".skip_dialogue_box").hide();
            $(".close_dialogue_box").show();
        }
    }
    function start_game(a){
        $(".waiting_div").hide();
        setTimeout(function(){
            $(".dialogue_box").css({"display":"flex"});
            typeWriter();
        },500);
    }

    function skip_typing(){
        speed = 0;
    }
    function close_dialogue_box(){
        $(".dialogue_box").fadeOut(100);
    }
    function leave_game(){
        if(check_internet()){
            document.location = "leave_game.php";
        }else{
            alert("Internet not connected..");
        }
    }
    function get_online_status(){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(this.responseText == "ok"){
                    online_status = "true";
                }else{
                    //alert(this.responseText);
                    online_status = "false";
                }
            }
        }
        req.open("POST" , "get_online.php", true);
        req.send();
    }
    function check_shuffle_status(){
            var req = new XMLHttpRequest();
            req.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    if(this.responseText != shuffle_status){
                        if(this.responseText == "true"){
                            $(".player_container").load("players.php");
                            setTimeout(function(){
                                show_main_chits();
                                shuffle_status = "false";
                                update_shuffle('false');
                            },1500);
                        }
                    }
                }
            }
            req.open("POST" , "check_shuffle.php", true);
            req.send();
    }
    function check_game_status(){
            var req = new XMLHttpRequest();
            req.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    if(this.responseText != game_status){
                        if(this.responseText == "true"){
                            start_game();
                            game_status = "false";
                            update_game_status('false');
                        }
                    }
                }
            }
            req.open("POST" , "check_game.php", true);
            req.send();
    }
    function shuffle(){
        if(check_internet()){
            get_online_status();
            setTimeout(function(){
                if(online_status == "true"){
                    var req = new XMLHttpRequest();
                    req.onreadystatechange = function(){
                        if(this.readyState == 4 && this.status == 200){
                            if(this.responseText != "abort"){
                                update_shuffle(`true`);
                                if($(".player_container").load("players.php")){
                                }
                            }else{
                                alert("Insufficient Players");
                            }
                        }
                    }
                    req.open("POST" , "shuffle_players.php", true);
                    req.send();
                }else{
                    alert("All pLayers are not connected..");
                }
            },1000);
        }else{
            alert("Internet not connected");
        }
    }
    function update_shuffle(a){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                //alert(this.responseText);
            }
        }
        req.open("POST" , "update_shuffle.php?st="+a, true);
        req.send();
    }
    function update_game_status(a){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                //alert(this.responseText);
            }
        }
        req.open("POST" , "update_game_status.php?st="+a, true);
        req.send();
    }
    function show_main_chits(){
        $("#king").css({"background":"orange"});
        $("#minister").css({"background":"purple"});
    }
    function check_new_player(){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(this.responseText != player_num){
                    player_num = this.responseText;
                    $(".player_container").load("players.php");
                    $(".waiting_players_div").load("players.php");
                }
            }
        }
        req.open("POST" , "check_new_player.php", true);
        req.send();
    }
    function update_online_status(){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
            }
        }
        req.open("POST" , "update_online.php", true);
        req.send();
    }
    function check_internet(){
        return true;//(navigator.onLine);
    }

    setInterval(function(){
        check_new_player();
        update_online_status();
        check_shuffle_status();
        check_game_status();
        $(".waiting_player_counts").html(player_num+"/4");
        if(player_num == 2 && dialouge_status != false){
            //start_game();
           $(".start_button").prop("disabled",false);
           $(".start_button").css({"opacity":"1"});
            dialouge_status = false;
        }
    },1000);
</script>