<?php
function timePreprocess(&$input,&$ans){
	$t[0]="上周";
	$t[1]="上禮拜";
	$t[2]="下周";
	$t[3]="下禮拜";

	$i=0;
	$n=count($t);
	
	for($i=0;$i<$n;$i++){	
		if(ereg($t[$i],$input)==1){
			$ans=$t[$i];
			$input= preg_replace($t[$i],"",$inpur);
			return 1;	
		}
	}
		return 0;
}

function placePreprocess($input,&$ans){
	
	$i=0;
	$n=count($t);
	
	for($i=0;$i<$n;$i++){	
		if(ereg($t[$i],$input)==1){
			$ans=$t[$i];
			$input= preg_replace($t[$i],"",$inpur);
			return 1;	
		}
	}
		return 0;
}

function eventPreprocess($input,&$ans){
	
	$i=0;
	$n=count($t);
	
	for($i=0;$i<$n;$i++){	
		if(ereg($t[$i],$input)==1){
			$ans=$t[$i];
			$input= preg_replace($t[$i],"",$inpur);
			return 1;	
		}
	}
		return 0;
}

function objPreprocess($input,&$ans){
	
	$i=0;
	$n=count($t);
	
	for($i=0;$i<$n;$i++){	
		if(ereg($t[$i],$input)==1){
			$ans=$t[$i];
			$input= preg_replace($t[$i],"",$inpur);
			return 1;	
		}
	}
		return 0;
}

?>