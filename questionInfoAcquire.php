<?php
include_once "CKIP_Client.php";
include_once "infoPreprocessor.php";

function firstInfoAcquire($input,&$info){
	$info['time'][0]=getTime($input);
	$info['obj'][0]=getObj($input);
	$info['place'][0]=getPlace($input);
	$info['event'][0]=getEvent($input);       

	$info['nowState']="";

	if(!($info['event'][0]=="")){
		pushInfoStack('event',$info['event'][0],$info);
		$info["eventNum"]++;
	}
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
	


	return 1;
}

function typeOfQuestion(&$info){
	$word=array();
	$word=$info["event"][0];
	if(($word=="約會")||($word=="告白")){$info["questionType"]=="date";}
	if(($word=="分手")){$info["questionType"]=="deliver";}
}

function timeAcquire($input,&$ans,&$info){
//	echo "ti ";
	if($info["nowState"]=="waitTime"){
		$info["time"][0]=getTime($input);
		if($info["time"][0]!=""){
			pushInfoStack('time',$info['time'][0],$info);
			$info['timeNum']++;
			$info["nowState"]="";			
		}
		else{
			$info["nowState"]="waitTime2";	
		}
			return 1;			
	}
	if($info["nowState"]=="waitTime21"){
		$info["time"][0]=$input;
		pushInfoStack('time',$info['time'][0],$info);
		$info['timeNum']++;
		$info["nowState"]="";			
		return 1;	
	}
	if($info["timeNum"]==0){
		if($info["eventNum"]!=0){
			$ans="請問是在什麼時候".$info["event"][0]."?";
		}
		else{
			$ans="請問您說的時間點是什麼時候?";
		}
		if($info["nowState"]=="waitTime2"){
			$info["nowState"]="waitTime21";
			$ans="不好意思，可以把時間點再告訴我一次嗎";
		}
		else{
			$info["nowState"]="waitTime";
		}
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
		else{
			$info["nowState"]="waitPlace2";	
		}
		return 1;
	}
	if($info["nowState"]=="waitPlace21"){
		$info["place"][0]=$input;
		pushInfoStack('place',$info['place'][0],$info);
		$info['placeNum']++;
		$info["nowState"]="";			
		return 1;	
	}
	if($info["placeNum"]==0){
		if($info["eventNum"]!=0){
			$ans="請問在哪裡".$info["event"][0]."呢?";
		}
		else{
			$ans="請問您說的地點是哪裡?";
		}
		if($info["nowState"]=="waitPlace2"){
			$info["nowState"]="waitPlace21";
			$ans="不好意思，可以把地點再告訴我一次嗎";
		}
		else{
			$info["nowState"]="waitPlace";
		}
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
		else{
			$info["nowState"]="waitEvent2";	
		}
		return 1;	
	}
	if($info["nowState"]=="waitEvent21"){
		$info["event"][0]=$input;
		pushInfoStack('event',$info['event'][0],$info);
		$info['timeNum']++;
		$info["nowState"]="";			
		return 1;	
	}
	if($info["eventNum"]==0){
		$ans="不好意思，可以請你把發生的事情再說一遍嗎?";
		if($info["nowState"]=="waitEvent2"){
			$info["nowState"]="waitEvent21";
		}
		else{
			$info["nowState"]="waitEvent";
		}
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
		else{
			$info["nowState"]="waitObj2";	
		}
		return 1;	
	}

	if($info["nowState"]=="waitObj21"){
		$info["obj"][0]=$input;
		pushInfoStack('obj',$info['obj'][0],$info);
		$info['objNum']++;
		$info["nowState"]="";			
		return 1;	
	}
	if($info["objNum"]==0){
			$ans="";
			//if($info["timeNum"]!=0){$ans=$info["time"][0];}
			$ans=$ans."跟誰";
			if($info["placeNum"]!=0){$ans=$ans."在".$info["place"][0];}
			if($info['eventNum']!=0){$ans=$ans.$info["event"][0];}
			
			if($info["nowState"]=="waitObj2"){
				$info["nowState"]="waitObj21";
				$ans="不好意思再問一次是".$ans;
			}
			else{
				$info["nowState"]="waitObj";
			}

			return 0;
	}
	$v=seg($info["obj"][0]);
	if($v[0]['pos']=="Nh"){
		$ans="請問這個".$info["obj"][0]."是指誰?";
		//$ans="請問您說的"."他"."是誰?";
		if($info["nowState"]=="waitObj2"){
			$info["nowState"]="waitObj21";
			$ans="不好意思再問一次"."這個".$info["obj"][0]."是指誰?";
		}
		else{
			$info["nowState"]="waitObj";
		}
		return 0;
	}
	//echo "oe";
	return 1;
}

function getTime($input){
	$ans="";
	if(timePreprocess($input,$ans)==1){
		return $ans;
	}

	$v=seg($input);
	$num=count($v);
	$ans="";
	for($i=0;$i<$num;$i++){
		if($v[$i]["pos"]=='Nd'){ 
			$ans= $v[$i]["word"] ;
			while(true){
				$i++;
				if($i<$num && $v[$i]["word"]){
					$ans=$ans.$v[$i]["word"];
				}
				else {
					break;
				}
			}
			return $ans;
		}
	}
	return "";
}


function getObj($input){
	$ans="";
	if(objPreprocess($input,$ans)==1){
		return $ans;
	}
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
	$ans="";
	if(placePreprocess($input,$ans)==1){
		return $ans;
	}
	$v=seg($input);
	$num=count($v);
	for($i=0;$i<$num;$i++){
		if($v[$i]["pos"]=='Nc') {return $v[$i]["word"] ;}
		if($v[$i]["pos"]=='Ncd') {return $v[$i]["word"] ;}
	}
	return "";
	
}

function getEvent($input){
	$ans="";
	if(eventPreprocess($input,$ans)==1){
		return $ans;
	}
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
	//if($info["questionType"]==""){
		$n=$info["infoStackNum"];
		$info["infoStack"][$n]["word"]=$input;
		$info["infoStack"][$n]["type"]=$type;
		$info["infoStackNum"]++;
	//}
}

function deleteAttributeStack(&$info){

	$info["infoStackNum"]--;

}

function clearQuestionInfo(&$info){
  $info['timeNum']=0;
  $info['objNum']=0;
  $info['placeNum']=0;
  $info['eventNum']=0;
  $info['nowState']="";
}

function clearInfoStack(&$info){
	$info['infoStackNum']=0;
}

function echoAllInfo($info,$first="",$end=""){
 	 echo $first."time".$info['time'][0].$end.' ';
	 echo $first."obj".$info['obj'][0].$end.' ';
	 echo $first."event".$info['event'][0].$end.' ';
	 echo $first."place".$info['place'][0].$end.' ';
}
?>