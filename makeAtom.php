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
$atom.= "<id>".BASE_URL."/</id>\n";
$atom.= '<updated>'.date("Y-m-d\TH:i:s\Z").'</updated>'."\n";

# Obtiene todos los .html y los ordena por fecha de más moderno a más antiguo en un array $arrFilesHtml
$arrFilesHtml = getArrFiles(HTML, 'html', $includeRoot=false);	// No incluyas root pq se incluiría a sí mismo
usort($arrFilesHtml, function($a, $b) {
		return ($a['fechaCreación'] > $b['fechaCreación'])?-1:1;
		});
foreach($arrFilesHtml as $fHtml){
	$content_html = file_get_contents($fHtml['ficheroRutaAbsoluta']);
	$title = getTitleFromHtml($content_html);
	$atom.= "<entry>\n";
	$atom.= "\t<title>$title</title>\n";
	$atom.= "\t<link href='".BASE_URL.$fHtml['ficheroRutaRelativa']."' />\n";
	$atom.= "\t<updated>".date("Y-m-d\TH:i:s\Z", strtotime($fHtml['fechaCreación']))."</updated>\n";
	$atom.= "\t<author><name>Samuel Gómez</name></author>\n";
	$atom.= "\t<id>".BASE_URL.$fHtml['ficheroRutaRelativa']."</id>\n";
	$atom.= "\t<content type='xhtml'>\n";
	$atom.= "\t<div xmlns='http://www.w3.org/1999/xhtml'>\n";
	$arrImg = getImageFromHtml($content_html);
	if (array_key_exists(1, $arrImg)) {
		$url_img = '';
		if (strpos($arrImg[1], '../') === false){
			$url_img = $arrImg[1];	// Imagen hospedada en otro servidor
		} else {
			$url_img = BASE_URL."/".str_replace('../', '', $arrImg[1]);	// Imagen hospedada en este servidor
		}
		$atom.= "\t<img src='$url_img' alt='".$arrImg[2]."'/>\n";
	}
	$atom.= "\t".getContentFromHtml($content_html)."\n";
	$atom.= "\t</div></content>\n";
	$atom.= "</entry>\n";	
}
$atom.= '</feed>';
file_put_contents('html/atom.xml', $atom);
