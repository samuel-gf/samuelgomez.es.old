<?php
	# Obtiene fecha formateada
    function getHoy(){
        date_default_timezone_set('Europe/Madrid');
        return date("Y-m-d");
	}

	# Retorna una URL amigable a partir de un string 
    function strToUrl($str){
        $str = mb_strtolower(trim($str));
        $str = str_replace(array(   'á', 'é', 'í', 'ó', 'ú', 'ñ', '¿', '?', ' ', ':'),
                              array('a', 'e', 'i', 'o', 'u', 'n', '', ''  , '-', '-'), $str);
        return $str;
	}

	# Esta lista permite transformar una palabra sin tilde a otra con tilde
	function conTilde($sinTilde){
		global $arrPalabrasClave;
		return array_key_exists($sinTilde, $arrPalabrasClave)?$arrPalabrasClave[$sinTilde]:$sinTilde;
	}

	# Transform an hyphen separated words to well writen
	function no_hyphen($s){
		$ret = '';
		$arrWords = explode('-',$s);
		foreach($arrWords as $word){
			$ret .= ' '.conTilde(mb_strtolower($word));
		}		
		return ltrim($ret);
	}

	# Transforma una ruta absoluta en relativa
	function getRelativeFromAbsolutePath($fAbsolutePath){
		return str_replace(HTML.'/', '', $fAbsolutePath);
	}

	# Devuelve un array con todos los ficheros de la extensión $ext y cierta información en forma de array 
	# No devuelve ficheros index.html
	function getArrFiles($root, $ext, $includeRoot=false){
		clearstatcache();
		$arrFilesBuscados = array();
		$arrAllDirs = getDirectorios($root, $rutaCompleta=true);
		if ($includeRoot){
			array_unshift($arrAllDirs, $root);
		}
		//print_r($arrAllDirs);	die();
		foreach ($arrAllDirs as $kDir => $vDir) {
			//echo "Entro en $vDir\n";
			$arrFiles = scandir($vDir);
			foreach ($arrFiles as $kFile => $vFile) {
				//echo "\t$vFile\n";
				if ($vFile != '.' && $vFile != '..' && pathinfo($vFile, PATHINFO_EXTENSION) == $ext){
					$arrFileName = (explode('-', basename($vFile)));
					// Si el fichero a procesar no tiene una fecha en su nombre no puedo coger la fecha
					$fechaCreacion = "";
					if (is_numeric(substr(basename($vFile), 0, 1))){
						$fechaCreacion = $arrFileName[0].'-'.$arrFileName[1].'-'.$arrFileName[2];
					}
					array_push($arrFilesBuscados, array(
						'ficheroRutaRelativa' => str_replace($root, '', $vDir).'/'.$vFile,
						'ficheroRutaAbsoluta' => $vDir.'/'.$vFile,
						'uModificacion' => filemtime($vDir.'/'.$vFile),
						'fechaCreación' => $fechaCreacion
					));
				}
				//echo "\n";
			}
		}
		return $arrFilesBuscados;
	}

    # Obtiene el título del artículo extrayendolo del contenido .html
	function getTitleFromHtml($htmlContent){
		$r = preg_match("/<title>(.*)<\/title>/", $htmlContent, $arrTitle);
		$title = trim($arrTitle[1]);
		return $title;
	}

	# Obtiene el título de un artículo extrayendolo del contenido .md
	function getTitleFromMd($mdContent){
		$r = preg_match("/# *(.*)/", $mdContent, $arrData);
		$data = trim($arrData[1]);
		return $data;
	}
	
  # Return array with information about the first image used in the article
  # 	[0] full search
  # 	[1] URL of the image
  # 	[2] ALT of the image
  function getImageFromHtml($htmlContent){
		$r = preg_match('/<img src="(.*)" alt="(.*)"/', $htmlContent, $arrFound);
		return $arrFound;
  }

  function getFirstsParagraphs($htmlContent, $nParagraph){
		$r = preg_match_all('/<p>([^<].*)<\/p>/', $htmlContent, $arrFound);
		$text = '';
		for($i=0; $i<count($arrFound[1]) && $i<$nParagraph; $i++){
			$text.= '<p>'.$arrFound[1][$i].'</p>';
		}
		return $text;
  }

  # Dado un fichero html reemplaza su extensión .html por .md
  # y le añade la ruta absoluta y la devuelve
  function getFullFileNameMdFromHtml($htmlFile){
    $fAbsoluteMd = str_replace('.html', SRC_EXT, $htmlFile);
	  $fAbsoluteMd = str_replace('html/', SRC.'/', $fAbsoluteMd);
    return $fAbsoluteMd; // Ruta absoluta + archivo .md
  }


	# A partir del nombre completo de un fichero obtiene metainformación 
	function getArrInfoFromHtmlFile($vHtmlFullName){
		$contenidoHtml = file_get_contents($vHtmlFullName);
		$arrFileName = explode('.',basename($vHtmlFullName));
		$arrRet = array(
			'título' => getTitleFromHtml($contenidoHtml),
			'ficheroRutaRelativa' => str_replace(ROOT, '', dirname($vHtmlFullName)).'/'.$vHtmlFullName,
			'ficheroRutaAbsoluta' => $vHtmlFullName,
			'uModificacion' => filemtime($vHtmlFullName),
			'fechaCreación' => $arrFileName[0]		// Desde el nombre del fichero
		);
		return $arrRet;
	}

  # Obtiene el contenido de un fichero .md al que elimina previamete los metadatos
  function getContentWithoutMetadata($tmplContentMd){
    preg_match("/#(.*)/s",$tmplContentMd, $arrMatch);	// Coge el contenido sin el bloque de metadatos del .md
    $tmplArticle = trim($arrMatch[0]);
    return $tmplArticle;
  }

  # Obtiene el TOC (Table Of Content), para ello, se mueve directorio por directorio mirando los archivos que 
  # tiene a su alcance y en caso de encontrar un directorio, llama a la función getFilesInDirectory que 
  # a su vez se llamará a sí misma de manera recursiva hasta cubrir todos los archivos .html
  # La función getToc evita entrar por una lista de directorios prohibidos que recibe por parámetro en forma de cadena
  $arrFileTree = array();	/* Variable global para las dos siguientes funciones */
  function getToc($sForbiddenDir){
	global $arrFileTree;
	$arrForbiddenDir = explode(',',$sForbiddenDir);
	# Estudio los directorios de primer nivel que cuelgan de HTML
	foreach(glob(HTML."/*") as $filename){
		if (is_dir($filename) && !in_array(basename($filename),$arrForbiddenDir)){
				array_push($arrFileTree, array('name'=>basename($filename),
						'fAbsoluteHtml'=>$filename.'/index.html',
						'fRelativeHtml'=>getRelativeFromAbsolutePath($filename).'/index.html',
						'is_dir'=>true,
						'level'=>0));
			getFilesInDirectory($filename, 0);
		} 
	}
	return $arrFileTree;
  }

  # Estudio los archivos .html que cuelgan en un segundo y posteriores niveles y los almaceno
  # en $arrFileTree que es un archivo global. Esta función trabaja junto con getToc
  function getFilesInDirectory($absDir, $dirLevel){
	  global $arrFileTree;
	  	# Estudio los archivos *.html
	    $dirLevel++;
		foreach(glob("$absDir/*.html") as $fAbsoluteHtml){
			$basename = basename($fAbsoluteHtml);
			if ($basename != "index.html"){
				array_push($arrFileTree, array('name'=>getTitleFromHtml(file_get_contents($fAbsoluteHtml)),
						'fAbsoluteHtml'=>$fAbsoluteHtml,
						'fRelativeHtml'=>getRelativeFromAbsolutePath($fAbsoluteHtml),
						'is_dir'=>false,
						'level'=>$dirLevel));
			}
		}
		# Estudio los directorios
		foreach(glob("$absDir/*") as $filename){
			if (is_dir($filename)){
				array_push($arrFileTree, array('name'=>basename($filename),
						'fAbsoluteHtml'=>$filename.'/index.html',
						'fRelativeHtml'=>getRelativeFromAbsolutePath($filename).'/index.html',
						'is_dir'=>true,
						'level'=>$dirLevel));
				getFilesInDirectory($filename, $dirLevel);
			}
		}
	}
		
	# 
    function mb_str_pad($str, $pad_len, $pad_str = ' ', $dir = STR_PAD_RIGHT, $encoding = NULL){
        $encoding = $encoding === NULL ? mb_internal_encoding() : $encoding;
        $padBefore = $dir === STR_PAD_BOTH || $dir === STR_PAD_LEFT;
        $padAfter = $dir === STR_PAD_BOTH || $dir === STR_PAD_RIGHT;
        $pad_len -= mb_strlen($str, $encoding);
        $targetLen = $padBefore && $padAfter ? $pad_len / 2 : $pad_len;
        $strToRepeatLen = mb_strlen($pad_str, $encoding);
        $repeatTimes = ceil($targetLen / $strToRepeatLen);
        $repeatedString = str_repeat($pad_str, max(0, $repeatTimes)); // safe if used with valid utf-8 strings
        $before = $padBefore ? mb_substr($repeatedString, 0, floor($targetLen), $encoding) : '';
        $after = $padAfter ? mb_substr($repeatedString, 0, ceil($targetLen), $encoding) : '';
        return $before . $str . $after;
    }
	
	# La primera letra en mayúsula para cadenas unicode
	function mb_ucfirst($string, $encoding='utf8'){
	    $strlen = mb_strlen($string, $encoding);
	    $firstChar = mb_substr($string, 0, 1, $encoding);
	    $then = mb_substr($string, 1, $strlen - 1, $encoding);
	    return mb_strtoupper($firstChar, $encoding) . $then;
	}
	
	# Devuelve un array con todos los directorios y subdirectorios que dependen de $root
	# por defecto con ruta relativa
	function getDirectorios($root, $rutaCompleta=false){
		$ret = '';
		$iter = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::SELF_FIRST,
			RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
		);
		$arrAllDirs = array();
		foreach ($iter as $path => $vFile) {
		    if ($vFile->isDir()) {
				if ($rutaCompleta){
					array_push($arrAllDirs, $path);
				} else {
		        	array_push($arrAllDirs, str_replace($root.'/', '', $path));
				}
		    }
		}
		return $arrAllDirs;
	}
	
	# Corta la cadena y rellena con espacios u otro
    function width($str, $nChars, $fill = ' '){
        return mb_str_pad(mb_substr($str,0,$nChars),$nChars,$fill,STR_PAD_RIGHT, $encoding='utf-8');
    }

	# Muestra información sobre un array. Usada para depurar
    function rDebug(&$arr){
        echo '<div class="preformatted">';
        print_r($arr);
        echo '</div>';
    }
?>
