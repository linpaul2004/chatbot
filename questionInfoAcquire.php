<?php
include_once "CKIP_Client.php";

function firstInfoAcquire($input,&$info){
	$info['time'][0]=getTime($input);
	$info['obj'][0]=getObj($input);
	$info['place'][0]=getPlace($input);
	$info['event'][0]=getEvent($input);

	// echo "time".$info['time'][0].' ';
	// echo "obj".$info['obj'][0].' ';
	// echo "event".$info['event'][0].' ';
	// echo "place".$info['place'][0].' ';

	$info['nowState']="";

	if(!($info['time'][0]=="")){
		pushInfoStack('time',$info['time'][0],$info);
		$info["timeNum"]++;
	}
	if(!($info['obj'][0]=="")){
		pushInfoStack('obj',$info['obj'][0],$info);
		$info["objNum"]++;
	}
	if(!($info['place'][0]=="")){
		pushInfoStack('place',$info['place'][0],$info);
		$info["placeNum"]++;
	}
	if(!($info['event'][0]=="")){
		pushInfoStack('event',$info['event'][0],$info);
		$info["eventNum"]++;
	}

	return 1;
}

function timeAcquire($input,&$ans,&$info){
	//echo "ti ";
	if($info["nowState"]=="waitTime"){
		$info["time"][0]=getTime($input);
		if($info["time"][0]!=""){
			pushInfoStack('time',$info['time'][0],$info);
			$info['timeNum']++;
			$info["nowState"]="";
			return 1;
		}

	}
	if($info["timeNum"]==0){
		$ans="請問您說的時間點是甚麼時候?";
		$info["nowState"]="waitTime";
		return 0;
	}
	//echo "te";
	return 1;


}

function placeAcquire($input,&$ans,&$info){
	//echo "pi ";
	if($info["nowState"]=="waitPlace"){
		$info["place"][0]=getPlace($input);
		if($info["place"][0]!=""){
			pushInfoStack('place',$info['place'][0],$info);
			$info['placeNum']++;
			$info["nowState"]="";
			return 1;
		}
	}
	if($info["placeNum"]==0){
		$ans="請問您說的地點是哪裡?";
		$info["nowState"]="waitPlace";
		return 0;
	}
	//echo "pe";
	return 1;

}

function eventAcquire($input,&$ans,&$info){
	//echo "ei ";
	if($info["nowState"]=="waitEvent"){
		$info["event"][0]=getEvent($input);
		if($info["event"][0]!=""){
		pushInfoStack('event',$info['event'][0],$info);
			$info['eventNum']++;
			$info["nowState"]="";
			return 1;
		}
	}
	if($info["eventNum"]==0){
		$ans="請問您是發生了甚麼事?";
		$info["nowState"]="waitEvent";
		return 0;
	}
	//echo "ee";
	return 1;

}

function objectAcquire($input,&$ans,&$info){
	//echo "oi ";
	if($info["nowState"]=="waitObj"){
		$info["obj"][0]=getObj($input);
		if($info["obj"][0]!=""){
			pushInfoStack('obj',$info['obj'][0],$info);
			$info['objNum']++;
			$info["nowState"]="";
			return 1;
		}
	}

	if($info["objNum"]==0){
		//if($info["obj"][0]!=""){
		//$ans="請問您說的".$info["obj"][0]."是誰?";
		$ans="請問您說的"."他"."是誰?";
		$info["nowState"]="waitObj";
		return 0;
		//}
		//else {
			$ans="";
			if($info["timeNum"]!=0){$ans=$info["time"][0];}
			$ans=$ans."跟誰";
			if($info["placeNum"]!=0){$ans=$ans."在".$info["place"][0];}
			if($info['eventNum']!=0){$ans=$ans.$info["event"][0];}
			return 0;
		//}
	}
	//echo "oe";
	return 1;
}

function getTime($input){
	$v=seg($input);
	$num=count($v);
	for($i=0;$i<$num;$i++){
		if($v[$i]["pos"]=='Nd'){ return $v[$i]["word"] ;}
	}
	return "";

}


function getObj($input){
	$v=seg($input);
	$num=count($v);
	for($i=0;$i<$num;$i++){
		if(($v[$i]["pos"]=='Na')&&$i+1<$num) {
			if($v[$i+1]["pos"]=='VA'||$v[$i+1]["pos"]=='VAC'||$v[$i+1]["pos"]=='VB'	||$v[$i+1]["pos"]=='VC'	||$v[$i+1]["pos"]=='VCL'||$v[$i+1]["pos"]=='VD'	||$v[$i+1]["pos"]=='VE'	||$v[$i+1]["pos"]=='VF'	||$v[$i+1]["pos"]=='V'){ 
				return $v[$i]["word"] ;
			}
			if($v[$i]["pos"]=='Nh'){ return $v[$i]["word"] ;}
		}
	}

	if($num==1){
		if($v[0]["pos"]=='Na'){
			return $v[0]["word"];
		}
	}
	return "";

}

function getPlace($input){
	$v=seg($input);
	$num=count($v);
	for($i=0;$i<$num;$i++){
		if($v[$i]["pos"]=='Nc') {return $v[$i]["word"] ;}
		if($v[$i]["pos"]=='Ncd') {return $v[$i]["word"] ;}
	}
	return "";
	
}

function getEvent($input){
	$v=seg($input);
	$num=count($v);
	for($i=0;$i<$num;$i++){
		if($v[$i]["pos"]=='VAC'||$v[$i]["pos"]=='VB'	||$v[$i]["pos"]=='VC'	||$v[$i]["pos"]=='VCL'	||$v[$i]["pos"]=='VD'	||$v[$i]["pos"]=='VE'	||$v[$i]["pos"]=='VF'	){ 
			if((($i+1)<$num)&&($v[$i+1]=='Na'||$v[$i+1]=='Nb')){
				return ($v[$i]["word"] + $v[$i+1]["word"]) ;
			}
		}
		else if($v[$i]["pos"]=='VA'||$v[$i]["pos"]=='VH'){
			return $v[$i]["word"];
		}
	}	
	return "";
}

function echoSeg($input){
	$v=seg($input);
	$n=count($v);
	for($i=0;$i<$n;$i++){
		echo" ".$v[$i]['word']." : ".$v[$i]['pos']." ; ";
	}
}

function pushInfoStack($type,$input,&$info){
	$n=$info["infoStackNum"];
	$info["infoStack"][$n]=$input;
	$info["infoStackNum"]++;
}


?>