<?php
    require("const.php");
    require("libGeneral.php");
	// Lee el contenido de las plantillas
	$tmplHeader = file_get_contents(TEMPLATES.'/header.php');
	$fileDestNameCompleto = ROOT.'/'.$argv[1];	// Archivo a construir con ruta completa
	$fileNameMd = str_replace('.html', SRC_EXT, $argv[1]);
	$fileNameMd = str_replace('html/', SRC.'/', $fileNameMd);
	$tmplArticle = file_get_contents($fileNameMd);
	preg_match("/#(.*)/s",$tmplArticle, $arrMatch);	// Coge todo el contenido menos los metadatos del .md
	//preg_match("/((.*)---){2}(.*)/s",$tmplArticle, $arrMatch);	// Coge todo el contenido menos los metadatos del .md
	$tmplArticle = trim($arrMatch[0]);
	$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');
	$info = file_get_contents(TEMPLATES.'/info.php');
	$menu = getMenu(SRC);
	// Obtiene el título del artículo extrayendolo del texto del .md mirando lo que viene después del primer #
	$title = getTitleFromMd($tmplArticle);
	$numDirectorios = substr_count($argv[1], '/')-1;	// Cuantos directorios de profundidad tiene el directorio destino
	// Obtiene las etiquetas
	$arrTags = array();
	//preg_match_all('/[^(]#([\w\-öáéíóúÁÉÍÓÚñÑ]+)/', $tmplArticle, $arrTags);
	preg_match_all('/[^(]#([^\s#]+)/', $tmplArticle, $arrTags);
	$sTags = rtrim(implode(', ', $arrTags[1]), ', ');
	// Obtiene la fecha de creación del artículo a partir del nombre
	$fechaCreacion = (explode('.',basename($fileNameMd)))[0];
	$tsFileMd = strtotime($fechaCreacion);
	$dateOfFileShort = date('d/m/Y H:i',$tsFileMd);
	$dateOfFileLong = strftime('%e de %B de %G', $tsFileMd);
	// Cambia el nombre del archivo fuente .md acorde al título del artículo
	if ($fileNameMd!=dirname($fileNameMd).'/'.$fechaCreacion.'.'.strToUrl($title).'.md'){
		//echo "Renombrado $fileNameMd por ".dirname($fileNameMd).'/'.$fechaCreacion.'.'.strToUrl($title).'.md';
		rename($fileNameMd, dirname($fileNameMd).'/'.$fechaCreacion.'.'.strToUrl($title).'.md');
		$fileNameMd = dirname($fileNameMd).'/'.$fechaCreacion.'.'.strToUrl($title).'.md';
		$fileDestNameCompleto = dirname($fileDestNameCompleto).'/'.$fechaCreacion.'.'.strToUrl($title).'.html';
	}
	// Remplaza campos en la plantilla article
	//$tmplArticle = str_replace('{{FECHA}}',"<time>$dateOfFileLong</time>",$tmplArticle);
	// Reemplaza campos en la plantilla article
	$tmplArticle = str_replace('{{BASE_DIR}}',str_repeat('../',$numDirectorios),$tmplArticle);	
	// Modifica el fichero .md con los datos de la plantilla pero mantiene la fecha original
	$tmplArticle = "---\ntitle: $title\nauthor: ".AUTOR."\ndate: $fechaCreacion\nkeywords: $sTags\n---\n\n".$tmplArticle;
	//$tmplArticle = "% $title\n% ".AUTOR."\n% $fechaCreacion\n\n".$tmplArticle;
	$fArticulo = fopen($fileNameMd, 'w');
	fwrite($fArticulo, $tmplArticle);
	fclose($fArticulo);
	touch($fileNameMd, $tsFileMd);
	// pandoc .md -> .html
	//echo "***".strToUrl(dirname($fileDestNameCompleto))."****\n";	die();
	!file_exists(dirname($fileDestNameCompleto))?mkdir(dirname($fileDestNameCompleto), 0755, true):NULL;
	//$command = "pandoc $fileNameMd -f markdown+tex_math_dollars --mathml -o $fileDestNameCompleto";
	$command = "pandoc $fileNameMd -f markdown+tex_math_dollars-fancy_lists --katex -o $fileDestNameCompleto";
	//echo $command."\n";
	echo shell_exec($command)."\n";
	// Remplaza campos en la plantilla header
	$tmplHeader = str_replace('{{TÍTULO PÁGINA}}',$title,$tmplHeader);
	$tmplHeader = str_replace('{{INFO}}',$info,$tmplHeader);
	$tmplHeader = str_replace('{{MENU}}',$menu,$tmplHeader);
	$tmplHeader = str_replace('{{BASE_DIR}}',str_repeat('../',$numDirectorios),$tmplHeader);

	// Reemplaza campos en la plantilla foot
	$tmplFoot = str_replace('{{BASE_DIR}}',str_repeat('../',$numDirectorios),$tmplFoot);
	$tmplFoot = str_replace('{{HTML_NAME}}',$argv[1],$tmplFoot);
	// Agrega la plantilla cabecera y pie al .html
	$htmlArticle = file_get_contents($fileDestNameCompleto);
	$htmlArticle = preg_replace("/[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}/s","<time datetime='$fechaCreacion' pubdate='$fechaCreacion'>$dateOfFileLong</time>", $htmlArticle);	// Pone a la fecha las etiquetas <time></time>

	$articulo = "<article>\n".$htmlArticle."\n</article>\n";
	$fArticulo = fopen($fileDestNameCompleto, 'w');
	fwrite($fArticulo, $tmplHeader);
	fwrite($fArticulo, $articulo);
	fwrite($fArticulo, $tmplFoot);
	fclose($fArticulo);
