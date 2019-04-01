<?php
require("const.php");
require("libGeneral.php");

// Carga la plantilla INFO
$info = file_get_contents(TEMPLATES.'/info.php');

// Carga y sustituye en la plantilla FOOT
$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');
$tmplFoot = str_replace('{{BASE_DIR}}','',$tmplFoot);
$tmplFoot = str_replace('{{HTML_NAME}}','/index.html',$tmplFoot);

// Carga y sustituye en la plantilla HEADER
$tmplHeader = file_get_contents(TEMPLATES.'/header.php');
$tmplHeader = str_replace('{{TÍTULO PÁGINA}}','Índice. '.AUTOR,$tmplHeader);
$tmplHeader = str_replace('{{INFO}}',$info,$tmplHeader);
$tmplHeader = str_replace('{{MENU}}', '<a id="nav-toggle" href="./menu.html">&#9776;</a>',$tmplHeader); 
$tmplHeader = str_replace('{{BASE_DIR}}','',$tmplHeader);


# Obtiene todos los .html y los ordena por fecha de más moderno a más antiguo en un array $arrFilesHtml
$arrFilesHtml = getArrFiles(HTML, 'html', $includeRoot=false);	// No incluyas root pq se incluiría a sí mismo
usort($arrFilesHtml, function($a, $b) {
		return ($a['fechaCreación'] > $b['fechaCreación'])?-1:1;
		});
array_splice($arrFilesHtml, 10);	// Creo que esto recorta el array de .md a solo 10 elementos	
$strArticulos = "<article><h1>Últimos artículos</h1>\n<ul>";
# Por cada artículo obtén el título y la fecha
foreach ($arrFilesHtml as $kHtml => $vHtml) {
	$contenido_html = file_get_contents($vHtml['ficheroRutaAbsoluta']);
	$titulo = getTitleFromHtml($contenido_html);
	$titulo_html = '<li><a class="enlacePermanente" href="'.mb_substr($vHtml['ficheroRutaRelativa'],1).'">'.$titulo.'</a></li>';
	$strArticulos .= $titulo_html;
}

// Escribe index.html en disco
$fArticulo = fopen(HTML.'/index.html', 'w');
fwrite($fArticulo, $tmplHeader);
fwrite($fArticulo, "$strArticulos</ul></article>");
fwrite($fArticulo, $tmplFoot);
fclose($fArticulo);
