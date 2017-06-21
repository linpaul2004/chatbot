<?php
function timePreprocess(&$input,&$ans){
	$t=array();
	$t[0]="上周";
	$t[1]="上禮拜";
	$t[2]="下周";
	$t[3]="下禮拜";

	$i=0;
	$n=count($t);
	
	for($i=0;$i<$n;$i++){	
		if(strpos($input,$t[$i])!==false){
			$ans=$t[$i];
			//$input= preg_replace($t[$i],"",$inpur);
			return 1;	
		}
	}
		return 0;
}

function placePreprocess($input,&$ans){
	$t=array();
	$t[0]="我家";
	$t[1]="新光三越";
	$t[2]="台北車站";
	$i=0;
	$n=count($t);
	
	for($i=0;$i<$n;$i++){	
		if(strpos($input,$t[$i])!==false){
			$ans=$t[$i];
			//$input= preg_replace($t[$i],"",$inpur);
			return 1;	
		}
	}
		return 0;
}

function eventPreprocess($input,&$ans){
	$t=array();
	$t[0]="打炮";
	$t[1]="約炮";
	$t[2]="劈腿";
	$t[3]="出軌";
	$t[4]="外遇";
	$t[5]="偷吃";


	$i=0;
	$n=count($t);
	

	for($i=0;$i<$n;$i++){	
		if(strpos($input,$t[$i])!==false){
			$ans=$t[$i];
			//$input= preg_replace($t[$i],"",$inpur);
			return 1;	
		}
	}
		return 0;
}

function objPreprocess($input,&$ans){
	$t=array();
	$t[0]="閃光";
	$t[1]="男友";
	$t[2]="女友";
	$t[3]="老爺";
	$t[4]="老婆";
	$t[5]="老公";

	$i=0;
	$n=count($t);
	for($i=0;$i<$n;$i++){	
		if(strpos($input,$t[$i])!==false){
			$ans=$t[$i];
			//$input= preg_replace($t[$i],"",$inpur);
			return 1;	
		}
	}
		return 0;
}

?>