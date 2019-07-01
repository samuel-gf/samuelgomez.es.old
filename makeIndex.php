<?php
# makeIndex.php 1.0
require("const.php");
require("libGeneral.php");

# Carga la plantilla INFO
$info = file_get_contents(TEMPLATES.'/info.php');

# Carga y sustituye en la plantilla FOOT
$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');
$tmplFoot = str_replace('{{BASE_DIR}}','',$tmplFoot);
$tmplFoot = str_replace('{{HTML_NAME}}','/index.html',$tmplFoot);

# Carga y sustituye en la plantilla HEADER
$tmplHeader = file_get_contents(TEMPLATES.'/header.php');
$tmplHeader = str_replace('{{TÍTULO PÁGINA}}','Últimos artículos. '.AUTOR,$tmplHeader);
$tmplHeader = str_replace('{{INFO}}',$info,$tmplHeader);
$tmplHeader = str_replace('{{MENU}}', '<a id="nav-toggle" href="./menu.html">&#9776;</a>',$tmplHeader); 
$tmplHeader = str_replace('{{BASE_DIR}}','',$tmplHeader);

# Obtiene todos los .html y los ordena por fecha de más moderno a más antiguo en un array $arrFilesHtml
$arrFilesHtml = getArrFiles(HTML, 'html', $includeRoot=false);	// No incluyas root pq se incluiría a sí mismo
usort($arrFilesHtml, function($a, $b) {
		return ($a['fechaCreación'] > $b['fechaCreación'])?-1:1;
		});
$strArticulos = "<h4>Últimos artículos</h4>\n<ul>";

# Por cada artículo obtén el título, la fecha, el principio del texto...
$nArticles = 0;
foreach ($arrFilesHtml as $kHtml => $vHtml) {
	if(basename($vHtml['ficheroRutaRelativa'])!='index.html'){
		$nArticles++;
		if ($nArticles == MAX_ARTICLES_INDEX+1) break;
		$content_html = file_get_contents($vHtml['ficheroRutaAbsoluta']);
		$title = getTitleFromHtml($content_html);
		$arrImage = getImageFromHtml($content_html);
		if (array_key_exists(1, $arrImage)){
			$arrImage[1] = str_replace('../', '', $arrImage[1]);	// Adapta la URL de la imagen a la raíz
		}
		$firstsParagraphs = getFirstsParagraphs($content_html, N_FIRSTS_PARAGRAPHS_INDEX);
		$title_html = '<div class="liIndex">';
		$title_html .= '<h2><a class="enlacePermanente" href="'.mb_substr($vHtml['ficheroRutaRelativa'],1).'">'.$title.'</a></h2>';
		$title_html .= (sizeof($arrImage)>0)?'<img src="'.$arrImage[1].'" alt="'.$arrImage[2].'" class="miniIndex">':'';
		$title_html .= $firstsParagraphs;
		$title_html .= '<a class="enlacePermanente" href="'.mb_substr($vHtml['ficheroRutaRelativa'],1).'">Leer más ...</a>';
		$title_html .= '</div>'."\n\n";
		$strArticulos .= $title_html;
	}
}

// Escribe index.html en disco
$fArticulo = fopen(HTML.'/index.html', 'w');
fwrite($fArticulo, $tmplHeader);
fwrite($fArticulo, "$strArticulos</ul>\n");
fwrite($fArticulo, $tmplFoot);
fclose($fArticulo);
