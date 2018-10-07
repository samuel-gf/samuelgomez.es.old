<?php
    function getHoy(){
        date_default_timezone_set('Europe/Madrid');
        return date("Y-m-d");
    }

	/* Retorna una URL amigable a partir de un string */
    function strToUrl($str){
        $str = mb_strtolower(trim($str));
        $str = str_replace(array('á','é', 'í', 'ó', 'ú', 'ñ', '¿', ' '),
                              array('a', 'e', 'i', 'o', 'u', 'n', '?', '-'), $str);
        return $str;
    }

	/* Devuelve un array con todos los ficheros .phtml y cierta información en forma de array */
	function getArrFiles($root, $ext){
		clearstatcache();
		$arrFilesBuscados = array();
		$arrAllDirs = getDirectorios($root, $rutaCompleta=true);
		$arrAllDirs = array_merge(array($root), $arrAllDirs);
		//print_r($arrAllDirs);	die();
		foreach ($arrAllDirs as $kDir => $vDir) {
			//echo "Entro en $vDir\n";
			$arrFiles = scandir($vDir);
			foreach ($arrFiles as $kFile => $vFile) {
				//echo "\t$vFile";
				if ($vFile != '.' && $vFile != '..' && pathinfo($vFile, PATHINFO_EXTENSION) == $ext){
					//echo "*";
					array_push($arrFilesBuscados, array(
						'nombre' => str_replace($root, '', $vDir).'/'.$vFile,
						'título' => getTitleFromText(file_get_contents($vDir.'/'.$vFile)),
						'nombreCompleto' => $vDir.'/'.$vFile,
						'uModificacion' => filemtime($vDir.'/'.$vFile)));
				}
				//echo "\n";
			}
		}
		//die();
		return $arrFilesBuscados;
	}

	// Obtiene el título del artículo extrayendolo del texto
	function getTitleFromText($text){
		$r = preg_match("/<h1>[\r\n]*(.*)/", $text, $arrTitle);
		$title = trim($arrTitle[1]);
		return $title;
	}



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

	// La primera letra en mayúsula para cadenas unicode
	function mb_ucfirst($string, $encoding='utf8'){
	    $strlen = mb_strlen($string, $encoding);
	    $firstChar = mb_substr($string, 0, 1, $encoding);
	    $then = mb_substr($string, 1, $strlen - 1, $encoding);
	    return mb_strtoupper($firstChar, $encoding) . $then;
	}


	// Devuelve un array con todos los directorios y subdirectorios que dependen de $root
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


    // Corta la cadena y rellena con espacios u otro
    function width($str, $nChars, $fill = ' '){
        return mb_str_pad(mb_substr($str,0,$nChars),$nChars,$fill,STR_PAD_RIGHT, $encoding='utf-8');
    }

    function rDebug(&$arr){
        echo '<div class="preformatted">';
        print_r($arr);
        echo '</div>';
    }
?>
