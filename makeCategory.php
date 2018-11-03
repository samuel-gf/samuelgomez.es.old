<?php
    require("const.php");
    require("libGeneral.php");


	// Lee el contenido de las plantillas
	$tmplHeader = file_get_contents(TEMPLATES.'/header.php');
	// Remplaza campos en la plantilla header
	$info = file_get_contents(TEMPLATES.'/info.php');
	$menu = getMenu(SRC);
	$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');

	// Reemplaza campos en la plantilla foot
	$tmplFoot = str_replace('{{BASE_DIR}}','',$tmplFoot);
	$tmplFoot = str_replace('{{HTML_NAME}}','/index.html',$tmplFoot);

	// Obtiene todos los directorios donde existen archivos html
	$strArticulos = '';
	$arrDirs = getDirectorios(HTML);
	foreach ($arrDirs as $kDir => $vDir) {
		$strArticulos = '';
		$arrHtmlFiles = glob(HTML.'/'.$vDir.'/*.html');
		if (sizeof($arrHtmlFiles) >0){
			$numDirectorios = substr_count($vDir, '/')+2;	// Cuantos directorios de profundidad tiene el directorio destino
			$tmplHeader = str_replace('{{TÍTULO PÁGINA}}','Artículos recientes. '.AUTOR,$tmplHeader);
			$tmplHeader = str_replace('{{BASE_DIR}}',str_repeat('../',$numDirectorios),$tmplHeader);
			$tmplHeader = str_replace('{{INFO}}',$info,$tmplHeader);
			$tmplHeader = str_replace('{{MENU}}',$menu,$tmplHeader);
			foreach ($arrHtmlFiles as $kHtml => $vHtml) {
				$arrInfo = getArrInfoFromFile($vHtml, dirname($vHtml));
				$article = file_get_contents($vHtml);
				$r = preg_match("/<article(.*)<\/article>/s", $article, $arr);
				$article=$arr[0];
				$article = str_replace($arrInfo['título'],'<a id="enlacePermanente" href='.mb_substr($arrInfo['nombre'],1).'>'.$arrInfo['título'].'</a>',$article);	// Pon la URL correcta
				$strArticulos .= $article;
			}
			// Escribe index.html en disco
			$fArticulo = fopen(HTML.'/'.$vDir.'/index.html', 'w');
			fwrite($fArticulo, $tmplHeader);
			fwrite($fArticulo, $strArticulos);
			fwrite($fArticulo, $tmplFoot);
			fclose($fArticulo);
		}
	}
