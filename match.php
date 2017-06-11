<?php
include_once "config.php";
function match($ans,$info){
	//echo"match";
	$da=":time=".$info["time"][0]." place=".$info["place"][0]." obj=".$info["obj"][0]." event".$info["event"][0]." ";
	$n=$info["infoStackNum"];

	$keep="";
	$query="";

	for($i=0;$i<$n;$i++){
		if($i!=0){$quary=$query."INTERSECT";}
		$query=$query."SELECT `url` FROM `pttdata` WHERE `title` LIKE '%".$info["questionInfoStack"][0]."$ ORDER BY `push` DESC";
		$result=mysqli_query($link,$query);
		
		if($result){
			$result=mysql_fetch_array($result);
			$keep=$result;
		}
		else{
			break;
		}
	}



	//$query="SELECT `url` FROM `pttdata` WHERE `title` LIKE '%".$info["obj"][0]."%".$info["event"][0]."%' ORDER BY `push` DESC";
	//$result=mysqli_query($link,$query);
	if($result){
	//	$result=mysqli_fetch_array($result);
		// return "匹配到的網址：<br>".$result[0];
		return "匹配到的網址：<br>".$keep[0];
	}else{
		return "抱歉，我還無法解決您的問題";
	}
}
?>