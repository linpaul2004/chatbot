<?php
include_once "articleFatcher.php";
function match($ans,$info){
	// config.php
	$host="140.116.245.148";
	$user="f74032146";
	$upwd="00000AAA";
	$db="f74032146";

	$link=mysqli_connect($host,$user,$upwd) or die("Unable to connect".mysql_error());
	mysqli_select_db($link,$db) or die("Unable to select database");
	// config.php
	$da=":time=".$info["time"][0]." place=".$info["place"][0]." obj=".$info["obj"][0]." event".$info["event"][0]." ";
	$n=$info["infoStackNum"];
/*
	$keep;
	$query="";
	//echo $n;
	for($i=0;$i<$n;$i++){
	//echo "aaa".$info["infoStack"][$i]."   ";
		
		if($i!=0){$query=$query." INTERSECT ";}
		$query=$query."SELECT `url` FROM `pttdata` WHERE `title` LIKE '%".$info["infoStack"][$i]."%' ORDER BY `push` DESC";
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

	mysqli_query($link,"SET NAMES utf8");
	$query="SELECT `url` FROM `pttdata` WHERE `title` LIKE '%".$info["event"][0]."%' ORDER BY `push` DESC";
//	$query="SELECT `url` FROM `pttdata` WHERE `title` LIKE '%".$info["obj"][0]."%".$info["event"][0]."%' ORDER BY `push` DESC";
	$result=mysqli_query($link,$query);
	
//	if($keep){
		$res="";
	if($result){
		$result=mysqli_fetch_array($result);
		return "匹配到的網址：<br>".$result[0];
//		return "匹配到的網址：<br>".$keep[0];
//		articleFatch($result[0],$res);
		return $res;
	}else{
		return "抱歉，我還無法解決您的問題"."<br>Error Code:".$query;
	}
}

?>