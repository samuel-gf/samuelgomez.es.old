<html>
	<head>
		<title>Listado de artículos</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="css/reset.css">
		<link rel="stylesheet" type="text/css" href="css/general.css">
        <!--<script type="text/javascript" src="js/Parsedown.js"></script>-->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-MML-AM_CHTML' async></script>
        <?php
            require(__DIR__."/const.php");
            require(__DIR__."/lib/libGeneral.php");
            require(__DIR__."/lib/libSql.php");
            conectaDB();
         ?>
	</head>
	<body>
        <aside>
            <section>
                <h1 class="logoP">
                    <span class="logoSil1">Genio</span>
                    <span class="logoSil2">Del</span>
                    <span class="logoSil3">Mal</span>
                    <span class="logoExt">.es</span>
                </h1>
            </section>
            <!--
            <section>
                <strong>Contenidos</strong>
            <nav>
                <ul>
                    <li>Matemáticas</li>
                </ul>
            </nav>
            </section>
        -->
            <section>
                <strong>Sobre mí</strong> Soy padre, ingeniero, padre y motero. Escribí este
                blog porque creo que puedo aportar algo interesante
            </section>
        </aside>
		<main>
            <?php
                $arrArticulos = getArrArticulos();
                foreach ($arrArticulos as $kArticulo => $vArticulo) {
                    echo '<article>';
                    echo '<header><h1>'.$vArticulo['título'].'<h1>';
                    echo '<p><time pubdate="'.getFechaFromSQL($vArticulo['timeStamp'],'d/m/Y').'">'.getFechaFromSQL($vArticulo['timeStamp'],'d/m/Y').'</time></p></header>';
                    echo '<p>'.$vArticulo['cuerpo'].'</p>';
                    echo '</article>';
                }
            ?>
            $$x = {-b \pm \sqrt{b^2-4ac} \over 2a}$$

        </main>
    </body>
</html>
