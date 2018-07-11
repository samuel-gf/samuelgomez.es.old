<?php
    require(__DIR__."/const.php");
    require(__DIR__."/lib/libGeneral.php");
    require(__DIR__."/lib/libSql.php");
    conectaDB();

    $arrArticulos = getArrArticulos();
    $tmplHeader = file_get_contents(TEMPLATES.'/header.php');
    $tmplArticle = file_get_contents(TEMPLATES.'/article.php');
    $tmplFoot = file_get_contents(TEMPLATES.'/foot.php');
    $portadaArticulos = ''; // Artículos que van en portada
    $nArticulos = 0;
    $nArticulosReescritos = 0;

    echo "Maker<br><hr><br>";

    foreach ($arrArticulos as $kArticulo => $vArticulo) {
        $year = $strDate = getFechaFromSQL($vArticulo['firstTS'],'Y');
        $strDate = getFechaFromSQL($vArticulo['firstTS'],'Y-m-d');
        $strName = strToUrl($vArticulo['título']);
        $fArticuloName = ARTICLES.'/'.$year.'/'.$strName.'.html';

        // Si el archivo existe pero es anterior a la útlima fecha de modificación bórralo
        if(file_exists($fArticuloName)){
            $tsEnHtml = filemtime($fArticuloName);
            $tsEnBDD = strtotime($vArticulo['lastTS']);
            if ($tsEnHtml < $tsEnBDD){
                unlink($fArticuloName);
                echo "[$strName] Borrado por obsoleto<br>";
            } else {
                echo "[$strName] Ok. No modificado<br>";
            }
        }

        $tmplThisArticle = str_replace('{{TÍTULO DEL ARTÍCULO}}',$vArticulo['título'],$tmplArticle);
        $tmplThisArticle = str_replace('{{PRIMERA FECHA PUBLICACIÓN}}',$vArticulo['firstTS'],$tmplThisArticle);
        $tmplThisArticle = str_replace('{{ÚLTIMA FECHA PUBLICACIÓN}}',$vArticulo['lastTS'],$tmplThisArticle);
        $tmplThisArticle = str_replace('{{CUERPO}}',$vArticulo['cuerpo'],$tmplThisArticle);

        if(!file_exists($fArticuloName)){   // Si no existe el archivo
            !file_exists(ARTICLES.'/'.$year)?mkdir(ARTICLES.'/'.$year):NULL;    // Si no existe el directorio lo crea
            $fArticulo = fopen($fArticuloName, "w");
            $tmplHeaderForThis = str_replace('{{TÍTULO PÁGINA}}',$vArticulo['título'],$tmplHeader);
            fwrite($fArticulo, $tmplHeaderForThis);

            fwrite($fArticulo, $tmplThisArticle);

            fwrite($fArticulo, $tmplFoot);
            fclose($fArticulo);
            $nArticulosReescritos++;
            echo "[$strName] Creado<br>";
        }
        if ($nArticulos <= MAX_EN_PORTADA){
            $portadaArticulos .= $tmplThisArticle;
        }
        $nArticulos++;
    }

    // Genera la portada
    if ($nArticulosReescritos>-1){
        file_exists(ROOT.'/index.html')?unlink(ROOT.'/index.html'):NULL;
        $fPortada = fopen(ROOT.'/index.html', "w");
        $tmplHeaderForThis = str_replace('{{TÍTULO PÁGINA}}', 'Genio del mal. Portada', $tmplHeader);
        fwrite($fPortada, $tmplHeaderForThis);
        fwrite($fPortada, $portadaArticulos);
        fwrite($fPortada, $tmplFoot);
        fclose($fPortada);
        echo "[index.html] Reescrito<br>";
    } else {
        echo "[index.html] Ok. Estaba actualizado<br>";
    }
