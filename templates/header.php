<!DOCTYPE html>
	<head>
		<title>{{TÍTULO PÁGINA}}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="{{BASE_DIR}}css/reset.css">
		<link rel="stylesheet" type="text/css" href="{{BASE_DIR}}css/general.css">

		<script src='{{BASE_DIR}}js/jquery.js'></script>
		<script src='{{BASE_DIR}}js/general.js'></script>

		<script type="text/x-mathjax-config">
		MathJax.Hub.Config({
		  jax: ["input/TeX","output/CommonHTML"],
		  extensions: ["tex2jax.js","MathMenu.js","MathZoom.js", "AssistiveMML.js", "a11y/accessibility-menu.js"],
		  TeX: {
		    extensions: ["AMSmath.js","AMSsymbols.js","noErrors.js","noUndefined.js"]
		},
		"fast-preview": {
			    Chunks: {EqnChunk: 10000, EqnChunkFactor: 1, EqnChunkDelay: 0},
			    color: "inherit!important",
			    updateTime: 30, updateDelay: 6,
			    messageStyle: "none",
			    disabled: false
			  }
		});
		</script>
		<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js' async></script>

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
