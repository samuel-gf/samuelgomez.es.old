<?php
    require("const.php");
    require("libGeneral.php");

	// Lee el contenido de las plantillas
	$tmplHeader = file_get_contents(TEMPLATES.'/header.php');
	// Remplaza campos en la plantilla header
	$tmplHeader = str_replace('{{TÍTULO PÁGINA}}','Contacto',$tmplHeader);
	$info = file_get_contents(TEMPLATES.'/info.php');
	$tmplHeader = str_replace('{{INFO}}',$info,$tmplHeader);
	$tmplHeader = str_replace('{{MENU}}', '<a id="nav-toggle" href="./menu.html">&#9776;</a>',$tmplHeader); //@TODO
	$tmplHeader = str_replace('{{BASE_DIR}}','',$tmplHeader);
	$tmplFoot = file_get_contents(TEMPLATES.'/foot.php');
	$tmplContact = file_get_contents(PAGES.'/contact.php');


	// Escribe contacto.html en disco
	$fArticulo = fopen(HTML.'/contacto.html', 'w');
	fwrite($fArticulo, $tmplHeader);
	fwrite($fArticulo, $tmplContact);
	fwrite($fArticulo, $tmplFoot);
	fclose($fArticulo);
