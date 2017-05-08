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
            $query="SELECT `sentence`,`answer`,`time` FROM `record` WHERE `username`='$_POST[username]' AND `day`='$_POST[day]' ORDER BY `time` ASC";
            $result=mysqli_query($link,$query);
            $i=1;
            if($result){
                $rows=mysqli_fetch_array($result);
                while($rows){
                    echo "<tr>\n";
                    echo "\t<td>".$i."</td>\n";
                    echo "\t<td>".$rows[0]."</td>\n";
                    echo "\t<td>".$rows[1]."</td>\n";
                    echo "\t<td>".$rows[2]."</td>\n</tr>\n";
                    $i=$i+1;
                    $rows=mysqli_fetch_array($result);
                }
            }
        ?>
        </tbody>