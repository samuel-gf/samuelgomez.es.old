<html>
	<head>
		<title>{{TÍTULO PÁGINA}}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="{{BASE_DIR}}css/reset.css">
		<link rel="stylesheet" type="text/css" href="{{BASE_DIR}}css/general.css">

		<script src='{{BASE_DIR}}js/jquery.js'></script>
		<script src='{{BASE_DIR}}js/general.js'></script>

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
