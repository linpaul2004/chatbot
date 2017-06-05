<?php
include_once "CKIP_Client.php";

function firstInfoAcquire($input,&$info){
	$info['time'][0]=getTime($input);
	$info['obj'][0]=getObj($input);
	$info['place'][0]=getPlace($input);
	$info['event'][0]=getEvent($input);

	if(!($info['time'][0]==""))$info["timeNum"]++;
	if(!($info['obj'][0]==""))$info["objNum"]++;
	if(!($info['place'][0]==""))$info["placeNum"]++;
	if(!($info['event'][0]==""))$info["eventNum"]++;

return 1;
}

function timeAcquire($input,&$ans,&$info){
	
	if($info["nowState"]=="waitTime"){
		$info["time"][0]=getTime($input);
        $info['timenum']++;
		return 1;
	}
	if($info["timeNum"]==0){
	 $ans="請問您說的時間點是甚麼時候?";
	 	$info["status"]="waitReplay";
		return 0;
	}
	else return 1;

}

function placeAcquire($input,&$ans,&$info){
	
	if($info["nowState"]=="waitPlace"){
		$info["place"][0]=getPlace($input);
	    $info['placenum']++;
		return 1;
	}
	if($info["placeNum"]==0){
	 $ans="請問您說的地點是哪裡?";
	 $info["status"]="waitReplay";
		return 0;
	}
		else return 1;

}

function eventAcquire($input,&$ans,&$info){
	
	if($info["nowState"]=="waitEvent"){
		$info["event"][0]=getEvent($input);
        $info['eventnum']++;
		return 1;
	}
	if($info["eventNum"]==0){
	 $ans="請問您是發生了甚麼事?";
	 $info["status"]="waitReplay";
		return 0;
	}
	else return 1;
}

function objectAcquire($input,&$ans,&$info){
	
   if($info["nowState"]=="waitObj"){
		$info["obj"][0]=getObj($input);
        $info['objnum']++;
		return 1;
	}

	if($info["objNum"]==0){
	 $ans="請問您說的他是誰?";
	 $info["status"]="waitReplay";
		return 0;
	}
		else return 1;
}

function getTime($input){
	$v=seg($input);
	$num=count($v);
	for($i=0;$i<$num;$i++)
		if($v[$i]["pos"]=='Nd') return $v[$i]["word"] ;
	return "";

}

function getObj($input){
$v=seg($input);
	$num=count($v);
	for($i=0;$i<$num;$i++){
		if(($v[$i]["pos"]=='Na')&&$i+1<$num) 
			if($v[$i+1]["pos"]=='VA'||$v[$i+1]["pos"]=='VAC'||$v[$i+1]["pos"]=='VB'	||$v[$i+1]["pos"]=='VC'	||$v[$i+1]["pos"]=='VCL'||$v[$i+1]["pos"]=='VD'	||$v[$i+1]["pos"]=='VE'	||$v[$i+1]["pos"]=='VF'	||$v[$i+1]["pos"]=='V') 
			return $v[$i]["word"] ;
		if($v[$i]["pos"]=='Nh')return $v[$i]["word"] ;
	}
	return "";
	
}

function getPlace($input){
$v=seg($input);
	$num=count($v);
	for($i=0;$i<$num;$i++){
		if($v[$i]["pos"]=='Nc') return $v[$i]["word"] ;
		if($v[$i]["pos"]=='Ncd') return $v[$i]["word"] ;
	}
	return "";
	
}

function getEvent($input){
$v=seg($input);
	$num=count($v);
	for($i=0;$i<$num;$i++)
		if($v[$i]["pos"]=='VA'||$v[$i]["pos"]=='VAC'||$v[$i]["pos"]=='VB'	||$v[$i]["pos"]=='VC'	||$v[$i]["pos"]=='VCL'	||$v[$i]["pos"]=='VD'	||$v[$i]["pos"]=='VE'	||$v[$i]["pos"]=='VF'	||$v[$i]["pos"]=='V') 
			if(($i+1<$num)&&($v[$i+1]=='Na'||$v[$i+1]=='Nb'))
				return ($v[$i]["word"] + $v[$i+1]["word"]) ;
	return "";
	
}




?>