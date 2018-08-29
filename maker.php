<?php
    require(__DIR__."/const.php");
    require(__DIR__."/lib/libGeneral.php");
    require(__DIR__."/lib/libSql.php");
    conectaDB();

	$forceAll = true;

    $arrArticulos = getArrArticulos(10, 'DESC');
    $tmplHeader = file_get_contents(TEMPLATES.'/header.php');
    $tmplArticle = file_get_contents(TEMPLATES.'/article.php');
    $tmplFoot = file_get_contents(TEMPLATES.'/foot.php');
    $portadaArticulos = ''; // Artículos que van en portada
    $nArticulos = 0;
    $nArticulosReescritos = 0;

    echo "Maker\n";

    foreach ($arrArticulos as $kArticulo => $vArticulo) {
        $year = $strDate = getFechaFromSQL($vArticulo['firstTS'],'Y');
        $strDate = getFechaFromSQL($vArticulo['firstTS'],'Y-m-d');
        $strName = strToUrl($vArticulo['título']);
        $fArticuloName = ARTICLES.'/'.$year.'/'.$strName.'.html';
        $fRelArticuloName = '/articles/'.$year.'/'.$strName.'.html';
		$strPrimeraFechaPublicacion = getFechaFromSQL($vArticulo['firstTS'], 'd/m/Y H:m');
		$strInfo = file_get_contents(TEMPLATES.'/info.php');
		$strMenu = file_get_contents(TEMPLATES.'/menu.php');

        // Si el archivo existe pero es anterior a la útlima fecha de modificación bórralo
        if(file_exists($fArticuloName) || $forceAll){
            $tsEnHtml = filemtime($fArticuloName);
            $tsEnBDD = strtotime($vArticulo['lastTS']);
            if ($tsEnHtml < $tsEnBDD){
                unlink($fArticuloName);
                echo "[$strName] Borrado por obsoleto\n";
            } else if ($forceAll) {
				echo "[$strName] Borrado forzado\n";
			} else {
                echo "[$strName] Ok. No modificado\n";
            }
        }
		// Sustituye los valores del TEMPLATE del fichero HEADER
		$tmplHeader = str_replace('{{INFO}}', $strInfo, $tmplHeader);
		$tmplHeader = str_replace('{{MENU}}', $strMenu, $tmplHeader);

		// Sustituye los valores del TEMPLATE del fichero ARTICULO
		$tmplArticle = str_replace('{{TÍTULO DEL ARTÍCULO}}',$vArticulo['título'],$tmplArticle);
        $tmplArticle = str_replace('{{HLINK DEL ARTÍCULO}}',$fRelArticuloName,$tmplArticle);
        $tmplArticle = str_replace('{{PRIMERA FECHA PUBLICACIÓN}}',$strPrimeraFechaPublicacion,$tmplArticle);
        $tmplArticle = str_replace('{{ÚLTIMA FECHA PUBLICACIÓN}}',$vArticulo['lastTS'],$tmplArticle);
        $tmplArticle = str_replace('{{CUERPO}}',$vArticulo['cuerpo'],$tmplArticle);


        if(!file_exists($fArticuloName) || $forceAll){   // Si no existe el archivo es posible que sea necesario crear un directorio para albergarlo
            !file_exists(ARTICLES.'/'.$year)?mkdir(ARTICLES.'/'.$year):NULL;    // Si no existe el directorio lo crea
            $fArticulo = fopen($fArticuloName, "w");
            $tmplHeaderForThis = str_replace('{{TÍTULO PÁGINA}}',$vArticulo['título'],$tmplHeader);
            fwrite($fArticulo, $tmplHeaderForThis);

            fwrite($fArticulo, $tmplArticle);

            fwrite($fArticulo, $tmplFoot);
            fclose($fArticulo);
            $nArticulosReescritos++;
            echo "[$strName] Creado\n";
        }
        if ($nArticulos <= MAX_EN_PORTADA){
            $portadaArticulos .= $tmplArticle;
        }
        $nArticulos++;
    }

    // Genera la portada
    if ($nArticulosReescritos>-1){
        file_exists(ROOT.'/index.html')?unlink(ROOT.'/index.html'):NULL;
        $fPortada = fopen(ROOT.'/index.html', "w");
        $tmplHeaderForThis = str_replace('{{TÍTULO PÁGINA}}', 'Samuel Gómez. Portada', $tmplHeader);
        fwrite($fPortada, $tmplHeaderForThis);
        fwrite($fPortada, $portadaArticulos);
        fwrite($fPortada, $tmplFoot);
        fclose($fPortada);
        echo "[index.html] Reescrito\n";
    } else {
        echo "[index.html] Ok. Estaba actualizado\n";
    }
