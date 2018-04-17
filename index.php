<html>
<head>
</head>
<body>
	<?php
	include 'functions.php';
	echo '<p>'.'TMA Sample Output from Module Data Files'.'</p>';
	echo '<p>'.'Module Header Data'.'</p>';
	$files = array('ppGM.txt','p1IH.txt','DTT1.txt');
	foreach ($files as $file){
		$handle = fopen($file,'r');
		echo '<p>'.'File Name: '."$file".'</p>';
		$firstLine = true;
		while (!feof($handle)){
			if($firstLine){
				$titles = fgets($handle, 1024);
				list($moduleCode, $moduleTitle, $tutor, $date) = explode(',',$titles);
				$arrayModuleCode = str_split($moduleCode, 2);
				$currentYear = str_split((date('Y')),2);
				$currentMonth = date('m');
				$accademicYear = $arrayModuleCode[1]+$arrayModuleCode[2];
				$yearPlus = $currentYear[1] + ($currentYear[1]+1);
				$yearMinus = ($currentYear[1]-1) + $currentYear[1];
				if (($arrayModuleCode[0] != 'PP') && ($arrayModuleCode[0] != 'P1') && ($arrayModuleCode[0] != 'DT') or ($arrayModuleCode[3] != 'T1') && ($arrayModuleCode[3] != 'T2') && ($arrayModuleCode[3] != 'T3') or (($currentMonth >= '8') && ($accademicYear != $yearPlus)) or (($currentMonth < '8') && ($accademicYear != yearMinus))){
					echo '<p>'.'Module Code : '.$moduleCode.' ERROR'.'</p>';
				}else{
				echo '<p>'.'Module Code : '.$moduleCode.'</p>';
				}
				if (empty(trim($moduleTitle))) {
					echo '<p>'.'Module Title : '.'ERROR'.'</p>';
				} else { 
					echo '<p>'.'Module Title : '.$moduleTitle.'</p>';
				}
				if (empty(trim($tutor))) {
					echo '<p>'.'Tutor : '.'ERROR'.'</p>';
				} else { 
					echo '<p>'.'Tutor : '.$tutor.'</p>';
				}
				if (empty(trim($date))) {
					echo '<p>'.'Marked date : '.'ERROR'.'</p>';
				} else { 
				echo '<p>'.'Marked date : '.$date.'</p>';
				}	
				$firstLine = false;
			} else {
				$students = fgets($handle, 4096);
				list($studentCode,$mark) = explode(",",$students);
				$studentArr[] = $studentCode;
				$markArr[] = $mark;
				$markArr = array_map('trim', $markArr);
				$idMark = array_combine($studentArr,$markArr);
			}
		}
		echo '<p>'.'<br>'.'Student ID and Mark data read from the filr...'.'<br>'.'</p>';
		foreach($idMark as $key => $value) {
			if(!ctype_digit($key)) {
				echo '<p>'.$key.' : '.$value.' ERROR wrong ID'.'</p>';
				unset($idMark[$key],$idMark[$value]);
			}elseif(strlen((string)$key)>8 or strlen((string)$key)<8) {
				echo '<p>'.$key.' : '.$value.' ERROR wrong ID'.'</p>';
				unset($idMark[$key],$idMark[$value]);
			}elseif(!ctype_digit($value)){
				echo '<p>'.$key.' : '.$value.' ERROR wrong mark'.'</p>';
				unset($idMark[$key],$idMark[$value]);
			}elseif($value > 100){
				echo '<p>'.$key.' : '.$value.' ERROR wrong mark'.'</p>';
				unset($idMark[$key],$idMark[$value]);
			}else{
				echo '<p>'.$key.' : '.$value.'</p>';
			}
		}
		echo '<p>'.'<br>'.'ID\'s and module marks to be included...'.'<br>'.'</p>';
		foreach($idMark as $key => $value) {
			echo '<p>'.$key.' : '.$value.'</p>';
		}
		echo '<p>'.'<br>'.'Statistical Analysis of module marks...'.'<br>'.'</p>';
		foreach ($idMark as $value){
			$markMmmr[]=$value;
		}
		echo '<p>'.'Mean : '.intval(mmmr ($markMmmr,$output = 'mean')).'</p>';
		echo '<p>'.'Mode : '.mmmr ($markMmmr,$output = 'mode').'</p>';
		echo '<p>'.'Range : '.mmmr ($markMmmr,$output = 'range').'</p>';
	
		echo '<p>'.'<br>'.'Grade Distribution of module marks...'.'<br>'.'</p>';
		$dist = 0;
		$merit = 0;
		$pass = 0;
		$fail = 0;
		foreach($idMark as $key => $value) {
			if($value >= 70 ) {
				$dist++;
			}elseif($value >= 60 && $value <= 69 ){
				$merit++;
			}elseif($value >= 40 && $value <= 59 ){
				$pass++;
			}else{
				$fail++;
			}
		}
		echo '<p>'.'Dist : '.$dist.'<br>'.'</p>';
		echo '<p>'.'Merit : '.$merit.'<br>'.'</p>';
		echo '<p>'.'Pass : '.$pass.'<br>'.'</p>';
		echo '<p>'.'Fail : '.$fail.'<br>'.'</p>';
		echo '<p>'.'<br>'.'---------------------------------------------------------------------'.'<br>'.'</p>';
		unset($idMark,$markArr,$studentArr,$markMmmr,$studentCode,$mark);
		}fclose ($handle);
	?>
</body>
</html>