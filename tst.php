<script src="jquery.js"></script>
<button onclick="gt()" class="as">Click Me</button>
<button onclick="ch()">Change Txt</button>
<div id="msg"></div>
<script>
    var txt = "HEllO World";
    var i = 0;
    var speed = 50;

function ch(){
    i = 0;
    document.getElementById("msg").innerHTML = "";
    txt = "Ashu";
}

function gt(){
    if(i < txt.length){
        document.getElementById("msg").innerHTML += txt.charAt(i);
        i++;
        setTimeout(gt, speed);
    }
    console.log(txt);
    $(".as").attr("disabled",true);
}
</script>