<?php
function firstInfoAcquire($input,&$info){


return 1;
}

function timeAcquire($input,&$ans,&$info){
	if($info["timeNum"]==0){
	 $ans="請問您說的時間點是甚麼時候?";
	 	$info["time"][0]="waitReplay";
		return 0;
	}
	else if($info["time"][0]=="waitReplay"){
		$info["time"][0]=$input;
        $info['timenum']++;
		return 1;
	}
	else return 1;

}

function placeAcquire($input,&$ans,&$info){
	if($info["placeNum"]==0){
	 $ans="請問您說的地點是哪裡?";
	 $info["place"][0]="waitReplay";
		return 0;
	}
	else if($info["place"][0]=="waitReplay"){
		$info["place"][0]=$input;
	    $info['placenum']++;
		return 1;
	}
		else return 1;

}

function eventAcquire($input,&$ans,&$info){
	if($info["eventNum"]==0){
	 $ans="請問您是發生了甚麼事?";
	 $info["event"][0]="waitReplay";
		return 0;
	}
	else if($info["event"][0]=="waitReplay"){
		$info["event"][0]=$input;
        $info['eventnum']++;
		return 1;
	}
	else return 1;
}

function objectAcquire($input,&$ans,&$info){
	if($info["objNum"]==0){
	 $ans="請問您說的他是誰?";
	 $info["obj"][0]="waitReplay";
		return 0;
	}
	else if($info["obj"][0]=="waitReplay"){
		$info["obj"][0]=$input;
        $info['objnum']++;
		return 1;
	}
		else return 1;
}



?>