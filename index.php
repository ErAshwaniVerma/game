<?php
session_start();
include "db.php";
$user_agent = getenv("HTTP_USER_AGENT");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <?php
    include "style.php";
    ?>
</head>
<body>
    <div class="main_container">
        <div class="main">
            <div class="card">
                <h1>Chor Sipahi</h1>
                <p>Let's do fun</p>
                <br>
                <button onclick="show_modal(`player_modal`);">Join Game</button>
                <br><br>
                <button onclick="show_modal(`host_modal`);">Host Game</button>
                <br><br>
                <h3 style="margin-bottom:0px;">Hosted Rooms :</h3>
                <br>
                <?php
                    $sql = "SELECT * FROM `players` WHERE user_agent = '$user_agent'";
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
                            <div class="" style="padding:10px;border:2px solid #444;border-radius:10px;margin-bottom:5px;cursor:pointer;">
                                <?php echo $row['room'];?>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
        </div>
    </div>

    <div class="modal" id="host_modal">
        <div class="modal_dialog">
            <h1 class="modal_heading">Host Game</h1>
            <br>
            <label>Enter your name :</label><br>
            <input type="text" placeholder="Text here..." id="host_name" autocomplete="off">
            <br><br>
            <button class="modal_btn" onclick="create_player(`host`)">Proceed</button>
            <br><br>
            <button class="modal_close_btn" onclick="close_modal();">Back</button>
        </div>
    </div>

    <div class="modal" id="player_modal">
        <div class="modal_dialog">
            <h1 class="modal_heading">Join Game</h1>
            <br>
            <label>Enter your name :</label><br>
            <input type="text" id="player_name" autocomplete="off"><br><br>
            <label>Enter Room ID :</label><br>
            <input type="text" id="room_id" autocomplete="off" style="text-transform:uppercase;" min-length="4">
            <br><br>
            <button class="modal_btn" onclick="create_player(`player`)">Join</button>
            <br><br>
            <button class="modal_close_btn" onclick="close_modal();">Back</button>
        </div>
    </div>

    <script>
        function show_modal(modal_name){  
            $("#"+modal_name+"").css({"display":"flex"});
        }
        function close_modal(){
            $(".modal").css({"display":"none"});
        }

        function create_player(player_type){
            var req = new XMLHttpRequest();
            var uname,pre_room;
            if(player_type == "host"){
                uname = document.getElementById("host_name").value;
                pre_room = ""
            }else{
                uname = document.getElementById("player_name").value;
                pre_room = document.getElementById("room_id").value;
            }
            if(uname != ""){
                req.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        if(this.responseText == "ok"){
                            document.location = "playground.php";
                        }else{
                            alert(this.responseText);
                        }
                    }
                }
                req.open("POST" , "create_player.php?uname="+uname+"&player_type="+player_type+"&pre_room="+pre_room, true);
                req.send();
            }else{
                alert("Fill out all text fields")
            }
        }
    </script>
</body>
</html>