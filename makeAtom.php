<?php
# makeAtom.php 0.1
require("const.php");
require("libGeneral.php");
setlocale(LC_ALL, 'es_ES.UTF-8');

$atom = '<?xml version="1.0" encoding="utf-8"?>'."\n";
$atom.= '<feed xmlns="http://www.w3.org/2005/Atom">'."\n";
$atom.= '<title>SamuelGomez.es</title>'."\n";
$atom.= '<subtitle>Un sitio para la ciencia y la tecnología</subtitle>'."\n";
$atom.= '<link href="http://samuelgomez.es/atom.xml" rel="self" />'."\n";
$atom.= '<id>SamuelGomez.es</id>'."\n";
$atom.= '<updated>'.date("Y-m-d\TH:i:sP").'</updated>'."\n";

# Obtiene todos los .html y los ordena por fecha de más moderno a más antiguo en un array $arrFilesHtml
$arrFilesHtml = getArrFiles(HTML, 'html', $includeRoot=false);	// No incluyas root pq se incluiría a sí mismo
usort($arrFilesHtml, function($a, $b) {
		return ($a['fechaCreación'] > $b['fechaCreación'])?-1:1;
		});
foreach($arrFilesHtml as $fHtml){
	$atom.= '<entry>';
	$atom.= '<title></title>';
	$atom.= '<link rel="" />';
	$atom.= '</entry>';	
}
print_r($arrFilesHtml);
$atom.= '</feed>';
//echo $atom;
/*
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
		
		$title_html.= '<time>'.strftime('%e de %B de %G', strtotime($vHtml['fechaCreación'])).'</time>';
		$title_html .= '<h1><a class="enlacePermanente" href="'.mb_substr($vHtml['ficheroRutaRelativa'],1).'">'.$title.'</a></h1>';
		$title_html .= (sizeof($arrImage)>0)?'<img src="'.$arrImage[1].'" alt="'.$arrImage[2].'" class="miniIndex">':'';
		$title_html .= $firstsParagraphs;
		$title_html .= '<p class="leerMas"><a href="'.mb_substr($vHtml['ficheroRutaRelativa'],1).'">Leer más ...</a></p>';
		$title_html .= '</div>'."\n\n";
		$strArticulos .= $title_html;
	}
}

// Escribe index.html en disco
$fArticulo = fopen(HTML.'/index.html', 'w');
fwrite($fArticulo, $tmplHeader);
fwrite($fArticulo, "$strArticulos</ul>\n");
fwrite($fArticulo, $tmplFoot);
fclose($fArticulo);*/
