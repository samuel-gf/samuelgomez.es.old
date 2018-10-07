<?php
    require("const.php");
    require(LIB."/libGeneral.php");
	require(TEMPLATES."/menu.php");

	// Lee el contenido de las plantillas
	$tmplHeader = file_get_contents(TEMPLATES.'/header.php');
	$tmplArticleFileName = str_replace('.html','.phtml',$argv[1]);
	$tmplArticleFileName = str_replace('html/', SRC.'/', $tmplArticleFileName);
	$tmplArticle = file_get_contents($tmplArticleFileName);
	$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');
	$info = file_get_contents(TEMPLATES.'/info.php');
	$menu = getMenu(SRC);
	$dateOfFile = date('d/m/Y H:i',filemtime ($tmplArticleFileName));
	$now = date('d/m/Y H:i');

	// Obtiene el título del artículo extrayendolo del html original
	$r = preg_match("/<h1>[\r\n\t.]*<a.*>[\r\n]*(.*)<\/a>/", $tmplArticle, $arrTitle);
	$title = trim($arrTitle[1]);
	$fileDestName = dirname($argv[1]).'/'.strToUrl($title).'.html';
	//echo str_replace(HTML,'',dirname($fileDestName))."\n"; die();
	$dirDestino = dirname($fileDestName);
	$numDirectorios = substr_count($dirDestino, '/');	// Cuantos directorios de profundidad tiene el directorio destino

	// Remplaza campos en la plantilla header
	$tmplHeader = str_replace('{{TÍTULO PÁGINA}}',$title,$tmplHeader);
	$tmplHeader = str_replace('{{INFO}}',$info,$tmplHeader);
	$tmplHeader = str_replace('{{MENU}}',$menu,$tmplHeader);
	$tmplHeader = str_replace('{{BASE_DIR}}',str_repeat('../',$numDirectorios),$tmplHeader);

	// Remplaza campos en la plantilla artículo
	$tmplArticle = str_replace('{{NOW}}',$now,$tmplArticle);
	$tmplArticle = str_replace('{{TÍTULO PÁGINA}}',$title,$tmplArticle);
	$tmplArticle = str_replace('{{URL_PERMANENTE}}',strToUrl($title).'.html',$tmplArticle);

	// Remplaza las fórmulas LaTex por MathML
	// $arrEq es un array con subarrays de ecuaciones
	//	$arrEq[0] es un array con las expresiones originales con $$
	//	$arrEq[1] es un array con las que no contienen $$
	$r = preg_match_all("/\\$\\$(.*)\\$\\$/s",$tmplArticle, $arrEq);
	if ($r > 0){	// No hay expresiones regulares que tratar
		foreach ($arrEq[1] as $kEqLaTex => $vEqLaTex) {
			$command = 'echo \'$$'.$vEqLaTex.'$$\' | pandoc -f html+tex_math_dollars -t html --mathml';
			$command = str_replace('\\', '\\\\', $command);
			$mathEq = shell_exec($command);
			$arrEq[2][$kEqLaTex] = $mathEq;	// El
		}
		// $arrEq[2] es un array con las expresiones en MathML
		foreach ($arrEq[2] as $kEqMathML => $vEqMathML) {
			$tmplArticle = str_replace($arrEq[0][$kEqMathML], $vEqMathML, $tmplArticle);
		}
	}

	// Escribe el artículo en disco
	!file_exists($dirDestino)?mkdir($dirDestino):NULL;

	$fArticulo = fopen($fileDestName, 'w');
	fwrite($fArticulo, $tmplHeader);
	fwrite($fArticulo, $tmplArticle);
	fwrite($fArticulo, $tmplFoot);
	fclose($fArticulo);
