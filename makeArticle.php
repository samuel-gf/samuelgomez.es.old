<?php
	# makeArticle 1.01
    require("const.php");
    require("libGeneral.php");
	setlocale(LC_ALL, 'es_ES.UTF-8');
	
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
	$sTags = implode(' ', array_unique($arrTags[0], SORT_LOCALE_STRING));

	# Obtiene metadata
	preg_match('/description:\s* (.*)/', $tmplArticle, $arrDescription);
	$description = array_key_exists(1, $arrDescription)?$arrDescription[1]:'';

  	# Obtiene la fecha de creación del artículo a partir del nombre del .md  
	$arrFecha_tmp = explode('-',basename($fAbsoluteMd));
	$tsFileMd = false;
	if (count($arrFecha_tmp)>=3){
		$tsFileMd = strtotime($arrFecha_tmp[0].'-'.$arrFecha_tmp[1].'-'.$arrFecha_tmp[2]);
	}	
	if (!$tsFileMd)	{	// If file_name.md does not contain a date
		$tsFileMd = strtotime("now");
	}
	$dateOfFileShort = date('d/m/Y H:i',$tsFileMd);
	$dateOfFileLong = strftime('%e de %B de %G', $tsFileMd);
	$dateOfFileName = strftime('%G-%m-%d', $tsFileMd);

  	# Cambia el nombre del archivo fuente .md acorde al título del artículo solo si ha cambiado
	$new_absolute_md = dirname($fAbsoluteMd).'/'.$dateOfFileName.'-'.strToUrl($title).'.md';
	$new_absolute_html = dirname($fAbsoluteHtml).'/'.$dateOfFileName.'-'.strToUrl($title).'.html';
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
	if (!empty($description)){
		$tmplHeader = str_replace('{{META_DESCRIPTION}}','<meta name="description" content="'.$description.'"/>', $tmplHeader);
	} else {
		$tmplHeader = str_replace('{{META_DESCRIPTION}}','', $tmplHeader);
	}
		
		# Reemplaza campos en la plantilla foot
	$tmplFoot = str_replace('{{BASE_DIR}}',str_repeat('../',$numDir),$tmplFoot);
	$tmplFoot = str_replace('{{HTML_NAME}}',$fRelativeHtml,$tmplFoot);

	# Remplaza campos en el fichero final article
	$htmlArticle = file_get_contents($fAbsoluteHtml);
	$htmlArticle = preg_replace("/[0-9]{4}\-[0-9]{2}\-[0-9]{2}(?!\-)/s","<time datetime='$dateOfFileName' pubdate='$dateOfFileName'>$dateOfFileLong</time>", $htmlArticle);	// Pone a la fecha las etiquetas <time></time>
	$htmlArticle = str_replace('%7B%7BBASE_IMG%7D%7D',str_repeat('../',$numDir).'img/',$htmlArticle); // remplaza {{BASE_IMG}}

	# Combina los tres ficheros header, article y foot
	$articulo = "<article>\n".$htmlArticle."\n</article>\n";
	$fArticulo = fopen($fAbsoluteHtml, 'w');
	fwrite($fArticulo, $tmplHeader);
	fwrite($fArticulo, $articulo);
	fwrite($fArticulo, $tmplFoot);
	fclose($fArticulo);
