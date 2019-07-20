<?php
	# makeCategory.php	1.0
    require("const.php");
    require("libGeneral.php");

	# Lee el contenido de las plantillas
	$tmplHeaderOriginal = file_get_contents(TEMPLATES.'/header.php');
	
	# Remplaza campos en la plantilla header
	$info = file_get_contents(TEMPLATES.'/info.php');
	$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');

	# Reemplaza campos en la plantilla foot
	$tmplFoot = str_replace('{{BASE_DIR}}','',$tmplFoot);
	$tmplFoot = str_replace('{{HTML_NAME}}','/index.html',$tmplFoot);

	# Obtiene todos los directorios donde existen archivos html
	$strArticulos = '';
	$arrDirs = getDirectorios(HTML);
	foreach ($arrDirs as $kDir => $vDirRelativo) {
		$strArticulos = '';
		$arrHtmlFiles = glob(HTML.'/'.$vDirRelativo.'/*.html');
		if (sizeof($arrHtmlFiles) >0){
			$tmplHeader = $tmplHeaderOriginal;
			$numDirectorios = substr_count($vDirRelativo, '/')+1;	// Cuantos directorios de profundidad tiene el directorio destino
			//echo "$vDirRelativo ($numDirectorios)\n";
			$tmplHeader = str_replace('{{TÍTULO PÁGINA}}','Categoría. '.AUTOR,$tmplHeader);
			$tmplHeader = str_replace('{{BASE_DIR}}',str_repeat('../',$numDirectorios),$tmplHeader);
			$tmplHeader = str_replace('{{INFO}}',$info,$tmplHeader);
			$tmplHeader = str_replace('{{MENU}}', '<a id="nav-toggle" href="'.str_repeat('../',$numDirectorios).'menu.html">&#9776;</a>',$tmplHeader); //@TODO
			foreach ($arrHtmlFiles as $kHtml => $vHtmlFullName) {
				if (basename($vHtmlFullName) != 'index.html'){
					//echo "Procesando $vHtmlFullName\n";
					$arrInfo = getArrInfoFromHtmlFile($vHtmlFullName);
					$article = file_get_contents($vHtmlFullName);
					$r = preg_match("/<article(.*)<\/article>/s", $article, $arr);
					$article=$arr[0];
					$article = str_replace($arrInfo['título'],'<a id="enlacePermanente" href='.mb_substr($arrInfo['ficheroRutaRelativa'],1).'>'.$arrInfo['título'].'</a>',$article);	// Pon la URL correcta
					$strArticulos .= $article;
				}
			}
			// Escribe index.html en disco
			$fArticulo = fopen(HTML.'/'.$vDirRelativo.'/index.html', 'w');
			fwrite($fArticulo, $tmplHeader);
			fwrite($fArticulo, $strArticulos);
			fwrite($fArticulo, $tmplFoot);
			fclose($fArticulo);
		}
	}
