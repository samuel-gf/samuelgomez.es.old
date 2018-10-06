<?php
    require(__DIR__."/const.php");
    require(__DIR__."/lib/libGeneral.php");

	$tmplHeader = file_get_contents(TEMPLATES.'/header.php');
	$tmplArticle = file_get_contents(SRC.'/'.$argv[1]);
	$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');
	$info = file_get_contents(TEMPLATES.'/info.php');
	$menu = file_get_contents(TEMPLATES.'/menu.php');
	$dateOfFile = date('d/m/Y H:m',filemtime (SRC.'/'.$argv[1]));
	$now = date('d/m/Y H:m');

	// Obtiene el título del artículo
	$r = preg_match("/<h1>(.*)<time/s", $tmplArticle, $arrTitle);
	$title = trim($arrTitle[1]);
	$fileName = HTML.'/'.strToUrl($title).'.html';

	// Remplaza campos en la plantilla header
	$tmplHeader = str_replace('{{TÍTULO PÁGINA}}',$title,$tmplHeader);
	$tmplHeader = str_replace('{{INFO}}',$info,$tmplHeader);
	$tmplHeader = str_replace('{{MENU}}',$menu,$tmplHeader);

	// Remplaza campos en la plantilla artículo
	$tmplArticle = str_replace('{{NOW}}',$now,$tmplArticle);

	// Remplaza las fórmulas LaTex por MathML
	$r = preg_match_all("/<eq>(.*)<\/eq>/",$tmplArticle, $arrEq);
	//print_r($arrEq);	die();
	foreach ($arrEq[1] as $kEqLaTex => $vEqLaTex) {
		$mathEq = shell_exec('latexmlmath --pmml=- "'.$vEqLaTex.'"');
		$arrEq[2][$kEqLaTex] = $mathEq;
	}
	foreach ($arrEq[2] as $kEqMathML => $vEqMathML) {
		$tmplArticle = str_replace($arrEq[0][$kEqMathML], $arr[2][$kEqMathML], $tmplArticle);
	}

	// Escribe el fichero en disco
	$fArticulo = fopen($fileName, 'w');
	fwrite($fArticulo, $tmplHeader);
	fwrite($fArticulo, $tmplArticle);
	fwrite($fArticulo, $tmplFoot);
	fclose($fArticulo);
