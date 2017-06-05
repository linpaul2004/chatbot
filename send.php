<?php
include_once "config.php";
include_once "questionInfoAcquire.php";
include_once "match.php"

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

if(isset($_SESSION['eventNum']))       $eventNum=$_SESSION['eventNum'];
if(isset($_SESSION['timeNum']))        $timeNum=$_SESSION['timeNum'];
if(isset($_SESSION['placeNum']))       $placeNum=$_SESSION['placeNum'];
if(isset($_SESSION['objNum']))         $objNum=$_SESSION['objNum'];
if(isset($_SESSION['nowState']))       $info['nowState']=$_SESSION['nowState'];
if(isset($_SESSION['infoStackNum']))  $info['infoStackNum']=$_SESSION['infoStackNum'];

for($i=0;$i<$eventNum;$i++)            $info['event'][$i]=$_SESSION['event'][$i];
for($i=0;$i<$objNum;$i++)              $info['obj'][$i]=$_SESSION['obj'][$i];
for($i=0;$i<$timeNum;$i++)             $info['time'][$i]=$_SESSION['time'][$i];
for($i=0;$i<$placeNum;$i++)            $info['place'][$i]=$_SESSION['place'][$i];
for($i=0;$i<$info["infoStackNum"];$i++)$info['infoStack'][$i]=$_SESSION['infoStack'][$i];

$info['eventNum']=$eventNum;
$info['timeNum']=$timeNum;
$info['placeNum']=$placeNum;
$info['objNum']=$objNum;
$ans='';

//////start analyize

if(($eventNum+$objNum+$placeNum+$timeNum)==0)
  firstInfoAcquire($sentence,$info);

if($info["nowState"]=="waitTime") timeAcquire($sentence,$ans,$info);
else if($info["nowState"]=="waitPlace") placeAcquire($sentence,$ans,$info);
else if($info["nowState"]=="waitObj") objAcquire($sentence,$ans,$info);
else if($info["nowState"]=="waitEvent") EventAcquire($sentence,$ans,$info);





if($eventNum<=0||$placeNum<=0||$objNum<=0||$timeNum<=0){

  while(1){
  $tem=rand(1,4);
    if($tem==1)      if(!timeAcquire($sentence,$ans,$info))  break;
    else if ($tem==2)if(!placeAcquire($sentence,$ans,$info)) break;
    else if ($tem==3)if(!eventAcquire($sentence,$ans,$info)) break;
    else if ($tem==4)if(!objectAcquire($sentence,$ans,$info))break;
	}
  $response=$ans;
}
$info["infoStackNum"]=$info['timeNum']+$info['eventNum']+$info['placeNum']+$info['objNum'];

//data store


$_SESSION['eventNum']=$info['eventNum'];
$_SESSION['objNum']=$info['objNum'];
$_SESSION['placeNum']=$info['placeNum'];
$_SESSION['timeNum']=$info['timeNum'];
$_SESSION["infoStackNum"]=$info["infoStackNum"];

for($i=0;$i<$info['eventNum'];$i++)   $_SESSION['event'][$i]=$info['event'][$i];
for($i=0;$i<$info['objNum'];$i++)     $_SESSION['obj'][$i]=$info['obj'][$i];
for($i=0;$i<$info['placeNum'];$i++)   $_SESSION['place'][$i]=$info['place'][$i];
for($i=0;$i<$info['timeNum'];$i++)    $_SESSION['time'][$i]=$info['time'][$i];
for($i=0;$i<$info["infoStackNum"];$i++)$_SESSION['infoStack'][$i]=$info['infoStack'][$i];
$_SESSION["nowState"]==$info["nowState"];

if(!($eventNum<=0||$placeNum<=0||$objNum<=0||$timeNum<=0))$response=match($ans,$info);

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
for($i=count($_SESSION['record'])-1;$i>=0;$i--){
    if($i%2==1){
        echo("<div class=\"row\">\n<div class=\"right\"><span class=\"teal\" style=\"font-family:微軟正黑體;font-size:24px\">".$_SESSION['record'][$i]."</span></div>\n</div>");
    }else{
        echo("<div class=\"row\">\n<div class=\"left\"><span class=\"blue\" style=\"font-family:微軟正黑體;font-size:24px\">".$_SESSION['record'][$i]."</span></div>\n</div>");
    }
}
$response=rawurlencode($response);
if(isset($_SESSION['account'])){
    $query="INSERT INTO `f74032146`.`record` (`username`,`sentence`,`answer`,`day`,`time`) VALUES ('$_SESSION[account]','$_POST[string]','$response','$day','$time');";
    mysqli_query($link,$query);
}
?>