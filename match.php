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

	$query="SELECT `url` FROM `pttdata` WHERE `title` LIKE 'Re:%".$info["obj"][0]."%".$info["event"][0]."%' ORDER BY `push` DESC";
	//$query="SELECT `url` FROM `pttdata` ORDER BY `push` DESC";
	$result=mysqli_query($link,$query);
	//echo(gettype($result));
	//if($keep){
	if(mysqli_num_rows($result)){
		$result=mysqli_fetch_array($result);
		$result[0]=preg_replace('/www.ptt.cc./','www.ptt.cc',$result[0]);
		//$res="kk";
		articleFatch($result[0],$res);
		$res="關於這個問題的回答如下：<br>".$res."<br>(";
		$res=$res."<a href=\""."https://".$result[0]."\" target=\"_new\" >想了解更多請點此</a>)<br><br>";
		return $res;
//		return "匹配到的網址：<br>".$keep[0];
//		articleFatch($result[0],$res);
	//	return $res;
	}else{
		$query="SELECT `url` FROM `pttdata` WHERE `title` LIKE 'Re:%".$info["event"][0]."%' ORDER BY `push` DESC";
		$result=mysqli_query($link,$query);
		if(mysqli_num_rows($result)){
			//$res="kk";
			$result=mysqli_fetch_array($result);
			$result[0]=preg_replace('/www.ptt.cc./','www.ptt.cc',$result[0]);
			articleFatch($result[0],$res);
			$res="關於這個問題的回答如下：<br>".$res."<br>(";
			$res=$res."<a href=\""."https://".$result[0]."\" target=\"_new\" >想了解更多請點此</a>)<br><br>";
			return $res;
		}
		return "抱歉，我還無法回答您的問題<br>";
	}
}

?>