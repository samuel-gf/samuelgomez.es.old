<?php
	# makeArticle 1.0
    require("const.php");
    require("libGeneral.php");
	
	# Recibe como parámetro la ruta relativa del .html a construir
  	$fRelativeHtml = $argv[1];
  	$fAbsoluteHtml = ROOT.'/'.$fRelativeHtml;	// Ruta absoluta + archivo .html
	$fAbsoluteMd = getFullFileNameMdFromHtml($fRelativeHtml);  // Ruta absoluta + archivo .md
  	$numDir = substr_count($fRelativeHtml, '/')-1;	// Cuantos directorios de profundidad tiene el directorio destino

	# Lee el contenido de las plantillas
	$tmplHeader = file_get_contents(TEMPLATES.'/header.php');
	$tmplArticle = file_get_contents($fAbsoluteMd);
	$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');
	$tmplInfo = file_get_contents(TEMPLATES.'/info.php');

  	# PLANTILLA ARTÍCULO .md
	$title = getTitleFromMd($tmplArticle); 

	# Obtiene las etiquetas o keywords
	$arrTags = array();
	preg_match_all('/[^(]#([^\s#]+)/', $tmplArticle, $arrTags);
	$sTags = rtrim(implode(', ', $arrTags[1]), ', ');	// List separated commas of tags

  	# Obtiene la fecha de creación del artículo a partir del nombre del .md  
	$arrFecha_tmp = explode('-',basename($fAbsoluteMd));
	$tsFileMd = false;
	if (count($arrFecha_tmp)>=3){
		$fechaCreacion = $arrFecha_tmp[0].'-'.$arrFecha_tmp[1].'-'.$arrFecha_tmp[2];
		$tsFileMd = strtotime($fechaCreacion);
	}	
	if (!$tsFileMd)	{	// If file_name.md does not contain a date
		$tsFileMd = strtotime("now");
	}
	$dateOfFileShort = date('d/m/Y H:i',$tsFileMd);
	setlocale(LC_ALL, 'es_ES.UTF-8');
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
	$tmplHeader = str_replace('{{INFO}}',$tmplInfo,$tmplHeader);
	$tmplHeader = str_replace('{{MENU}}','<a id="nav-toggle" href="'.str_repeat('../',$numDir).'menu.html">&#9776;</a>',$tmplHeader);
	$tmplHeader = str_replace('{{BASE_DIR}}',str_repeat('../',$numDir),$tmplHeader);

	# Reemplaza campos en la plantilla foot
	$tmplFoot = str_replace('{{BASE_DIR}}',str_repeat('../',$numDir),$tmplFoot);
	$tmplFoot = str_replace('{{HTML_NAME}}',$fRelativeHtml,$tmplFoot);

	# Remplaza campos en el fichero final
	$htmlArticle = file_get_contents($fAbsoluteHtml);
	$htmlArticle = preg_replace("/[0-9]{4}\-[0-9]{2}\-[0-9]{2}(?!\-)/s","<time datetime='$fechaCreacion' pubdate='$fechaCreacion'>$dateOfFileLong</time>", $htmlArticle);	// Pone a la fecha las etiquetas <time></time>
	$htmlArticle = str_replace('%7B%7BBASE_IMG%7D%7D',str_repeat('../',$numDir).'img/',$htmlArticle); // remplaza {{BASE_IMG}}

	# Combina los tres ficheros header, article y foot
	$articulo = "<article>\n".$htmlArticle."\n</article>\n";
	$fArticulo = fopen($fAbsoluteHtml, 'w');
	fwrite($fArticulo, $tmplHeader);
	fwrite($fArticulo, $articulo);
	fwrite($fArticulo, $tmplFoot);
	fclose($fArticulo);
