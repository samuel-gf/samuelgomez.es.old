<?php
    require("const.php");
    require("libGeneral.php");
	
	# Recibe como parámetro la ruta relativa del .html a construir
  	$fRelativeHtml = $argv[1];
  	$fAbsoluteHtml = ROOT.'/'.$fRelativeHtml;	// Ruta absoluta + archivo .html
  	$numDir = substr_count($fRelativeHtml, '/')-1;	// Cuantos directorios de profundidad tiene el directorio destino

	# Lee el contenido de las plantillas
	$tmplHeader = file_get_contents(TEMPLATES.'/header.php');
	$fAbsoluteMd = getFullFileNameMdFromHtml($fRelativeHtml);  // Ruta absoluta + archivo .md
	$tmplArticle = file_get_contents($fAbsoluteMd);
	$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');
	$info = file_get_contents(TEMPLATES.'/info.php');

  	# PLANTILLA ARTÍCULO .md
	$tmplArticle = getContentWithoutMetadata($tmplArticle);
	$title = getTitleFromMd($tmplArticle); 

	# Obtiene las etiquetas o keywords
	$arrTags = array();
	preg_match_all('/[^(]#([^\s#]+)/', $tmplArticle, $arrTags);
	$sTags = rtrim(implode(', ', $arrTags[1]), ', ');

  	# Obtiene la fecha de creación del artículo a partir del nombre del .md  
	$arrFecha_tmp = explode('-',basename($fAbsoluteMd));
	$fechaCreacion = $arrFecha_tmp[0].'-'.$arrFecha_tmp[1].'-'.$arrFecha_tmp[2];
	$tsFileMd = strtotime($fechaCreacion);
	$dateOfFileShort = date('d/m/Y H:i',$tsFileMd);
	$dateOfFileLong = strftime('%e de %B de %G', $tsFileMd);

  	# Cambia el nombre del archivo fuente .md acorde al título del artículo solo si ha cambiado
	$new_absolute_md = dirname($fAbsoluteMd).'/'.$fechaCreacion.'-'.strToUrl($title).'.md';
	$new_absolute_html = dirname($fAbsoluteHtml).'/'.$fechaCreacion.'-'.strToUrl($title).'.html';
	if ($fAbsoluteMd!=$new_absolute_md){
		//echo "Renombrado $fAbsoluteMd por $new_absolute_md";
		rename($fAbsoluteMd, $new_absolute_md);
		$fAbsoluteMd = $new_absolute_md;
		$fAbsoluteHtml = $new_absolute_html;
	}

  	# Replace fields in $tmpArticle
	$tmplArticle = str_replace('{{BASE_DIR}}',str_repeat('../',$numDir),$tmplArticle);
	
	# Modifica el fichero .md con los datos de la plantilla pero mantiene la fecha original
	$tmplArticle = "---\ntitle: $title\nauthor: ".AUTOR."\ndate: $fechaCreacion\nkeywords: $sTags\n---\n\n".$tmplArticle;
	$fArticulo = fopen($fAbsoluteMd, 'w');
	fwrite($fArticulo, $tmplArticle);
	fclose($fArticulo);
	touch($fAbsoluteMd, $tsFileMd);

  	# pandoc .md -> .html
	//echo "***".strToUrl(dirname($fAbsoluteHtml))."****\n";	die();
	!file_exists(dirname($fAbsoluteHtml))?mkdir(dirname($fAbsoluteHtml), 0755, true):NULL;
	//$command = "pandoc $fAbsoluteMd -f markdown+tex_math_dollars --mathml -o $fAbsoluteHtml";
	$command = "pandoc $fAbsoluteMd -f markdown+tex_math_dollars-fancy_lists --katex -o $fAbsoluteHtml";
	exec($command, $arrOutput, $nReturnCode)."\n"; // Solo por si existe algún error
	if ($nReturnCode != 0){
		$strArrOutput = implode($arrOutput);
		echo "[Pandoc error $nReturnCode] $strArrOutput";
	}
	
	# Remplaza campos en la plantilla header
	$tmplHeader = str_replace('{{TÍTULO PÁGINA}}',$title,$tmplHeader);
	$tmplHeader = str_replace('{{INFO}}',$info,$tmplHeader);
	$tmplHeader = str_replace('{{MENU}}', '<a id="nav-toggle" href="'.str_repeat('../',$numDir).'menu.html">&#9776;</a>',$tmplHeader);
	$tmplHeader = str_replace('{{BASE_DIR}}',str_repeat('../',$numDir),$tmplHeader);

	# Reemplaza campos en la plantilla foot
	$tmplFoot = str_replace('{{BASE_DIR}}',str_repeat('../',$numDir),$tmplFoot);
	$tmplFoot = str_replace('{{HTML_NAME}}',$fRelativeHtml,$tmplFoot);

	# Agrega la plantilla cabecera y pie al .html
	$htmlArticle = file_get_contents($fAbsoluteHtml);
	$htmlArticle = preg_replace("/[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}/s","<time datetime='$fechaCreacion' pubdate='$fechaCreacion'>$dateOfFileLong</time>", $htmlArticle);	// Pone a la fecha las etiquetas <time></time>

	$articulo = "<article>\n".$htmlArticle."\n</article>\n";
	$fArticulo = fopen($fAbsoluteHtml, 'w');
	fwrite($fArticulo, $tmplHeader);
	fwrite($fArticulo, $articulo);
	fwrite($fArticulo, $tmplFoot);
	fclose($fArticulo);
