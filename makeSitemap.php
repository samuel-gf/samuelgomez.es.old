<?php
    require("const.php");
    require("libGeneral.php");

	$arrFilesHtml = getArrFiles(HTML, 'html', $includeRoot=true);

	$sitemapTxt = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
	$sitemapTxt.= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:codesearch="http://www.google.com/codesearch/schemas/sitemap/1.0">'."\n";	
	foreach ($arrFilesHtml as $kFileHtml => $arrFileHtml) {
		$sitemapTxt.="<url>\n";
		$sitemapTxt.="\t<loc>".BASE_URL.$arrFileHtml['ficheroRutaRelativa']."</loc>\n";
		$sitemapTxt.="\t<lastmod>".date("Y-m-d", $arrFileHtml['uModificacion'])."</lastmod>\n";
		$arrWeeklyUpdated = array('index.html', 'menu.html');
		if (in_array(basename($arrFileHtml['ficheroRutaRelativa']), $arrWeeklyUpdated)){
			$sitemapTxt.="\t<changefreq>weekly</changefreq>\n";	// index.html, menu.html	
			$sitemapTxt.="\t<priority>1</priority>\n";
		} else {
			$sitemapTxt.="\t<changefreq>yearly</changefreq>\n";
			$sitemapTxt.="\t<priority>0.5</priority>\n";
		}
		$sitemapTxt.="</url>\n";
	}
	$sitemapTxt.="</urlset>\n";
	file_put_contents(HTML.'/sitemap.xml', $sitemapTxt);
