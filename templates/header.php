<html>
	<head>
		<title>{{TÍTULO PÁGINA}}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="/css/reset.css">
		<link rel="stylesheet" type="text/css" href="/css/general.css">

        <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-MML-AM_CHTML' async></script>
		<script type="text/x-mathjax-config">
  			MathJax.Hub.Config({
    			"HTML-CSS": { scale: 125},
				"SVG": {scale: 125},
				"NativeMML": {scale: 125},
				"MML": {scale: 125},
				"PreviewHTML": {scale: 125},
				"CommonHTML": {scale: 125},
				matchFontHeight: true
  				});
			MathJax.Hub.Register.StartupHook("End Jax",function () {
				var BROWSER = MathJax.Hub.Browser;
  				var jax = "CommonHTML";
  				if (BROWSER.isMSIE && BROWSER.hasMathPlayer) jax = "NativeMML";
				return MathJax.Hub.setRenderer(jax);
				});
		</script>

	</head>
	<body>
        <aside>
			<img id="logoTop" src="/img/logoS3.png" alt="Logo Samuel Gómez">
			<a id="nav-toggle" href="#">&#9776;</a>
            {{SOBRE MÍ}}
        </aside>
		<main>
