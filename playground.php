<?php 
session_start();
include "db.php";
include "style.php";
$sql = "select * from `rooms` where room_id = '".$_SESSION['room']."'";
$result= mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);

if(!isset($_SESSION['u_id']) && empty($_SESSION['u_id'])){
    ?>
    <script>
        document.location = "index.php";
    </script>
    <?php
}
?>
<div class="main_container">
    <button class="danger_btn" onclick="update_game_status(`abort`);">New Game</button>
    <button class="danger_btn" onclick="leave_game();">Leave Game</button>
    <!--<button class="danger_btn" style="background:dodgerblue;margin-right:10px;" onclick="shuffle();">Shuffle</button>-->
    <h3>Room Id : <?php echo $_SESSION['room'];?><br>Name : <?php echo $_SESSION['uname'];?></h3>
    <div class="player_container">

    </div>
    <h1 id="char_msg"></h1>
</div>
<div class="waiting_div">
    <div class="waiting_div_dialogue">
        <h1>Room ID : <?php echo $_SESSION['room']?></h1>
        <h3 class="waiting_player_counts">NaN</h3>
        <h2 id="waiting_msg">Waiting for other players...</h2><br>
        <div class="waiting_players_div">
        </div>
    </div><br>
    <?php 
        if($row['host'] == $_SESSION['u_id']){
        ?>
    <button class="start_button" onclick="update_game_status(`started`);" disabled="disabled">Start</button>
<?php }?>
</div>
<div class="dialogue_box">
    <div class="dialogue_box_content">
        <button class="close_dialogue_box" onclick="close_dialogue_box()" style="display:none;">&times;</button>
        <div class="character_div"></div>
        <div class="msg_div">
            <span id="char_name" style="font-size:25px;font-weight:bold;">King...</span><br><br>
            <span class="dialogue_msg" id="dialogue_msg">
            </span>
        </div>
    </div>
</div>
<script>
    window.onbeforeunload = function(){
        return "Dude, are you sure you want to leave?";
    }
    var shuffle_status,player_num,online_status,dialouge_status,game_status;
    var i = 0;
    var txt = '';
    var speed = 35;

    
    function display_another_dialogue(){
        i = 0;
        txt = "Your honor!! I'll bring that thief into your feet..";
        setTimeout(function(){
            $(".dialogue_box").css({"display":"none"});
            document.getElementById("char_name").innerHTML = "Minister...";
            $(".dialogue_box").css({"display":"flex"});
            document.getElementById("dialogue_msg").innerHTML = "";
            $(".character_div").css({"background":"url(imgs/minister.png) no-repeat center"});
            $(".character_div").css({"background-size":"85%"});
            typeWriter();
            dialouge_status = false;
            console.log(txt.length);
            setTimeout(function(){
                close_dialogue_box()
            },4000);
        },2000);
    }
    function typeWriter(){
        if(i < txt.length){
            document.getElementById("dialogue_msg").innerHTML += txt.charAt(i);
            i++;
            setTimeout(typeWriter, speed);
        }else{
            $(".close_dialogue_box").show();
            if(dialouge_status != false){
                display_another_dialogue();
            }
        }

    }
    function start_game(a){
        dialouge_status = true;
        $(".waiting_div").hide();
        <?php
        if($row['host'] == $_SESSION['u_id']){
        ?>
        shuffle();
    <?php }?>
        i = 0;
        txt = 'Help!,Help!..!!, Someone stole my gold from my castle.., he who will find the thief, will be rewarded with 10 gold bricks..';
        $(".dialogue_box").css({"display":"none"});
        document.getElementById("char_name").innerHTML = "King...";
        $(".dialogue_box").css({"display":"flex"});
        document.getElementById("dialogue_msg").innerHTML = "";
        $(".character_div").css({"background":"url(imgs/king.png) no-repeat center"});
        $(".character_div").css({"background-size":"85%"});
        typeWriter();
    }
    function abort_game(a){
        dialouge_status = false;
        $(".waiting_div").show();
        $(".dialogue_box").css({"display":"none"});
        update_shuffle('');
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
                        if(this.responseText == "started"){
                            if(game_status != this.responseText){
                                start_game();
                                game_status = "started";
                            }
                        }else if(this.responseText == "abort"){
                            if(game_status != this.responseText){
                                abort_game();
                                game_status = "abort";
                            }
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
        $("#king").css({"background-color":"orange"});
        $("#king").css({"background":"url(imgs/king.png)center no-repeat"});
        $("#king").css({"background-size":"50%"});
        $("#king").css({"background-position":"90px"});

        $("#minister").css({"background":"purple"});
        $("#minister").css({"background":"url(imgs/minister.png)center no-repeat"});
        $("#minister").css({"background-size":"50%"});
        $("#minister").css({"background-position":"90px"});
    }
    function check_new_player(){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(this.responseText != player_num){
                    player_num = this.responseText;
                    $(".player_container").load("players.php");
                    $(".waiting_players_div").load("players_waiting.php");
                    /*setTimeout(function(){
                        $('.waiting_div').show();
                    },1000);*/
                    console.log(this.responseText);
                    console.log(player_num);
                }
            }
        }
        req.open("POST" , "check_new_player.php", true);
        req.send();
    }

    function check_player_char(){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(this.responseText == 'minister'){
                    document.getElementById("char_msg").innerHTML = "Who is the Thief..?";
                    $("#soldier").attr("onclick","check_thief('not_ok')");
                    $("#thief").attr("onclick","check_thief('ok')");
                }else{
                    $(".chits").attr("disabled",true);
                    document.getElementById("char_msg").innerHTML = "";
                }
            }
        }
        req.open("POST" , "check_player_char.php", true);
        req.send();
    }
    function check_thief(a){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(this.responseText == 'ok'){
                    i = 0;
                    if(a == 'ok'){
                        txt = "Well done minister...";
                        $(".dialogue_box").css({"display":"none"});
                        document.getElementById("char_name").innerHTML = "King...";
                        $(".dialogue_box").css({"display":"flex"});
                        document.getElementById("dialogue_msg").innerHTML = "";
                        $(".character_div").css({"background":"url(imgs/king.png) no-repeat center"});
                        $(".character_div").css({"background-size":"85%"});
                        typeWriter();
                        setTimeout(function(){
                            update_game_status("abort");
                        },3000);
                        dialouge_status = false;
                    }else if(a == 'not_ok'){
                        txt = "You got the wrong guy..";
                        $(".dialogue_box").css({"display":"none"});
                        document.getElementById("char_name").innerHTML = "King...";
                        $(".dialogue_box").css({"display":"flex"});
                        document.getElementById("dialogue_msg").innerHTML = "";
                        $(".character_div").css({"background":"url(imgs/king.png) no-repeat center"});
                        $(".character_div").css({"background-size":"85%"});
                        typeWriter();
                        setTimeout(function(){
                            update_game_status("abort");
                        },3000);
                        dialouge_status = false;
                    }
                }
            }
        }
        req.open("POST" , "update_winnings.php?q="+a, true);
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
    var game_status_interval = setInterval(function(){
        check_game_status();
    },1000);

    setInterval(function(){
        check_new_player();
        update_online_status();
        check_shuffle_status();
        check_player_char();
        $(".waiting_player_counts").html(player_num+"/4");
        if(player_num == 4){
            //start_game();
            $(".start_button").prop("disabled",false);
            $("#waiting_msg").html("All players are ready!");
            $(".start_button").css({"opacity":"1"});
        }else{
            $("#waiting_msg").html("Waiting for other players...");
        }
    },1000);
</script>