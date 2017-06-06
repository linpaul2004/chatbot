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
    $date = new DateTime('now');
    $day = $date->format('Y-m-d');
    ?>
</head>

<body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <nav>
        <div class="nav-wrapper blue">
            <a href="#" class="brand-logo center">你好，<?php if(isset($_SESSION['account'])){ echo($_SESSION['account']); }else{ echo("訪客"); } ?></a>
            <ul class="left hide-on-med-and-down">
                <li><a href="index.php">&nbsp;&nbsp;諮詢&nbsp;&nbsp;</a></li>
                <li class="active"><a href="record.php">&nbsp;&nbsp;紀錄&nbsp;&nbsp;</a></li>
                <li><a href="log.php">&nbsp;&nbsp;<?php if(isset($_SESSION['account'])){ echo("登出"); }else{ echo("登入"); } ?>&nbsp;&nbsp;</a></li>
            </ul>
        </div>
    </nav>
    <?php
    if(isset($_SESSION['account'])==false){
        echo("<div class=\"row\"><div class=\"col s12\"><div class=\"card blue-grey darken-1\"><div class=\"card-content white-text\"><span class=\"card-title\">注意：您現在沒有登入，不能查看紀錄。</span>\n</div>\n</div>\n</div>\n</div>\n");
    }else{
    ?>
    <label for="date">日期</label>
    <input id="date" type="date" value="<?php echo($day) ?>" class="datepicker" onchange=search()>
    <table id="table" class="highlight centered">
        <thead>
            <tr>
                <th>順序</th>
                <th>問句</th>
                <th>答句</th>
                <th>時間</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once "config.php";
            mysqli_query($link,"SET NAMES UTF8");
            $query="SELECT `sentence`,`answer`,`time` FROM `record` WHERE `username`='$_SESSION[account]' AND `day`='$day' ORDER BY `time` ASC";
            $result=mysqli_query($link,$query);
            $i=1;
            if($result){
                $rows=mysqli_fetch_array($result);
                while($rows){
                    echo "<tr>\n";
                    echo "\t<td>".$i."</td>\n";
                    echo "\t<td>".$rows[0]."</td>\n";
                    echo "\t<td>".urldecode($rows[1])."</td>\n";
                    echo "\t<td>".$rows[2]."</td>\n</tr>\n";
                    $i=$i+1;
                    $rows=mysqli_fetch_array($result);
                }
            }
            ?>
        </tbody>
    </table>
    <?php
    }
    ?>
    <script>
        function search(){
            var d=document.getElementById("date").value;
            var username="<?php echo($_SESSION['account']) ?>";
            var oXHR = new XMLHttpRequest();
            if (1) {
                para = "username=" + username + "&day=" + d;
                oXHR.open("POST", "search.php", true);
                oXHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                oXHR.onreadystatechange = function() {
                    if (oXHR.readyState == 4 && oXHR.status == 200) {
                        document.getElementById("table").innerHTML = oXHR.responseText;
                    }
                }
                oXHR.send(para);
            }
        }
    </script>
</body>

</html>