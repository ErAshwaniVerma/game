<script src="jquery.js"></script>

<script>
var b;
get_online_status();
function get_online_status(a){
    var req = new XMLHttpRequest();
    req.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            if(this.responseText == "ok"){
                b = "ok";
                console.log(b);
                //alert(rt);
            }else{
                //alert(this.responseText);
                b = this.responseText;
                console.log(b);
            }
        }
    }
    req.open("POST" , "get_online.php", true);
    req.send()
}
setTimeout(function(){
        document.write(b);
        console.log(b);
    },1000);
</script>