<?php
	# makeMenu.php 1.0
    require("const.php");
    require("libGeneral.php");
	require("templates/categorias.php");

	# Lee el contenido de la cabecera
	$tmplHeader = file_get_contents(TEMPLATES.'/header.php');
	$info = file_get_contents(TEMPLATES.'/info.php');
	$tmplHeader = str_replace('{{TÍTULO PÁGINA}}','Categoría. '.AUTOR,$tmplHeader);
	$tmplHeader = str_replace('{{BASE_DIR}}','',$tmplHeader);
	$tmplHeader = str_replace('{{INFO}}',$info,$tmplHeader);
	$tmplHeader = str_replace('{{MENU}}','',$tmplHeader);

	# Lee el contenido del pie
	$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');
	$tmplFoot = str_replace('{{BASE_DIR}}','',$tmplFoot);
	$tmplFoot = str_replace('{{HTML_NAME}}','/index.html',$tmplFoot);

	$menu = '<section id="info">'.$info.'</section>'."\n";
	$menu.= "<nav>\n";
	$menu.= "<ul>\n";
	$menu.= '<li><a href="contacto.html">Contacto</a></li><hr/>'."\n";
	$menu.= "</ul>\n";
	$arrMenu = getToc(NO_HTML_FILES);	// Es un array con los directorios de HTML que no contienen archivos .html como js,img,css
	foreach ($arrMenu as $fItem){
		$level = $fItem['level'];
		if ($fItem['is_dir']){
			$menu.= '<li class="menulevel'.$fItem['level'].'">';
			$menu.= mb_strtoupper(no_hyphen($fItem['name'])).'</li>'."\n";
		} else {
			$menu.= '<li class="menulevel'.$fItem['level'].'">';
			$menu.= '<a href="'.$fItem['fAbsoluteHtml'].'">'.$fItem['name'].'</a></li>'."\n";
			}
	}

	$menu.= '</nav>';

	# Escribe el menu en el disco
	$fMenu = fopen(HTML.'/menu.html', 'w');
	fwrite($fMenu, $tmplHeader);
	fwrite($fMenu, $menu);
	fwrite($fMenu, $tmplFoot);
	fclose($fMenu);
