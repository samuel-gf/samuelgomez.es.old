<?php

# Action ordered to the script
$a = array_key_exists('a', $_GET)?$_GET['a']:NULL;
$htmlCaller = array_key_exists('htmlcaller', $_GET)?$_GET['htmlcaller']:NULL; // Ej: html/matematicas/tecnologia/2018-10-21.katex-vs-mathjax.html

# Remove first directory of the html caller string
$arrTmp = explode("/", $htmlCaller);
unset($arrTmp[0]);
$htmlCaller = implode("/", $arrTmp);

#$url = $_SERVER['SCRIPT_URI'];
$url = $htmlCaller;
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$clienteIp = $_SERVER['REMOTE_ADDR'];
$idioma = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$tsRequest = $_SERVER['REQUEST_TIME'];
$path_parts = pathinfo($htmlCaller);
$fileDestName = 'log/counters/'.$path_parts['dirname'].'/'.$path_parts['filename'].'.txt';
$now = date('Y-m-d H.i.s', $tsRequest);
$today = date('Y-m-d', $tsRequest);
$month = date('Y-m', $tsRequest);
$year = date('Y', $tsRequest);


if ($a == 1){	// Register a visit
	$linea = "$now:$url:$idioma:$clienteIp:$userAgent";

	!file_exists('log/d')?mkdir('log/d', 0755, true):NULL;
	$fLogD = file_put_contents("log/d/$today.log", $linea.PHP_EOL , FILE_APPEND | LOCK_EX);
	!file_exists('log/m')?mkdir('log/m', 0755, true):NULL;
	$fLogM = file_put_contents("log/m/$month.log", $linea.PHP_EOL , FILE_APPEND | LOCK_EX);
	!file_exists('log/y')?mkdir('log/y', 0755, true):NULL;
	$fLogY = file_put_contents("log/y/$year.log", $linea.PHP_EOL , FILE_APPEND | LOCK_EX);

	!file_exists('log/counters/'.dirname($htmlCaller))?mkdir('log/counters/'.dirname($htmlCaller), 0755, true):NULL;
	$num = getNumVisits($fileDestName);
	$num++;
	echo "document.write('Visitas: <b>".$num."</b>');";
	$fCounterNum = file_put_contents($fileDestName, $num, LOCK_EX);
}
if ($a == 2){	// Show image with visit number
	header("Content-type: image/png");
	$cadena = getNumVisits($fileDestName);
	$im     = imagecreatetruecolor(200, 25);
	$fondo = imagecolorallocate($im, 255, 255, 255);
	imagefill($im, 0, 0, $fondo);
	$black = imagecolorallocate($im, 0, 0, 0);
	imagestring($im, 5, 10, 10, $cadena, $black);
	imagepng($im);
	imagedestroy($im);
}
if ($a == 3){	// Show text with visit number
	echoNumber($fileDestName);
}

function getNumVisits($fileDestName){
	$num = file_exists($fileDestName)?file_get_contents($fileDestName):0;
	return $num;
}

function echoNumber($fileDestName){
	$num = getNumVisits($fileDestName);
	Header("content-type: application/x-javascript");
	echo "document.write('Visitas: <b>".$num."</b>');";
}
