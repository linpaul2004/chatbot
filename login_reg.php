<?php
include_once "config.php";
session_start();
if(isset($_POST['email'])){
	$query="INSERT INTO `f74032146`.`user` (`username` ,`password` ,`email`) VALUES ('$_POST[username]', '$_POST[password]', '$_POST[email]');";
	if(mysqli_query($link,$query)){
		echo "<p class=\"yellow-text text-darken-4 center-align\" style=\"font-weight: bold;\">註冊成功</p>";
	}else{
		echo "<p class=\"yellow-text text-darken-4 center-align\" style=\"font-weight: bold;\">帳號已被使用</p>";
	}
}else{
	$query="SELECT * FROM `user` WHERE username=\"".$_POST['username']."\"";
	$result=mysqli_query($link,$query);
	if($result){
		$rows=mysqli_fetch_array($result);
		if($rows[1]==$_POST['password']){
			$_SESSION['account']=$_POST['username'];
			echo "Success";
		}else{
			echo "<p class=\"yellow-text text-darken-4 center-align\" style=\"font-weight: bold;\">帳號密碼錯誤</p>";
		}
	}
}
?>
