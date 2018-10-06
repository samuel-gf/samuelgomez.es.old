<?php
    require(__DIR__."/const.php");
    require(__DIR__."/lib/libGeneral.php");

	// Lee el contenido de las plantillas
	$tmplHeader = file_get_contents(TEMPLATES.'/header.php');
	$tmplArticle = file_get_contents(SRC.'/'.$argv[1]);
	$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');
	$info = file_get_contents(TEMPLATES.'/info.php');
	$menu = file_get_contents(TEMPLATES.'/menu.php');
	$dateOfFile = date('d/m/Y H:m',filemtime (SRC.'/'.$argv[1]));
	$now = date('d/m/Y H:m');

	// Obtiene el título del artículo extrayendolo del html original
	$r = preg_match("/<h1>[\r\n]*(.*)/", $tmplArticle, $arrTitle);
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
	foreach ($arrEq[1] as $kEqLaTex => $vEqLaTex) {
		$command = 'echo \'$$'.$vEqLaTex.'$$\' | pandoc -f html+tex_math_dollars -t html --mathml';
		$command = str_replace('\\', '\\\\', $command);
		$mathEq = shell_exec($command);
		$arrEq[2][$kEqLaTex] = $mathEq;
	}
	foreach ($arrEq[2] as $kEqMathML => $vEqMathML) {
		$tmplArticle = str_replace($arrEq[1][$kEqMathML], $vEqMathML, $tmplArticle);
	}


	// Escribe el artículo en disco
	$fArticulo = fopen($fileName, 'w');
	fwrite($fArticulo, $tmplHeader);
	fwrite($fArticulo, $tmplArticle);
	fwrite($fArticulo, $tmplFoot);
	fclose($fArticulo);
