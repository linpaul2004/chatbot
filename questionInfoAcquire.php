<?php

function timeAcquire(&$input,&$data,&$ans,&$info){
	if($info["time"][0]==""){
	 $ans="請問您說的時間點是甚麼時候?";
	 	$info["time"][0]="waitReplay";

		return 0;
	}
	else if($info["time"][0]=="waitReplay"){
		$info["time"][0]=$input;
		$info["amount"]++;
		$info["amount"]["time"]++;
		return 1;
	}
	else return 1;

}

function placeAcquire(&$input,&$data,&$ans,&$info){
	if($info["place"][0]==""){
	 $ans="請問您說的地點是哪裡?";
	 $info["place"][0]="waitReplay";

		return 0;
	}
	else if($info["place"][0]=="waitReplay"){
		$info["place"][0]=$input;
		$info["amount"]++;
		$info["amount"]["place"]++;
		return 1;
	}
		else return 1;

}

function eventAcquire(&$input,&$data,&$ans,&$info){
	if($info["event"][0]==""){
	 $ans="請問您是發生了甚麼事?";
	 $info["event"][0]="waitReplay";

		return 0;
	}
	else if($info["event"][0]=="waitReplay"){
		$info["event"][0]=$input;
		$info["amount"]++;
		$info["amount"]["event"]++;
		return 1;
	}
	else return 1;
}

function objectAcquire(&$input,&$data,&$ans,&$info){
	if($info["obj"][0]==""){
	 $ans="請問您說的他是誰?";
	 $info["obj"][0]="waitReplay";

		return 0;
	}
	else if($info["obj"][0]=="waitReplay"){
		$info["obj"][0]=$input;
		$info["amount"][obj]++;
		$info["amount"]++;
		return 1;
	}
		else return 1;
}



?>