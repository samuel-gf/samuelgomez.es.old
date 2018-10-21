<!DOCTYPE html>
<head lang="es">
	<title>{{TÍTULO PÁGINA}}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="{{BASE_DIR}}css/reset.css">
	<link rel="stylesheet" type="text/css" href="{{BASE_DIR}}css/general.css">

	<link rel="icon" type="image/png" sizes="48x48"   href="{{BASE_DIR}}img/favicon.ico">
	<link rel="icon" type="image/png" sizes="96x96"   href="{{BASE_DIR}}img/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="196x196" href="{{BASE_DIR}}img/favicon-196x196.png">
	<link rel="apple-touch-icon" sizes="120x120" href="{{BASE_DIR}}img/favicon-120x120.png">
	<link rel="apple-touch-icon" sizes="180x180" href="{{BASE_DIR}}img/favicon-180x180.png">
	<link rel="apple-touch-icon" sizes="152x152" href="{{BASE_DIR}}img/favicon-152x152.png">
	<link rel="apple-touch-icon" sizes="167x167" href="{{BASE_DIR}}img/favicon-167x167.png">


	<script src='{{BASE_DIR}}js/jquery.js'></script>
	<script src='{{BASE_DIR}}js/general.js'></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.10.0-rc.1/dist/katex.min.css" integrity="sha384-D+9gmBxUQogRLqvARvNLmA9hS2x//eK1FhVb9PiU86gmcrBrJAQT8okdJ4LMp2uv" crossorigin="anonymous">
	<script defer src="https://cdn.jsdelivr.net/npm/katex@0.10.0-rc.1/dist/katex.min.js" integrity="sha384-483A6DwYfKeDa0Q52fJmxFXkcPCFfnXMoXblOkJ4JcA8zATN6Tm78UNL72AKk+0O" crossorigin="anonymous"></script>
	<script defer src="https://cdn.jsdelivr.net/npm/katex@0.10.0-rc.1/dist/contrib/auto-render.min.js" integrity="sha384-yACMu8JWxKzSp/C1YV86pzGiQ/l1YUfE8oPuahJQxzehAjEt2GiQuy/BIvl9KyeF" crossorigin="anonymous"
        onload="renderMathInElement(document.body);"></script>

</head>
<body>
    <header id="sidebar">
		<a href="{{BASE_DIR}}index.html"><img id="logoTop"
			src="{{BASE_DIR}}img/logoS3.png" alt="Logo Samuel Gómez"></a>
		<a id="nav-toggle" href="#">&#9776;</a>
        <section id="info">
			{{INFO}}
		</section>
		<section id="menu">
			{{MENU}}
		</section>
    </header>
	<main>
