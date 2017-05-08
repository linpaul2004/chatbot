<?php
include_once "config.php";
echo "<p class=\"yellow-text text-darken-4 center-align\" style=\"font-weight: bold;\">";
$query="SELECT `password` FROM `user` WHERE `username`='$_POST[username]' AND `email`='$_POST[email]'";
$result=mysqli_query($link,$query);
if($result){
	$rows=mysqli_fetch_array($result);
	if($rows){
		echo("你的密碼是：".$rows[0]."<br>請妥善保管");
	}else{
		echo("查詢不到");
	}
}else{
	echo("查詢失敗");
}
echo "</p>";
?>
