	<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>感情諮詢機器人</title>
</head>
<body>
	<?php

	//fatch the last 20 page and print the topic title and url;
	//if you find the batter way than this ,just modify it,thanks.


	//fatch php
	$html_c = file_get_contents('https://www.ptt.cc/bbs/Boy-Girl/index.html');	
	$ur_base='www.ptt.cc';
	$url_base='https://www.ptt.cc/bbs/Boy-Girl/index';
	$html_a;
	$html_a=mb_split('\n',$html_c);
	$cou=count($html_a);    //get the line amount of the html page;
	//print $cou."\n";    //print the line amount  of the html page

	include_once "config.php";
	mysqli_query($link,"SET NAMES UTF8");

	for($i=0;$i<$cou;$i++){
		if(ereg("上頁</a>$",$html_a[$i])==1){
			//	print $i;    //  print the number
			$pageNUM;  //(all page amount of bg bord)-1;
			$pageNUM=$html_a[$i];
			$pageNUM= preg_replace('/^\s\s*/i', '', $pageNUM);  //delet unuseful space
			$pageNUM= preg_replace('/<a class="btn wide" href="\/bbs\/Boy-Girl\/index/i', '', $pageNUM);

			$pageNUM= preg_replace('/.html">&lsaquo; 上頁<\/a>/i', '', $pageNUM);
				//print $lineNUM;
			print "\n";
			break;
		}
	}
	//	echo $html_c;
	/////parse the last page
	for($i=0;$i<$cou;$i++){
		if(ereg("<div class=\"title\">",$html_a[$i])==1){
			$temLine=$html_a[$i+2];
			$i+=2;
			if(ereg("(本文已被刪除)",$temLine)==1)continue;
			$temLine= preg_replace('/^\s\s*/i', '', $temLine);//delet unuseful space
			$ur=preg_replace('/<a href="/i', '', $temLine);
			$ur=preg_replace('/<a href="/i', '', $ur);
			$ur=preg_replace('/">.*<\/a>$/s', '', $ur);
			$ti=preg_replace('/<a href="\/bbs\/Boy-Girl\/.*">/s', '', $temLine);
			$ti=preg_replace('/<\/a>/s', '', $ti);
			$pu=preg_replace('/">.*<\/a>$/s', '', $html_a[$i-4]);
			$pu=preg_replace('/<a href="/i', '',$pu);
			$pu=preg_replace('/<div class="nrec"><span class="hl f2">/s', '', $pu);
			$pu=preg_replace('/<div class="nrec"><span class="hl f1">/s', '', $pu);
			$pu=preg_replace('/<div class="nrec"><span class="hl f3">/s', '', $pu);
			$pu=preg_replace('/<\/span><\/div>/s', '', $pu);
			$pu=preg_replace('/<div class="nrec"><\/div>/s', '0', $pu);
			$pu=preg_replace('/XX/s', '-10', $pu);
			$pu=preg_replace('/X/s', '-', $pu);
			$pu=preg_replace('/爆/s', '100', $pu);
			$pu=preg_replace('/^\s*/s', '', $pu);

			//print $ur_base.$ur;      ///the url need to input into database;
			//print "\n";
			//print $ti;		///the title need to input into database;
			//print "\n";		
			//print $pu;    ///the push amount need to input into database
			//print "\n";
			//print $temLine;
			//print "\n";
			$query="INSERT INTO `f74032146`.`pttdata` (`url`,`title`,`push`) VALUES ('$ur_base.$ur','$ti','$pu');";
			echo($query."<br>");
			mysqli_query($link,$query);
		}

	}
	for($j=0;$j<50;$j++){  //parse the last 2-19 page;
		if(($pageNUM-$j)<=0)break;
		$html_c = file_get_contents($url_base.(intval($pageNUM)-$j).'.html');
		$html_a;
		$html_a=mb_split('\n',$html_c);
		$cou=count($html_a);
		for($i=0;$i<$cou;$i++){
			if(ereg("<div class=\"title\">",$html_a[$i])==1){
				$temLine=$html_a[$i+2];
				$i+=2;
				if(ereg("(本文已被刪除)",$temLine)==1)continue;
				$temLine= preg_replace('/^\s\s*/i', '', $temLine);//delet unuseful space
				$ur=preg_replace('/<a href="/i', '', $temLine);
				$ur=preg_replace('/<a href="/i', '', $ur);
				$ur=preg_replace('/">.*<\/a>$/s', '', $ur);
				$ti=preg_replace('/<a href="\/bbs\/Boy-Girl\/.*">/s', '', $temLine);
				$ti=preg_replace('/<\/a>/s', '', $ti);
				$pu=preg_replace('/">.*<\/a>$/s', '', $html_a[$i-4]);
				$pu=preg_replace('/<a href="/i', '',$pu);
				$pu=preg_replace('/<div class="nrec"><span class="hl f2">/s', '', $pu);
				$pu=preg_replace('/<div class="nrec"><span class="hl f1">/s', '', $pu);
				$pu=preg_replace('/<div class="nrec"><span class="hl f3">/s', '', $pu);
				$pu=preg_replace('/<\/span><\/div>/s', '', $pu);
				$pu=preg_replace('/<div class="nrec"><\/div>/s', '0', $pu);
				$pu=preg_replace('/XX/s', '-10', $pu);
				$pu=preg_replace('/X/s', '-', $pu);
				$pu=preg_replace('/爆/s', '100', $pu);
				$pu=preg_replace('/^\s*/s', '', $pu);
				//print $ur_base.$ur;  /////the url need to input into database;
				//print $ti;  //////the title need to input into database;
				//print $temLine;
				//print "\n";
				//print $pu;    ///the push amount need to input into database
				$query="INSERT INTO `f74032146`.`pttdata` (`url`,`title`,`push`) VALUES ('$ur_base.$ur','$ti','$pu');";
				echo($query."<br>");
				mysqli_query($link,$query);

			}
		}
	}

	echo("資料庫加入成功");

	?>
</body>

</html>