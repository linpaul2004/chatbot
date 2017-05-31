<?php
include_once "config.php";

session_start();
$date = new DateTime('now');
$day = $date->format('Y-m-d');
$time = $date->format('H:i:s');
mysqli_query($link,"SET NAMES UTF8");
include_once "questionInfoAcquire.php"
if(isset($_SESSION['record'])==false){
    $_SESSION['record']=array();
}
$sentence=urldecode($_POST[string]);
$questionTime=array();
$questionPlace=array();
$questionObject=array();
$questionEvent=array();
$info=array();

$info['event']=new array();
$info['time']=new array();
$info['place']=new array();
$info['obj']=new array();

$info=$_SESSION['questionInfo'];
$questionTime['amount']=0;
$questionEvent['amount']=0;
$questionObject['amount']=0;
$questionPlace['amount']=0;
$info['amount']=0;
$info=$_SESSION['questionInfo'];


$now=count($_SESSION['record']); 

$ans=array();
if(!timeAcquire($now,&$questionTime,&$ans,&$info)){
	$response=$ans;
}
elseif(!placeAcquire($now,&$questionPlace,&$ans,&$info)){
	$response=$ans;
}
elseif(!eventAcquire($now,&$questionEvent,&$ans,&$info)){
	$response=$ans;
}
elseif(!objectAcquire($now,&$questionObject,&$ans,&$info)){
	$response=$ans;
}

$_SESSION['questionInfo']=$info;



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




//$now=count($_SESSION['record']); 
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