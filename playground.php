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
<body class="body">
<div class="main_container playground_container" style="opacity:0;">
    <?php 
        if($row['host'] == $_SESSION['u_id']){
    ?>
    <button class="playground_nav_btn" style="background:#0d7;" onclick="update_game_status(`abort`);">New Game</button>
    <?php
    }
    ?>
    <button class="playground_nav_btn" onclick="leave_game();">Leave Game</button>
    <!--<button class="danger_btn" style="background:dodgerblue;margin-right:10px;" onclick="shuffle();">Shuffle</button>-->
    <h3>Room Id : <?php echo $_SESSION['room'];?><br>Name : <?php echo $_SESSION['uname'];?></h3>
    <div class="player_container" style="color:#fff;">

    </div>
    <h1 id="char_msg" style="text-align: center;"></h1>
</div>
<div class="waiting_div">
    <div class="waiting_div_dialogue">
        <div class="waiting_div_room_info">
            <h1>Name : <?php echo $_SESSION['uname']?></h1>
            <h3>Room ID : <?php echo $_SESSION['room']?></h3>
        </div>
        <h5 id="waiting_msg">Waiting for other players...</h5>
        <p class="waiting_player_counts" style="text-align: center;">NaN</p>
        <div class="waiting_players_div" style="width:300px;">
        </div>
        <button class="playground_nav_btn" onclick="leave_game();">Leave Game</button>
    </div><br>
    <button class="start_button" onclick="update_game_status(`started`);" disabled="disabled">Start</button>
</div>
<div class="dialogue_box" style="display: none;">
    <div class="dialogue_box_content">
       <!-- <button class="close_dialogue_box" onclick="close_dialogue_box()" style="display:none;">&times;</button>-->
        <div class="character_div"></div>
        <div class="msg_div">
            <span id="char_name" style="font-size:25px;font-weight:bold;">King...</span><br><br>
            <span class="dialogue_msg" id="dialogue_msg">
            </span>
        </div>
    </div>
</div>

<div class="score_board_bg">
    <div class="score_board">
    </div>
</div>



<script>
    window.onbeforeunload = function(){
        return "Dude, are you sure you want to leave?";
    }
    var shuffle_status,player_num,online_status,dialouge_status,game_status;
    var i = 0;
    var txt = '';
    var speed = 25;
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
                $(".main_container").css({"opacity":"1"});
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
        update_winnings('null');
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
        $(".main_container").css({"opacity":"0"});
        update_winnings('null');
        dialouge_status = false;
        $(".waiting_div").show();
        $(".waiting_players_div").load("players_waiting.php");
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
        $("#king").css({"background-position":"60px"});

        $("#minister").css({"background":"purple"});
        $("#minister").css({"background":"url(imgs/minister.png)center no-repeat"});
        $("#minister").css({"background-size":"50%"});
        $("#minister").css({"background-position":"60px"});
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
                    show_main_chits();
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
                    $("#soldier").attr("onclick","update_winnings('lose')");
                    $("#thief").attr("onclick","update_winnings('win')");
                }else{
                    $(".chits").attr("disabled",true);
                    document.getElementById("char_msg").innerHTML = "Minister finding the thief..";
                }
            }
        }
        req.open("POST" , "check_player_char.php", true);
        req.send();
    }

    function update_score(){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(this.responseText != "ok"){
                    //alert(this.responseText);
                }
            }
        }
        req.open("POST" , "update_score.php", true);
        req.send();
    }
    function update_winnings(a){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(this.responseText != "null"){
                        update_score();
                    setTimeout(function(){
                        setTimeout(function(){
                            update_game_status('abort');
                        },8000);
                    },4000);
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

    function check_winning_status(){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(this.responseText == "win"){
                    $(".w_r_d_thief").css({"opacity":"1"});
                    $(".w_r_d_thief").html("Correct");

                    $(".w_r_d_soldier").css({"opacity":"0"});
                    $(".w_r_d_soldier").html("Wrong");
                }else if(this.responseText == "lose"){
                    $(".w_r_d_soldier").css({"opacity":"1"});
                    $(".w_r_d_soldier").html("Wrong");

                    $(".w_r_d_thief").css({"opacity":"0"});
                    $(".w_r_d_thief").html("Correct");
                }
            }
        }
        req.open("POST" , "check_winnings.php", true);
        req.send();
    }

    function check_score_board_status(){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(this.responseText == "true"){
                    setTimeout(function(){
                        $(".score_board_bg").css({"display":"flex"});
                        $(".score_board").load("score_table.php");
                    },3000);
                }else if(this.responseText == "false"){
                    $(".score_board_bg").css({"display":"none"});
                }
            }
        }
        req.open("POST" , "check_score_board_status.php", true);
        req.send();
    }

    function check_internet(){
        return true;//(navigator.onLine);
    }
    var game_status_interval = setInterval(function(){
        check_game_status();
    },1000);

    function check_turn(){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(this.responseText == "host" || this.responseText == "king"){
                    $(".start_button").css({"opacity":"1"});
                }else{
                    $(".start_button").css({"opacity":"0"});
                }
            }
        }
        req.open("POST" , "check_turn.php", true);
        req.send();
    }
    setInterval(function(){
        check_turn();
        check_new_player();
        update_online_status();
        check_shuffle_status();
        check_player_char();
        check_winning_status();
        check_score_board_status();
        $(".waiting_player_counts").html(player_num+"/4");
        if(player_num == 4){
            //start_game();
            $(".start_button").prop("disabled",false);
            $("#waiting_msg").html("All players are ready!");
            $(".start_button").css({"background":"dodgerblue"});
        }else{
            $("#waiting_msg").html("Waiting for other players...");
            $(".start_button").css({"background":"#999"});
        }
    },1000);
</script>
</body>