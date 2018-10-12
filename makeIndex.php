<?php
    require("const.php");
    require(LIB."/libGeneral.php");
	require(TEMPLATES."/menu.php");

	// Lee el contenido de las plantillas
	$tmplHeader = file_get_contents(TEMPLATES.'/header.php');
	// Remplaza campos en la plantilla header
	$tmplHeader = str_replace('{{TÍTULO PÁGINA}}','Artículos más recientes',$tmplHeader);
	$info = file_get_contents(TEMPLATES.'/info.php');
	$tmplHeader = str_replace('{{INFO}}',$info,$tmplHeader);
	$menu = getMenu(SRC);
	$tmplHeader = str_replace('{{MENU}}',$menu,$tmplHeader);
	$tmplHeader = str_replace('{{BASE_DIR}}','',$tmplHeader);
	$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');


	// Obtiene todos los .html y los ordena por fecha de más moderno a más antiguo
	$arrFilesHtml = getArrFiles(HTML, 'html');
	usort($arrFilesHtml, function($a, $b) {
		return ($a['uModificacion'] > $b['uModificacion'])?-1:1;
		});
	array_splice($arrFilesHtml, 10);	// Creo que esto recorta el array de .md a solo 10 elementos

	$strArticulos = '';
	// Por cada artículo obtén el contenido
	foreach ($arrFilesHtml as $kHtml => $vHtml) {
		$article = file_get_contents($vHtml['nombreCompleto']);
		$r = preg_match("/<article(.*)<\/article>/s", $article, $arr);
		$article=$arr[0];
		$article = str_replace($vHtml['título'],'<a id="enlacePermanente" href='.mb_substr($vHtml['nombre'],1).'>'.$vHtml['título'].'</a>',$article);	// Pon la URL correcta
		$strArticulos .= $article;
	}


	// Escribe el artículo en disco
	$fArticulo = fopen(HTML.'/index.html', 'w');
	fwrite($fArticulo, $tmplHeader);
	fwrite($fArticulo, $strArticulos);
	fwrite($fArticulo, $tmplFoot);
	fclose($fArticulo);
