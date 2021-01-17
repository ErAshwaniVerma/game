<meta name="viewport" content="width=device-width,initial-scale=1"/>
<style>
    ::-webkit-scrollbar{
        appearance:none;
        width:5px;
    }
    ::-webkit-scrollbar-track{
        background:transparent;
    }
    ::-webkit-scrollbar-thumb{
        background:#444;
    }
    @font-face {
        font-family: universal;
        src: url(fonts/Acme-Regular.ttf);
    }
    body{
        background:url(imgs/castle.png) center no-repeat;
        background-size:cover;
        font-family:universal;
    }
    .main_container{
        border-radius: 10px;
        margin-left:20%;
        margin-right:20%;
        position:relative;
    }
    .playground_container{
        box-shadow: 4px 4px 10px rgba(0,0,0,0.5);
        background: rgba(255,255,255,0.5);
        backdrop-filter:blur(4px);
        padding:10px;
    }
    .main{
        min-height:100vh;
        justify-content:center;
        align-items:center;
        display:flex;
    }
    .playground_nav_btn{
        box-shadow: 4px 4px 10px rgba(0,0,0,0.5),
                    inset -4px -4px 10px rgba(0,0,0,0.5),
                    inset 4px 4px 10px rgba(255,255,255,0.5);
        padding:10px;
        margin:auto;
        border:0px;
        font-weight: bolder;
        border-radius:50px;
        font-size:15px;
        background:dodgerblue;
        color:#fff;
        outline: none;
        float:right;
    }
    .playground_nav_btn:active{
        box-shadow: 1px 1px 4px rgba(0,0,0,0.5),
                    inset -1px -1px 4px rgba(0,0,0,0.5),
                    inset 1px 1px 4px rgba(255,255,255,0.5);
        transform: translateY(4px);
    }
    .card{
        padding:20px;
        background:rgba(255,255,255,0.7);
        backdrop-filter:blur(4px);
        width:300px;
        margin:auto;
        color:#333;
        border-radius:10px 200px 10px 10px;
        box-shadow:0px 4px 25px rgba(0,0,0,0.3);
        position: relative;
    }
    .card:before{
        content:'';
        position: absolute;
        top:0px;
        right:0px;
        width: 60px;
        height: 60px;
        background:rgba(255,255,255,0.7);
        box-shadow:0px 4px 25px rgba(0,0,0,0.3);
        backdrop-filter:blur(4px);
        border-radius: 50px;
    }
    .card:after{
        content:'';
        position: absolute;
        top:65px;
        right:0px;
        width: 25px;
        height: 25px;
        background:rgba(255,255,255,0.7);
        box-shadow:0px 4px 25px rgba(0,0,0,0.3);
        backdrop-filter:blur(4px);
        border-radius: 50px;
    }
    .card h1{
        margin-bottom:-15px;
    }
    input[type=text]{
        padding:15px;
        background:rgba(255,255,255,0.5);
        width:80%;
        margin:auto;
        font-size: 20px;
        text-align: center;
        box-shadow: inset 4px 4px 10px rgba(0,0,0,0.4),
                    inset -4px -4px 10px rgba(255,255,255,0.5),
                    4px 4px 10px rgba(0,0,0,0.6);
        border:0px;
        border-radius:50px;
        color:#333;
        outline:none;
        font-weight: bolder;
        position: relative;
    }
    input[type=text]:focus{
        box-shadow: inset 4px 4px 10px rgba(0,0,0,0.4),
                    inset -4px -4px 10px rgba(255,255,255,0.5),
                    6px 8px 15px red;
        text-shadow: 0px 0px 15px red;
    }
    .card button, .modal .modal_btn, .modal .modal_close_btn{
        padding:15px;
        background:dodgerblue;
        border:5px solid rgba(0,0,0,0.4);
        color:#fff;
        border-radius:50px;
        box-shadow: inset -4px -4px 10px rgba(0,0,0,0.4),
                    inset 4px 4px 10px rgba(255,255,255,0.5),
                    6px 8px 8px rgba(0,0,0,0.4);
        width:100%;
        font-size:20px;
        font-weight: bolder;
        text-shadow: 0px 0px 10px rgba(0,0,0,0.8);
        cursor:pointer;
        outline: none;
        font-family:universal;
    }
    .card button:focus , .modal .modal_btn:focus, .modal .modal_close_btn:focus{
        box-shadow: inset -4px -4px 10px rgba(0,0,0,0.4),
                    inset 4px 4px 10px rgba(255,255,255,0.5),
                    6px 8px 15px red;
        text-shadow: 0px 0px 15px red;
    }
    .card button:active , .modal .modal_btn:active, .modal .modal_close_btn:active{
        box-shadow: inset -1px -1px 5px rgba(0,0,0,0.4),
                    inset 1px 1px 5px rgba(255,255,255,0.6);
        transform: translateY(6px);
    }
    .modal{
        width:100%;
        height:100%;
        position:fixed;
        top:0px;
        left:0px;
        margin:auto;
        justify-content:center;
        align-items:center;
        display:none;
    }
    .modal .modal_dialog{
        width:300px;
        box-shadow:0px 4px 25px rgba(0,0,0,0.3);
        border-radius:10px 200px 10px 10px;
        background:rgba(255,255,255,0.7);
        backdrop-filter:blur(4px);
        padding:20px;
        text-align: center;
        position: relative;
    }
    .modal .modal_dialog:after{
        content:'';
        position: absolute;
        top:0px;
        right:0px;
        width: 60px;
        height: 60px;
        background:rgba(255,255,255,0.7);
        box-shadow:0px 4px 25px rgba(0,0,0,0.3);
        backdrop-filter:blur(4px);
        border-radius: 50px;
    }
    .modal .modal_dialog:before{
        content:'';
        position: absolute;
        top:65px;
        right:0px;
        width: 25px;
        height: 25px;
        background:rgba(255,255,255,0.7);
        box-shadow:0px 4px 25px rgba(0,0,0,0.3);
        backdrop-filter:blur(4px);
        border-radius: 50px;
    }
    .modal .modal_close_btn{
        background:#f33;
        color:#fff;
        width:100%;
        cursor:pointer;
    }
    .player_container{
        width:400px;
        margin:auto;
        color:#fff;
    }
    .wrong_right_div{
        width:100%;
        height: 100%;
        position: absolute;
        top:0px;
        left:0px;
        opacity:0;
        justify-content: center;
        display: flex;
        align-items: center;
        font-size: 25px;
        font-weight: bolder;

    }
    .w_r_d_thief{
        background: green;
    }
    .w_r_d_soldier{
        background:red;
    }
    .chits{
        background:orange;
        box-shadow: 2px 2px 4px rgba(0,0,0,0.5),
                     inset 2px 2px 4px rgba(255,255,255,0.5),
                     inset -2px -2px 4px rgba(0,0,0,0.5);
        display:flex;
        text-shadow: 0px 0px 5px rgba(0,0,0,0.8);
        font-weight: bolder;
        font-size: 16px;
        padding-top: 3%;
        padding-left: 3%;
        border-radius:10px;
        margin:5px;
        cursor:pointer;
        overflow: hidden;
        color:#fff !important;
        width:50%;
        height:100px;
        position: relative;
    }
    #char_name_for_chits{
        opacity: 0;
    }
    .row{
        display:flex;
    }
    .dialogue_box{
        width:100%;
        height: 100%;
        background: rgba(255,255,255,0.2);
        backdrop-filter:blur(10px);
        position: fixed;
        top:0px;
        left:0px;
    }
    .dialogue_box_content{
        width:40%;
        border-radius:10px;
        height:30%;
        background:rgba(255,255,255,0.5);
        position:absolute;
        box-shadow: inset 4px 4px 15px rgba(255,255,255,0.9),
                    inset -4px -4px 15px rgba(0,0,0,0.7),
                     4px 4px 15px rgba(0,0,0,0.6);
        bottom:10px;
        left:0px;
        right:0px;
        margin-left:auto;
        margin-right:auto;
        display:flex;
        overflow:hidden;
    }
    .msg_div{
        width:65%;
        height:90%;
        padding:20px 10px;
        z-index:99;
        overflow-y:scroll;
    }
    .character_div{
        background:url(imgs/king.png) center no-repeat;
        background-size:85%;
        width:35%;
        height:100%;
        right:0px;
        bottom:0px;
        position:absolute;
    }
    .close_dialogue_box,.skip_dialogue_box{
        position:absolute;
        right:0px;
        top:0px;
        color:#fff;
        border:0px;
        cursor:pointer;
        padding:10px;
        border-radius:10px;
        background:#333;
        z-index:99;
        outline:none;
    }
    .waiting_div{
        width:100%;
        height:100%;
        position:fixed;
        top:0px;
        left:0px;
        background:rgba(255,255,255,0.0);
        backdrop-filter:blur(8px);
        display:flex;
        justify-content:center;
        align-items:center;
        z-index:999;
        text-align:center;
        flex-direction:column;
    }
    .waiting_div_dialogue{
        background:rgba(255,255,255,0.7);
        padding:20px;
        border-radius:10px 200px 10px 10px;
        box-shadow: 4px 4px 10px rgba(0,0,0,0.3);
        color:#333;
        text-align: left;
        backdrop-filter:blur(4px);
        position: relative;
    }
    .waiting_div_dialogue:after{
        content: '';
        width:60px;
        height:60px;
        background:rgba(255,255,255,0.7);
        position: absolute;
        top:0px;
        right: 0px;
        border-radius: 50px;
        box-shadow: 4px 4px 10px rgba(0,0,0,0.3);
        backdrop-filter:blur(4px);
    }
    .waiting_div_dialogue:before{
        content: '';
        width:25px;
        height:25px;
        background:rgba(255,255,255,0.7);
        position: absolute;
        top:65px;
        right: 0px;
        border-radius: 50px;
        box-shadow: 4px 4px 10px rgba(0,0,0,0.3);
        backdrop-filter:blur(4px);
    }
    .waiting_players_div{
        display:block;
    }
    .start_button{
        padding:20px 50px;
        color:#fff;
        background:dodgerblue;
        box-shadow: 4px 4px 10px rgba(0,0,0,0.5),
                     inset 4px 4px 10px rgba(255,255,255,0.5),
                     inset -4px -4px 10px rgba(0,0,0,0.5);
        border-radius:50px;
        border:0px;
        outline: none;
        display: none;
        font-size:20px;
        font-weight:bold;
    }
    .start_button:active{
        box-shadow: 1px 1px 4px rgba(0,0,0,0.5),
                     inset 1px 1px 4px rgba(255,255,255,0.5),
                     inset -1px -1px 4px rgba(0,0,0,0.5);
        transform: translateY(4px);
    }
    .score_board_bg{
        width: 100%;
        height: 100%;
        position: fixed;
        top:0px;
        left: 0px;
        text-align: center;
        align-items: center;
        align-content: center;
        justify-content: center;
        display: flex;
        backdrop-filter:blur(7px);
        background:rgba(255,255,255,0.0);
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
        padding:12px;
        margin:auto;
    }
    .score_board table{
        background: rgba(255,255,255,0.4);
        border-radius:20px;
        overflow: hidden;
        box-shadow: 4px 4px 10px rgba(0,0,0,0.5);
    }
    @media only screen and (max-width:600px){
        .player_container,.main_container{
            width:90%;
            margin:auto;
        }
        .dialogue_box_content{
            width:95%;
        }
    }
</style>
<script src="jquery.js"></script>