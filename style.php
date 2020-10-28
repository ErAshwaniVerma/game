<style>
    body{
        background:#111;
        font-family:arial;
        color:#fff;
    }
    .main_container{
    }
    .main{
        min-height:100vh;
        justify-content:center;
        align-items:center;
        display:flex;
    }
    .card{
        padding:20px;
        background:#222;
        width:300px;
        margin:auto;
        color:#fff;
        border-radius:10px;
        box-shadow:0px 4px 20px rgba(0,0,0,0.2);
    }
    .card h1{
        margin-bottom:-15px;
    }
    input[type=text]{
        padding:15px;
        color:#fff;
        background:#111;
        width:80%;
        margin:auto;
        border:0px;
        border-radius:4px;
        color:#fff;
    }
    .card button{
        padding:10px;
        background:dodgerblue;
        border:0px;
        color:#fff;
        border-radius:5px;
        width:100%;
        cursor:pointer;
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
        min-height:100vh;
        display:none;
    }
    .modal .modal_dialog{
        width:300px;
        box-shadow:0px 4px 10px rgba(0,0,0,0.2);
        border-radius:10px;
        background:#222;
        padding:20px;
        color:#fff;
    }
    .modal .modal_btn{
        padding:10px;
        background:green;
        border:0px;
        border-radius:4px;
        color:#fff;
        cursor:pointer;
        width:100%;
    }
    .modal .modal_close_btn{
        background:red;
        border:0px;
        padding:10px;
        color:#fff;
        border-radius:4px;
        width:100%;
        cursor:pointer;
    }
    .player_container{
        width:400px;
        display:flex;
        margin:auto;
        flex-wrap:wrap;
        flex-direction:row;
    }
    .chits{
        display:flex;
        flex-basis:calc(100% - 40px);
        flex-direction:column;
        background:#222;
        padding:20px;
        border-radius:10px;
        margin-bottom:5px;
        cursor:pointer;
        color:#fff;
    }
    @media only screen and (max-width:600px){
        .player_container{
            width:100%;
        }
    }
</style>
<script src="jquery.js"></script>