<?php
$time_start = microtime(true); 
/*
 * $filename: tên file convert (Word,Excel,PDF)
 * return: true/false
*/
function convertFileToText($filename){
	$infoFile = pathinfo($filename);
	$extFile = strtolower($infoFile['extension']);
	$cmd = '';
	if(($extFile == 'doc') || ($extFile == 'docx')){
		$cmd = "unzip -p ".$filename." word/document.xml | sed -e 's/<[^>]\{1,\}>//g; s/[^[:print:]]\{1,\}//g' > ".$infoFile['filename'].".txt";
	}elseif(($extFile == 'xls') || ($extFile == 'xlsx')){
		$cmd = "ssconvert -S ".$filename." ".$infoFile['filename'].".csv";
	}elseif($extFile == 'pdf'){
		$cmd = "pdftotext ".$infoFile['basename']." ".$infoFile['filename'].".txt";
	}
	putenv('LANG=en_US.UTF-8'); 
	return $cmd ? shell_exec($cmd) : false;
}

var_dump(convertFileToText('6.docx'));
$time_end = microtime(true);
echo "Time: ".(($time_end - $time_start)/60)."<br>";