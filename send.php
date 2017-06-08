<?php
include_once "config.php";
include_once "questionInfoAcquire.php";
include_once "match.php";

session_start();
$date = new DateTime('now');
$day = $date->format('Y-m-d');
$time = $date->format('H:i:s');
mysqli_query($link,"SET NAMES UTF8");
//include_once "questionInfoAcquire.php"
if(isset($_SESSION['record'])==false){
  $_SESSION['record']=array();
}
$sentence=urldecode($_POST['string']);
$response="error";




///////data load
$info=array();
$info['event']=array();
$info['time']=array();
$info['place']=array();
$info['obj']=array();
$info['infoStack']=array();
$info['nowState']="";
$info['infoStackNum']=0;

$eventNum=0;
$timeNum=0;
$placeNum=0;
$objNum=0;

if(isset($_SESSION['eventNum'])){       $eventNum=$_SESSION['eventNum'];}
if(isset($_SESSION['timeNum'])){        $timeNum=$_SESSION['timeNum'];}
if(isset($_SESSION['placeNum'])){       $placeNum=$_SESSION['placeNum'];}
if(isset($_SESSION['objNum'])){         $objNum=$_SESSION['objNum'];}
if(isset($_SESSION['nowState'])){       $info['nowState']=$_SESSION['nowState'];}
if(isset($_SESSION['infoStackNum'])){  $info['infoStackNum']=$_SESSION['infoStackNum'];}
if(isset($_SESSION['questionType'])){    $info['questionType']=$_SESSION["questionType"];}


for($i=0;$i<$eventNum;$i++){            $info['event'][$i]=$_SESSION['event'][$i];}
for($i=0;$i<$objNum;$i++){              $info['obj'][$i]=$_SESSION['obj'][$i];}
for($i=0;$i<$timeNum;$i++){             $info['time'][$i]=$_SESSION['time'][$i];}
for($i=0;$i<$placeNum;$i++){            $info['place'][$i]=$_SESSION['place'][$i];}
for($i=0;$i<$info["infoStackNum"];$i++){$info['infoStack'][$i]=$_SESSION['infoStack'][$i];}

$info['eventNum']=$eventNum;
$info['timeNum']=$timeNum;
$info['placeNum']=$placeNum;
$info['objNum']=$objNum;
$ans='error ans';

//////start analyize
//echo "sum".($eventNum+$objNum+$placeNum+$timeNum). ' ';
//echoseg($sentence);
if(($eventNum+$objNum+$placeNum+$timeNum)==0){
  firstInfoAcquire($sentence,$info);
}

// echo "en1: ".$info['eventNum'].",";
// echo "pn1: ".$info['placeNum'].",";
// echo "on1: ".$info['objNum'].",";
// echo "tn1: ".$info['timeNum'].",";


if($info["nowState"]=="waitTime"){ timeAcquire($sentence,$ans,$info);}
else if($info["nowState"]=="waitPlace"){ placeAcquire($sentence,$ans,$info);}
else if($info["nowState"]=="waitObj"){ objectAcquire($sentence,$ans,$info);}
else if($info["nowState"]=="waitEvent"){ EventAcquire($sentence,$ans,$info);}

// echo "en2: ".$info['eventNum'].",";
// echo "pn2: ".$info['placeNum'].",";
// echo "on2: ".$info['objNum'].",";
// echo "tn2: ".$info['timeNum'].",";

if(($info['eventNum']<=0)||($info['placeNum']<=0)||($info['objNum']<=0)||($info['timeNum']<=0)){
  $temOk[0]=0;
  $temOk[1]=0;
  $temOk[2]=0;
  $temOk[3]=0;

  while(1){
    $tem=rand(0,3);
//echo 'a'.$tem.' ;';
    if(($temOk[0]+$temOk[1]+$temOk[2]+$temOk[3])>=4){
      break;
    }
    if($temOk[$tem]==1){
      continue;
    }
    if($tem==0){
      if(timeAcquire($sentence,$ans,$info)==0){
        break;
      }
    }  
    else if ($tem==1){
      if(placeAcquire($sentence,$ans,$info)==0){ 
       break;
      }
    }
    else if ($tem==2){
      if(eventAcquire($sentence,$ans,$info)==0) {
        break;
      }
    }
    else if ($tem==3){
      if(objectAcquire($sentence,$ans,$info)==0){
        break;
      }
    }
    $temok[$tem]=1;
 //   echo $tem;
  }
  $response=$ans;
}

