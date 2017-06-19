<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--<link rel="stylesheet" href="style/index.css" type="text/css">-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="css/chatscreen.css" />
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
    <!--<div class="row">
        <div class="col s12">
            <div class="input-field inline col s8">
                <input id="send_string" type="text" onkeypress="click_send(event)">
                <label for="send_string"><?php /*if(isset($_SESSION['account'])){ echo($_SESSION['account']); }else{ echo("訪客"); }*/ ?>：</label>
            </div>
            <button type="button" class="indigo btn waves-effect waves-light" onclick="send()"><i class="material-icons center">send</i></button>
        </div>
    </div>-->
    <center>
    <div class="main">
    		<div id="content" style="width:100%;overflow:auto;height:100%">
                <h1>
                <div class="send">
                你好，我是感情諮詢ChatBot，<br>請問你想要問什麼？
                </div>
                </h1>
                <?php
                if(isset($_SESSION['record'])){
                    for($i=0;$i<count($_SESSION['record']);$i++){
                        if($i%2==1){
                            echo("<h1>\n<div class=\"send\">\n"."<img src=\"bot-512.png\" alt=\"bot-icon\" style=\"display:inline-block\" width=\"10%\" height=\"10%\">".$_SESSION['record'][$i]."</div></h1>");
                        }else{
                            echo("<h2>\n<div class=\"user\">\n".$_SESSION['record'][$i]."\n</div></h2>");
                        }
                    }
                }
                ?>
            </div>
            <div id="footer">
                <table style="bottom:0px">
                <tbody><tr>
                <td><textarea rows="1" class="m" id="msg" onkeypress="click_send(event)"></textarea></td>
                <td style="padding:0px 0px;"><button style="width:130%;" id="input_btn" class="btn" onclick="send()">發送</button></td>
                </tr>
                </tbody></table>
            </div>
    </div>
<br>
    </center>
    <script>
    function click_send(e) {
        if (e.keyCode === 13) {
            send();
        }
    }
    function send() {
        var oXHR = new XMLHttpRequest();
        var sstring = document.getElementById("msg").value;
        sstring=sstring.replace(/\n/g,'');
        if (sstring) {
            para = "string=" + encodeURIComponent(sstring);
            oXHR.open("POST", "send.php", true);
            oXHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            oXHR.onreadystatechange = function() {
                if (oXHR.readyState == 4 && oXHR.status == 200) {
                    if (oXHR.responseText != "Error") {
                        document.getElementById("content").innerHTML = oXHR.responseText;
                        document.getElementById('content').scrollTop = document.getElementById('content').scrollHeight;
                    }
                }
            }
            oXHR.send(para);
        }
        document.getElementById("msg").value='';
    }
    </script>
</body>

</html>