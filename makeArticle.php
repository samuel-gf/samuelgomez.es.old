<?php
    require("const.php");
    require(LIB."/libGeneral.php");

	// Lee el contenido de las plantillas
	$tmplHeader = file_get_contents(TEMPLATES.'/header.php');
	$fileDestNameCompleto = ROOT.'/'.$argv[1];	// Archivo a construir con ruta completa
	$dirDestino = dirname($fileDestNameCompleto);
	$fileNameMd = str_replace('.html', SRC_EXT, $argv[1]);
	$fileNameMd = str_replace('html/', SRC.'/', $fileNameMd);
	$tmplArticle = file_get_contents($fileNameMd);
	preg_match("/#(.*)/s",$tmplArticle, $arrMatch);	// Coge todo el contenido menos los metadatos del .md
	$tmplArticle = $arrMatch[0];
	$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');
	$info = file_get_contents(TEMPLATES.'/info.php');
	$menu = getMenu(SRC);
	$dateOfFile = date('d/m/Y H:i',filemtime ($fileNameMd));
	//$now = date('d/m/Y H:i');
	$now = strftime('%e de %B de %G a las %H:%M');

	// Obtiene el título del artículo extrayendolo del texto del .md mirando lo que viene después de #
	$title = getTitleFromMd($tmplArticle);
	$numDirectorios = substr_count($argv[1], '/')-1;	// Cuantos directorios de profundidad tiene el directorio destino

	// Modifica el fichero .md con los datos de la plantilla
	$tmplArticle = "---\ntitle: $title\nauthor: ".AUTOR."\ndate: $now\n---\n\n".$tmplArticle;
	$fArticulo = fopen($fileNameMd, 'w');
	fwrite($fArticulo, $tmplArticle);
	fclose($fArticulo);

	// pandoc .md -> .html
	!file_exists($dirDestino)?mkdir($dirDestino):NULL;
	$command = "pandoc $fileNameMd -f markdown+tex_math_dollars --mathml -o $fileDestNameCompleto";
	shell_exec($command);

	// Remplaza campos en la plantilla header
	$tmplHeader = str_replace('{{TÍTULO PÁGINA}}',$title,$tmplHeader);
	$tmplHeader = str_replace('{{INFO}}',$info,$tmplHeader);
	$tmplHeader = str_replace('{{MENU}}',$menu,$tmplHeader);
	$tmplHeader = str_replace('{{BASE_DIR}}',str_repeat('../',$numDirectorios),$tmplHeader);

	// Lee el .html generado y le agrega cabecera y pie
	$articulo = "<article>\n".file_get_contents($fileDestNameCompleto)."\n</article>\n";
	$articulo = preg_replace('/<\/h1>/',"<p><time datetime=$now pubdate=$now>$now</time></p></h1>", $articulo);
	$fArticulo = fopen($fileDestNameCompleto, 'w');
	fwrite($fArticulo, $tmplHeader);
	fwrite($fArticulo, $articulo);
	fwrite($fArticulo, $tmplFoot);
	fclose($fArticulo);
