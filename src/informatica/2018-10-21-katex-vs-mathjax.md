# KaTeX vs MathJax

2018-10-21

$$e^{i\pi}+1=0$$

Para el desarrollo de mi sitio personal he probado ambas librerías javascript y debo
decir que he notado alguna que otra diferencia en su uso. Ambas son herramientas
muy útiles para representar matemáticas en la web.

Debo aclarar que antes de usar estas dos me decanté por [MathML](https://es.wikipedia.org/wiki/MathML)
pero desgraciadamente [Google Chrome no tiene soporte para MathML](https://www.quora.com/Why-did-Chrome-drop-MathML-support)
con lo cual no me quedó más remedio que estudiar las opciones que os voy a presentar.

Ambas librerías permiten escribir código [LaTeX](https://www.latex-project.org) y transformarlo en tiempo
real a un formato matemático mediante JavaScript.

* [KaTeX](https://katex.org) ofrece la posibilidad de transformar fórmulas con gran rápidez. En realidad
parece ser que [es más rápido que su rival MathJax](https://www.intmath.com/cg5/katex-mathjax-comparison.php)
pero [no soporta todas las funciones](https://github.com/Khan/KaTeX/wiki/Things-that-KaTeX-does-not-%28yet%29-support)

* [MathJax](https://www.mathjax.org) parece ser un proyecto que tiene un mayor soporte por parte
de la comunidad de desarrolladores y esto significa que puede representar más y mejores expresiones matemática
que su rival KaTeX

Tras experimentar con ambos, he decidido quedarme con KaTeX para este sitio web ya que no
emplea cookies y deseo crear un sitio web totalmente limpio. Además KaTeX me ofrece
mayor velocidad y eso es importante porque deseo emplear muchas expresiones matemáticas.

Uno de los puntos fuertes de este sitio web es que es en
su mayoría estático, esto implica que es ligero y rápido de cargar y visualizar, incluso en un
equipo antiguo.

#KaTeX #MathJaX #librería #web
