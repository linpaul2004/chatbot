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
    if(isset($_SESSION)){
        $_SESSION = array();
        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
            );
        }
        // Finally, destroy the session.
        session_destroy();
    }
    ?>
    <script>
    function login() {
        var oXHR = new XMLHttpRequest();
        account = document.getElementById("acc1").value;
        password = document.getElementById("pw1").value;
        if (account && password) {
            para = "username=" + account + "&password=" + password;
            oXHR.open("POST", "login_reg.php", true);
            oXHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            oXHR.onreadystatechange = function() {
                if (oXHR.readyState == 4 && oXHR.status == 200) {
                    if (oXHR.responseText == "Success") {
                        window.location = "index.php";
                    } else {
                        document.getElementById("result").innerHTML = oXHR.responseText;
                    }
                }
            }
            oXHR.send(para);
        } else {
            document.getElementById("result").innerHTML = "<p class=\"yellow-text text-darken-4 center-align\" style=\"font-weight: bold;\">欄位不得為空</p>";
        }
    }

    function register() {
        var oXHR = new XMLHttpRequest();
        account = document.getElementById("acc2").value;
        password = document.getElementById("pw2").value;
        password2 = document.getElementById("pw3").value;
        email = document.getElementById("em").value;
        if (password != password2) {
            document.getElementById("result").innerHTML = "<p class=\"yellow-text text-darken-4 center-align\" style=\"font-weight: bold;\">密碼不一致</p>";
            return;
        }
        if (account && password && email && password2) {
            para = "username=" + account + "&password=" + password + "&email=" + email;
            oXHR.open("POST", "login_reg.php", true);
            oXHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            oXHR.onreadystatechange = function() {
                if (oXHR.readyState == 4 && oXHR.status == 200) {
                    document.getElementById("result").innerHTML = oXHR.responseText;
                }
            }
            oXHR.send(para);
        } else {
            document.getElementById("result").innerHTML = "<p class=\"yellow-text text-darken-4 center-align\" style=\"font-weight: bold;\">欄位不得為空</p>";
        }
    }

    function forgot() {
        var oXHR = new XMLHttpRequest();
        account = document.getElementById("acc3").value;
        email = document.getElementById("em2").value;
        if (account && email) {
            para = "username=" + account + "&email=" + email;
            oXHR.open("POST", "forgot.php", true);
            oXHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            oXHR.onreadystatechange = function() {
                if (oXHR.readyState == 4 && oXHR.status == 200) {
                    document.getElementById("result").innerHTML = oXHR.responseText;
                }
            }
            oXHR.send(para);
        } else {
            document.getElementById("result").innerHTML = "<p class=\"yellow-text text-darken-4 center-align\">欄位不得為空</p>";
        }
    }
    </script>
</head>

<body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <nav>
        <div class="nav-wrapper blue">
            <a href="#" class="brand-logo center">你好，<?php if(isset($_SESSION['account'])){ echo($_SESSION['account']); }else{ echo("訪客"); } ?></a>
            <ul class="left hide-on-med-and-down">
                <li><a href="index.php">&nbsp;&nbsp;諮詢&nbsp;&nbsp;</a></li>
                <li><a href="record.php">&nbsp;&nbsp;紀錄&nbsp;&nbsp;</a></li>
                <li class="active"><a href="log.php">&nbsp;&nbsp;登入&nbsp;&nbsp;</a></li>
            </ul>
        </div>
    </nav>
        <ul class="tabs">
        <li class="tab"><a href="#login">登入</a></li>
        <li class="tab"><a href="#reg">註冊</a></li>
        <li class="tab"><a href="#forgot">忘記密碼</a></li>
    </ul>
    <div id="login" class="col s12">
        <form>
            <div class="input-field col s12">
                <input id="acc1" type="text" class="validate">
                <label for="acc1">帳號</label>
            </div>
            <br>
            <div class="input-field col s12">
                <input id="pw1" type="password" class="validate">
                <label for="pw1">密碼</label>
            </div>
            <br>
            <button type="button" class="btn waves-effect waves-light" onclick="login()">登入</button>
        </form>
    </div>
    <div id="reg" class="col s12">
        <form>
            <div class="input-field col s12">
                <label for="acc2">帳號</label>
                <input id="acc2" type="text" class="validate">
            </div>
            <br>
            <div class="input-field col s12">
                <label for="em">電子郵件</label>
                <input id="em" type="text" class="validate">
            </div>
            <br>
            <div class="input-field col s12">
                <label for="pw2">密碼</label>
                <input id="pw2" type="text" class="validate">
            </div>
            <br>
            <div class="input-field col s12">
                <label for="pw3">確認密碼</label>
                <input id="pw3" type="text" class="validate">
            </div>
            <br>
            <button type="button" class="btn waves-effect waves-light" onclick="register()">註冊</button>
        </form>
    </div>
    <div id="forgot" class="col s12">
        <form>
            <div class="input-field col s12">
                <label for="acc3">帳號</label>
                <input id="acc3" type="text" class="validate">
            </div>
            <br>
            <div class="input-field col s12">
                <label for="em2">電子郵件</label>
                <input id="em2" type="text" class="validate">
            </div>
            <br>
            <button type="button" class="btn waves-effect waves-light" onclick="forgot()">查詢密碼</button>
        </form>
    </div>
    <div id="result" class="col s12" style="background-color: aqua;"></div>
</body>

</html>