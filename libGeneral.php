<?php
	# Obtiene fecha formateada
    function getHoy(){
        date_default_timezone_set('Europe/Madrid');
        return date("Y-m-d");
	}

	# Retorna una URL amigable a partir de un string 
    function strToUrl($str){
        $str = mb_strtolower(trim($str));
        $str = str_replace(array(   'á', 'é', 'í', 'ó', 'ú', 'ñ', '¿', ' '),
                              array('a', 'e', 'i', 'o', 'u', 'n', '', '-'), $str);
        return $str;
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
				//echo "\t$vFile";
				if (basename($vFile) != 'index.html'){
					if ($vFile != '.' && $vFile != '..' && pathinfo($vFile, PATHINFO_EXTENSION) == $ext){
						$arrFileName = (explode('-', basename($vFile)));
						echo basename($vFile)."\n";
						$fechaCreacion = $arrFileName[0].'-'.$arrFileName[1].'-'.$arrFileName[2];
						array_push($arrFilesBuscados, array(
							'ficheroRutaRelativa' => str_replace($root, '', $vDir).'/'.$vFile,
							'ficheroRutaAbsoluta' => $vDir.'/'.$vFile,
							'uModificacion' => filemtime($vDir.'/'.$vFile),
							'fechaCreación' => $fechaCreacion
						));
					}
				}
				//echo "\n";
			}
		}
		//die();
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
		$r = preg_match_all('/<p>(.*)<\/p>/', $htmlContent, $arrFound);
		$text = '';
		for($i=0; $i<sizeof($arrFound) && $i<$nParagraph; $i++){
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

	# https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Lists_and_Counters/Using_CSS_counters
	function getMenu($srcDir){
		global $arrCategoriasPalabras;
		$ret = '';
		$arrAllDirs = getDirectorios($srcDir);
		//rDebug($arrAllDirs);	die();
		sort($arrAllDirs);
		$actNumDirectorios = -1;
		foreach ($arrAllDirs as $k => $vDirRelativo) {	// Cada $vDirRelativo es una ruta
			$antNumDirectorios = $actNumDirectorios;
			$actNumDirectorios = substr_count($vDirRelativo, '/');
			$relNumDirectorios = $actNumDirectorios-$antNumDirectorios;	// Variación relativa

			$arrHtmlFiles = glob(HTML.'/'.$vDirRelativo.'/*.html');
			$nFicherosHtml = sizeof($arrHtmlFiles);

			$arrCategoriasDir = explode('/', $vDirRelativo);	// Cada elemento del array es un directorio (perteneciente a la ruta completa)
			$nombre_categoria = '';
			$arrCategoriaPalabras = explode('-', end($arrCategoriasDir));
			foreach ($arrCategoriaPalabras as $kPalabra => $vPalabra) {	// Cada palabra
				$nombre_categoria.=array_key_exists($vPalabra, $arrCategoriasPalabras)?$arrCategoriasPalabras[strtolower($vPalabra)]:$vPalabra;
				$nombre_categoria.=' ';
			}
			$nombre_categoria = rtrim($nombre_categoria, ' > ');
			//echo $vDirRelativo."($antNumDirectorios, $actNumDirectorios, $relNumDirectorios)\n";

			$tabulaciones = str_repeat("\t", $actNumDirectorios);
			if ($relNumDirectorios==1){	// Incrementa un direcotorio
				$ret .= str_repeat("$tabulaciones", $actNumDirectorios)."<ol>\n";
			}
			if ($relNumDirectorios==0){
				$ret .= str_repeat("\t", $antNumDirectorios)."</li>\n";
			}
			if ($relNumDirectorios==-1){
				$ret .= str_repeat("\t", $antNumDirectorios)."</li></ol>\n";
			}
			# Si es un directorio no vacío pon enlaces, en caso contrario una línea sin enlace
			if ($nFicherosHtml > 0){
				$ret.="$tabulaciones\t<li><a href='./$vDirRelativo/index.html'>".mb_ucfirst($nombre_categoria)."</a>\n";
			} else {
				$ret.="$tabulaciones\t<li>".mb_ucfirst($nombre_categoria)."\n";
			}
		}
		$ret .= "\t</li></ol>\n";
		//echo $ret; 
		return $ret;
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
