<?php
    require("const.php");
    require("libGeneral.php");

	$arrFilesHtml = getArrFiles(HTML, 'html', $includeRoot=true);

	$sitemapTxt = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
	$sitemapTxt.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:codesearch="http://www.google.com/codesearch/schemas/sitemap/1.0">'."\n";	
	foreach ($arrFilesHtml as $kFileHtml => $arrFileHtml) {
		$sitemapTxt.="<url>\n";
		$sitemapTxt.="\t<loc>".BASE_URL.$arrFileHtml['nombre']."</loc>\n";
		$sitemapTxt.="\t<lastmod>".date("Y-m-d", $arrFileHtml['uModificacion'])."</lastmod>\n";
		//if (basename($arrFileHtml['nombre'])=='index.html'){
		if (preg_match("/index[0-9]*\.html/", basename($arrFileHtml['nombre']))){
			$sitemapTxt.="\t<changefreq>weekly</changefreq>\n";	// Páginas index.html
			$sitemapTxt.="\t<priority>1</priority>\n";
		} else {
			$sitemapTxt.="\t<changefreq>yearly</changefreq>\n";
			$sitemapTxt.="\t<priority>0.5</priority>\n";
		}
		$sitemapTxt.="</url>\n";
	}
	$sitemapTxt.="</urlset>\n";
	file_put_contents(HTML.'/sitemap.xml', $sitemapTxt);
