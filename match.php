<?php
include_once "config.php";
function match($ans,$info){
	//echo"match";
	$da=":time=".$info["time"][0]." place=".$info["place"][0]." obj=".$info["obj"][0]." event".$info["event"][0]." ";
	$query="SELECT `url` FROM `pttdata` WHERE `title` LIKE '%".$info["obj"][0]."%".$info["event"][0]."%' ORDER BY `push` DESC";
	$result=mysqli_query($link,$query);
	if($result){
		$result=mysqli_fetch_array($result);
		return "匹配到的網址：<br>".$rows[0];
	}else{
		return "抱歉，我還無法解決您的問題";
	}
}
?>