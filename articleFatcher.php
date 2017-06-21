<?php
//$url="www.ptt.cc./bbs/Boy-Girl/M.1493873127.A.EC1.html";
//$res="aa";
//articleFatch($url,$res);
//echo $res;
function articleFatch($url,&$res){	
	$url=preg_replace('/\n/i','', $url);
	//$url="www.ptt.cc./bbs/Boy-Girl/M.1493873127.A.EC1.html";
	$url="https://".$url;
	$html_c = file_get_contents($url);	
	$html_a=mb_split('\n',$html_c);
	$cou=count($html_a);    //get the line amount of the html page;
	//print $cou."\n";    //print the line amount  of the html page
	//$res="bb";
	//$res="ggg";
	
	for($i=0;$i<$cou;$i++){
		if(ereg('作者',$html_a[$i])==1){
			//$res="cc";
			$i++;
			while(ereg('發信站: 批踢踢實業坊',$html_a[$i])!=1){
				//$res='dd';
				//$line= preg_replace('/^\s\s*/i', '', $html_a[$i]);  //delet unuseful
				//$line=preg_replace('<.*>', '', $line);
				$res=$res.$html_a[$i];
				$i++;				
			}
			break;
		}
	}
	$res=preg_replace('/--$/i','', $res);
}
?>