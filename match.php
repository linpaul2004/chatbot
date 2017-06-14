<?php
include_once "config.php";
function match($ans,$info){
	//echo"match";
	$da=":time=".$info["time"][0]." place=".$info["place"][0]." obj=".$info["obj"][0]." event".$info["event"][0]." ";
	$n=$info["infoStackNum"];

	$keep="";
	$query="";
	/*for($i=0;$i<$n;$i++){
		if($i!=0){$query=$query." INTERSECT ";}
		$query=$query."SELECT `url` FROM `pttdata` WHERE `title` LIKE '%".$info["infoStack"][0]."%' ORDER BY `push` DESC";
		$result=mysqli_query($link,$query);
		
		if($result){
			$result=mysql_fetch_array($result);
			$keep=$result;
		}
		else{
			break;
		}
	}
*/

	mysqli_query($link,"SET NAMES UTF8");
	$query="SELECT `url` FROM `pttdata` WHERE `title` LIKE '%".$info["obj"][0]."%".$info["event"][0]."%' ORDER BY `push` DESC";
	mysqli_set_charset($link,"utf8");
	$result=mysqli_query($link,$query);
	//if($keep){
	if($result){
		$result=mysqli_fetch_array($result);
		return "匹配到的網址：<br>".$result[0];
		//return "匹配到的網址：<br>".$keep[0];
	}else{
		return "抱歉，我還無法解決您的問題".$query."character".mysqli_character_set_name($link);
	}
}
?>