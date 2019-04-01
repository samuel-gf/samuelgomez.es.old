<?php
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
	$menu.= getMenu(SRC).'</nav>';

	# Escribe el menu en el disco
	$fMenu = fopen(HTML.'/menu.html', 'w');
	fwrite($fMenu, $tmplHeader);
	fwrite($fMenu, $menu);
	fwrite($fMenu, $tmplFoot);
	fclose($fMenu);
