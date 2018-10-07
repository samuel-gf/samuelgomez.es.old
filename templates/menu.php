<?php
	//require("../const.php");
	//require(LIB."/libGeneral.php");
	//getMenu("../src");

	function getMenu($root){
		$ret = '';
		$arrAllDirs = getDirectorios($root);
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
		return $ret;
	}
