<html>
	<head>
		<title>Pasar lista</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="css/reset.css">
		<link rel="stylesheet" type="text/css" href="css/grupoGeneral.css">
		<link rel="apple-touch-icon" sizes="76x76" href="img/appIcon/icon.76.png">
		<link rel="apple-touch-icon" sizes="120x120" href="img/appIcon/icon.120.png">
		<link rel="apple-touch-icon" sizes="152x152" href="img/appIcon/icon.152.png">
		<link rel="apple-touch-startup-image" href="img/appIcon/icon.152.png">

		<script src="js/jquery.js"></script>
	</head>
	<body>
		<div id="frame">
			<div id="main">
					<h1>Listado de grupos</h1>

					<?php
						require(__DIR__."/const.php");
						require(__DIR__."/lib/libGeneral.php");
						require(__DIR__."/lib/libSql.php");
						$db = conectaDB();
						getPassByType(2) or die("Permiso denegado");

						$handle = fopen("data/gruposLista.txt", "r") or die("Unable to open file!");
						$n = 1;
						if ($handle) {
							while (($line = fgets($handle)) !== false) {
								$arrGrupo = explode(":",$line);

								if ($n % 2 == 1){
									if ($arrGrupo[0] == "_"){	// Es un espacio. Un espacio vacío
										echo '<div class="listaCursosColLeft listaCursoUn">&nbsp;</div>';
									} else {	// Es un grupo de verdad
										echo '<div class="listaCursosColLeft"><a class="listaCursoUn" href="grupo.php?grupoId='.$arrGrupo[1].'">'.$arrGrupo[0].'</a></div>';
									}
								} else {
									if ($arrGrupo[0] == "_"){	// Es un espacio. Un espacio vacío
										echo '<div class="listaCursosColright listaCursoUn">&nbsp;</div>';
									} else {	// Es un grupo de verdad
										echo '<div class="listaCursosColright"><a class="listaCursoUn" href="grupo.php?grupoId='.$arrGrupo[1].'">'.$arrGrupo[0].'</a></div>';
									}
								}
								$n++;
					    	}
						}
						fclose($handle);
						$db->close();

						echo '<div class="listaCursosColLeft"><a class="listaCursoUn" href="estadisticas.php">Estadísticas</a></div>';
						echo '<div class="listaCursosColRight"><a class="listaCursoUn" href="gestionAlumnos.php">Gestión alumnos</a></div>';

					?>
			<div><!-- main -->
				&nbsp;
		</div><!-- frame -->
	</body>
</html>
