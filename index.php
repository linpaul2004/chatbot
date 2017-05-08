<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--<link rel="stylesheet" href="style/index.css" type="text/css">-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>感情諮詢機器人</title>
    <?php
    session_start();
    ?>
</head>

<body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <nav>
        <div class="nav-wrapper blue">
            <a href="#" class="brand-logo center">你好，<?php if(isset($_SESSION['account'])){ echo($_SESSION['account']); }else{ echo("訪客"); } ?></a>
            <ul class="left hide-on-med-and-down">
                <li class="active"><a href="index.php">&nbsp;&nbsp;諮詢&nbsp;&nbsp;</a></li>
                <li><a href="record.php">&nbsp;&nbsp;紀錄&nbsp;&nbsp;</a></li>
                <li><a href="log.php">&nbsp;&nbsp;<?php if(isset($_SESSION['account'])){ echo("登出"); }else{ echo("登入"); } ?>&nbsp;&nbsp;</a></li>
            </ul>
        </div>
    </nav>
    <?php
    if(isset($_SESSION['account'])==false){
        echo('<div class="row"><div class="col s12"><div class="card blue-grey darken-1"><div class="card-content white-text"><span class="card-title">注意：您現在沒有登入，對話不會被記錄。</span></div></div></div></div>');
    }
    ?>
    <div class="row">
        <div class="col s12">
            <div class="input-field inline col s8">
                <input id="send_string" type="text" onkeypress="click_send(event)">
                <label for="send_string"><?php if(isset($_SESSION['account'])){ echo($_SESSION['account']); }else{ echo("訪客"); } ?>：</label>
            </div>
            <button type="button" class="indigo btn waves-effect waves-light" onclick="send()"><i class="material-icons center">send</i></button>
        </div>
    </div>
    <div class="row">
        <div id="talking" class="col s12">
        <?php
        if(isset($_SESSION['record'])){
            for($i=count($_SESSION['record'])-1;$i>=0;$i--){
                if($i%2==1){
                    echo("<div class=\"row\">\n<div class=\"right\"><span class=\"teal\" style=\"font-family:微軟正黑體;font-size:24px\">".$_SESSION['record'][$i]."</span></div>\n</div>");
                }else{
                    echo("<div class=\"row\">\n<div class=\"left\"><span class=\"blue\" style=\"font-family:微軟正黑體;font-size:24px\">".$_SESSION['record'][$i]."</span></div>\n</div>");
                }
            }
        }
        ?>
        </div>
    </div>
    <div class="row">
        <div class="right"><span class="teal" style="font-family:微軟正黑體;font-size:24px">你好，有什麼想問的嗎？</span></div>
    </div>
    <script>
    function click_send(e) {
        if (e.keyCode === 13) {
            send();
        }
    }
    function send() {
        var oXHR = new XMLHttpRequest();
        var sstring = document.getElementById("send_string").value;
        if (sstring) {
            para = "string=" + encodeURIComponent(sstring);
            oXHR.open("POST", "send.php", true);
            oXHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            oXHR.onreadystatechange = function() {
                if (oXHR.readyState == 4 && oXHR.status == 200) {
                    if (oXHR.responseText != "Error") {
                        document.getElementById("talking").innerHTML = oXHR.responseText;
                    }
                }
            }
            oXHR.send(para);
        } else {
            document.getElementById("talking").innerHTML = "";
        }
        document.getElementById("send_string").value="";
    }
    </script>
</body>

</html>