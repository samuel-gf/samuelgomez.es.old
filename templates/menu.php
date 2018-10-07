<?php
	//require("../const.php");
	//require(LIB."/libGeneral.php");
	//getMenu("../src");

	function getMenu($root){
		$ret = '';
		$iter = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::SELF_FIRST,
			RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
		);

		$arrAllDirs = array();

		foreach ($iter as $path => $vFile) {
		    if ($vFile->isDir()) {
		        array_push($arrAllDirs, str_replace($root.'/', '', $path));
		    }
		}
		$ret .= "\t<ul>\n";

		$subnivel = 0;
		foreach ($arrAllDirs as $k => $vDir) {
			if (dirname($vDir) == '.'){	// Es un primer nivel
				$subnivel = 0;
				$ret .= "\t\t<li class='primerNivel'><a href='#'>".mb_ucfirst($vDir)."</a></li>\n";
			} else {	// Es un nivel inferior
				$subnivel++;
				$ret .= "\t\t<li class='segundoNivel'><a href='#'>".mb_ucfirst(str_replace(dirname($vDir).'/','',$vDir))."</a></li>\n";
			}

		}
		$ret .= "\t</ul>\n";
		echo $ret."*";
		return $ret;
	}
