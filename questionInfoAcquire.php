<?php

function timeAcquire(&$input,&$ans,&$info){
	if($info["time"]!=""){
	 $ans="請問您說的時間點是甚麼時候?";
	 	$info["time"]="waitReplay";

		return 0;
	}
	else if($info["time"]=="waitReplay"){
		$info["time"]=$input;
		$info["amount"]++;
		return 1;
	}
	else return 1;

}

function placeAcquire(&$input,&$ans,&$info){
	if($info["place"]!=""){
	 $ans="請問您說的地點是哪裡?";
	 $info["place"]="waitReplay";

		return 0;
	}
	else if($info["place"]=="waitReplay"){
		$info["place"]=$input;
		$info["amount"]++;
		return 1;
	}
		else return 1;

}

function eventAcquire(&$input,&$ans,&$info){
	if($info["event"]!=""){
	 $ans="請問您是發生了甚麼事?";
	 $info["event"]="waitReplay";

		return 0;
	}
	else if($info["event"]=="waitReplay"){
		$info["event"]=$input;
		$info["amount"]++;
		return 1;
	}
	else return 1;
}

function objectAcquire(&$input,&$ans,&$info){
	if($info["obj"]!=""){
	 $ans="請問您說的他是誰?";
	 $info["obj"]="waitReplay";

		return 0;
	}
	else if($info["obj"]=="waitReplay"){
		$info["obj"]=$input;
		$info["amount"]++;
		return 1;
	}
		else return 1;
}



?>