// echo "en: ".$info['eventNum']."\n";
// echo "pn: ".$info['placeNum']."\n";
// echo "on: ".$info['objNum']."\n";
// echo "tn: ".$info['timeNum']."\n";
if($info["nowState"]=="needAskClear"){
  $response="要保留資訊嗎? yes or not";
  $info["nowState"]="waitClear";
}

else if ($info["nowState"]=="waitClear"){
    if($sentence=="yes"){
      clearQuestionInfo($info);
    }
    else{
      clearQuestionInfo($info);
      clearInfoStack($info);
    }
}

else if(!(($info['eventNum']<=0)||($info['placeNum']<=0)||($info['objNum']<=0)||($info['timeNum']<=0))){
  $response=match($ans,$info);
  $info["nowState"]="needAskClear"; 
}

if($sentence=="你好" ){
  $response="你好";
  clearQuestionInfo($info);
  clearInfoStack($info);
}



//data store
$_SESSION['eventNum']=$info['eventNum'];
$_SESSION['objNum']=$info['objNum'];
$_SESSION['placeNum']=$info['placeNum'];
$_SESSION['timeNum']=$info['timeNum'];
$_SESSION["infoStackNum"]=$info["infoStackNum"];

for($i=0;$i<$info['eventNum'];$i++)  { $_SESSION['event'][$i]=$info['event'][$i];}
for($i=0;$i<$info['objNum'];$i++)    { $_SESSION['obj'][$i]=$info['obj'][$i];}
for($i=0;$i<$info['placeNum'];$i++)  { $_SESSION['place'][$i]=$info['place'][$i];}
for($i=0;$i<$info['timeNum'];$i++)   { $_SESSION['time'][$i]=$info['time'][$i];}
for($i=0;$i<$info["infoStackNum"];$i++){$_SESSION['infoStack'][$i]=$info['infoStack'][$i];}
  
  $_SESSION["nowState"]=$info['nowState'];
  $_SESSION["questionType"]=$info["questionType"];





// if(strpos($sentence,'你好')!==false || strpos($sentence,'大家好')!==false || strpos($sentence,'嗨')!==false){
//     $response="你好～～！";
// }else{
//     $match=null;
//     $result=preg_match('/(他|她|它|牠|男(朋)?友|女(朋)?友|閃(光)?)(.*)(我)/',$sentence,$match);
//     if($result==0){
//        $response="抱歉，我聽不懂";
//     }else{
//        if($match[1]=="他"||$match[1]=="她"||$match[1]=="它"||$match[1]=="牠"||$match[1][0]=="閃"){
//            $response="請問那個「".$match[1]."」是誰呢？";
//        }else{
//            $response="怎麼了，為什麼".$match[5]."你呢？";
//         }
//     }
// }




$now=count($_SESSION['record']); 
$_SESSION['record'][$now]=$sentence;
$_SESSION['record'][$now+1]=$response;
echo("<h1>\n<div class=\"send\">\n你好，我是感情諮詢ChatBot，<br>請問你想要問什麼？</div></h1>");
for($i=0;$i<count($_SESSION['record']);$i++){
  if($i%2==1){
    echo("<h1>\n<div class=\"send\">\n".$_SESSION['record'][$i]."</div></h1>");
  }else{
    echo("<h2>\n<div class=\"user\">\n".$_SESSION['record'][$i]."</div></h2>");
  }
}
$response=rawurlencode($response);


if(isset($_SESSION['account'])){
  $query="INSERT INTO `f74032146`.`record` (`username`,`sentence`,`answer`,`day`,`time`) VALUES ('$_SESSION[account]','$_POST[string]','$response','$day','$time');";
  mysqli_query($link,$query);
}

?>