<?php
session_start();
include "db.php";
$user_agent = $_COOKIE['user_agent'];

$sql_check_uagt = "SELECT * FROM `players` WHERE user_agent = '$user_agent'";
$result_check_uagt = mysqli_query($con,$sql_check_uagt);
$row_num_check_uagt = mysqli_num_rows($result_check_uagt);

if($row_num_check_uagt >= 1 ){
    while($row_check_uagt = mysqli_fetch_array($result_check_uagt)){
        $_SESSION['uname']=$row_check_uagt['uname'];
        $_SESSION['u_id']=$row_check_uagt['u_id'];
    }
}
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
            <div class="card" id="main_card">
                <h1>Hey! <?php echo $_SESSION['uname'];?></h1>
                <h3>Who is the thief..?<br>
                    Let's find out..</h3>
                <br><br>
                <button onclick="show_modal(`player_modal`);">Join Game</button>
                <br><br>
                <button onclick="create_room();">Host Game</button>
                <br><br>
                <h3 style="margin-bottom:0px;">Hosted Rooms :</h3>
                <br>
                <?php
                    $sql = "SELECT * FROM `rooms` WHERE user_agent = '$user_agent' ";
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
                            <div class="" style="padding:10px;border:2px solid #444;border-radius:10px;margin-bottom:5px;cursor:pointer;" onclick="join_room(`<?php echo $row['room_id'];?>`)" >
                                <?php echo $row['room_id'];?>
                                <span style="float:right;" id="<?php echo $row['room_id']?>">⋄</span>
                            </div>
                            <script>
                                setInterval(function(){
                                    var req = new XMLHttpRequest();
                                    var room = "<?php echo $row['room_id']; ?>";
                                    req.onreadystatechange = function(){
                                        if(this.readyState == 4 && this.status == 200){
                                            document.getElementById("<?php echo $row['room_id'];?>").innerHTML=this.responseText+"/4";
                                        }
                                    }
                                    req.open("POST", "check_player_num.php?room_id="+room ,true);
                                    req.send();
                                },1000);
                            </script>
                            <?php
                        }
                    }
                ?>
            </div>
        </div>
    </div>

    <div class="modal" id="player_modal">
        <div class="modal_dialog">
            <h1 class="modal_heading">Join Game</h1>
            <br>
            <label>Enter Room ID :</label><br><br>
            <input type="text" id="room_id" autocomplete="off" style="text-transform:uppercase;" min-length="4">
            <br><br>
            <button class="modal_btn" onclick="join_room()">Join</button>
            <br><br>
            <button class="modal_close_btn" onclick="close_modal();">Back</button>
        </div>
    </div>
    <div class="modal" id="welcome_modal">
        <div class="modal_dialog">
            <h1 class="modal_heading">Welcome pal...</h1>
            <br>
            <label>Enter your name :</label><br><br>
            <input type="text" placeholder="Text here..." id="new_player_name" autocomplete="off">
            <br><br>
            <button class="modal_btn" style="background:dodgerblue;" onclick="create_player()">Submit</button>
        </div>
    </div>
    <script>
        function show_modal(modal_name){  
            $("#"+modal_name+"").css({"display":"flex"});
        }
        function close_modal(){
            $(".modal").css({"display":"none"});
            document.getElementById("room_id").value = "";
        }
        $(window).ready(function(){
            check_new_player();
        });
        function check_new_player(){
            var req = new XMLHttpRequest();
            req.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    if(this.responseText == "not_ok"){
                        $("#welcome_modal").css({"display":"flex"});
                    }
                    console.log(this.responseText);
                }
            }
            req.open("POST", "check_player_data.php" ,true);
            req.send();
        }
        function create_player(){
            var req = new XMLHttpRequest();
            var uname = document.getElementById("new_player_name").value;
            req.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    if(this.responseText == "ok"){
                        location.reload();
                    }else{
                        alert(this.responseText);
                    }
                }
            }
            req.open("POST", "create_player.php?uname="+uname ,true);
            req.send();
        }
        function create_room(){
            var req = new XMLHttpRequest();
            req.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    if(this.responseText == "ok"){
                        document.location = "playground.php";
                    }else{
                        alert(this.responseText);
                    }
                }
            }
            req.open("POST", "create_room.php" ,true);
            req.send();
        }
        function join_room(room){
            var req = new XMLHttpRequest();
            var room_id_field = document.getElementById("room_id").value;
            if(room_id_field != ""){
                room = room_id_field;
            }
            req.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    if(this.responseText == "ok"){
                        document.location = "playground.php";
                    }else{
                        alert(this.responseText);
                    }
                }
            }
            req.open("POST", "join_room.php?room="+room ,true);
            req.send();
        }
    </script>
</body>
</html>