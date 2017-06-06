<?php
function match($ans,$info){
	//echo"match";
	$da=":time=".$info["time"][0]." place=".$info["place"][0]." obj=".$info["obj"][0]." event".$info["event"][0]." ";
	return "match start ".$da;
}
?>