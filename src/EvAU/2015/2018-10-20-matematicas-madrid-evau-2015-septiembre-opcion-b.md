# Matemáticas Madrid EvAU 2015 septiembre opción B

Hallar el valor del determinante sabiendo que:

$$
\left|
\begin{array}{ccc}
	a & b & c \\
	d & e & f \\
	1 & 2 & 3 \\
\end{array}
\right| = 3
$$

Calcular el valor de estos dos determinantes:

## Primer determinante
$$
\left|
\begin{array}{ccc}
	2a-2b 		& c 	& 5b 	\\
	2d-2e 		& f 	& 5e 	\\
	-2	 		& 3 	& 10 	\\
\end{array}
\right|
$$

**Solución** Aplicando exclusivamente las propiedades de los determinantes debemos lograr
que el determinante se convierta en algo parecido al que nos da el enunciado
que es el único que en realidad conocemos.

Saco factor común 5 de la tercera columna $C_3$ fuera del determinante

$$
5 \cdot
\left|
\begin{array}{ccc}
	2a-2b 		& c 	& b 	\\
	2d-2e 		& f 	& e 	\\
	-2	 		& 3 	& 2 	\\
\end{array}
\right|
$$

Aplico la combinación lineal a la 1ª columna $C_1 = C_1+2 \cdot C_3$

$$
5 \cdot
\left|
\begin{array}{ccc}
	2a 		& c 	& b 	\\
	2d 		& f 	& e 	\\
	2 		& 3 	& 2 	\\
\end{array}
\right|
$$

Saco factor común 2 a la primera columna $C_1$

$$
10 \cdot
\left|
\begin{array}{ccc}
	a 		& c 	& b 	\\
	d 		& f 	& e 	\\
	1 		& 3 	& 2 	\\
\end{array}
\right|
$$

Intercambio la segunda columna $C_2$ por la tercera columna $C_3$
y obtenemos el mismo determinante que me daba el enunciado

$$
-10 \cdot
\left|
\begin{array}{ccc}
	a 		& b 	& c 	\\
	d 		& e 	& f 	\\
	1 		& 2 	& 3 	\\
\end{array}
\right|
$$

Sustituyo el determinante que conozco y obtengo la solución

$$-10 \cdot 3 = \boxed{-30}$$

## Segundo determinante
$$
\left|
\begin{array}{ccc}
	a-1 		& b-2 	& 2c-6 	\\
	2	 		& 4 	& 12 	\\
	d	 		& e 	& 2f 	\\
\end{array}
\right|
$$

**Solución** Saco el factor 2 de la tercera columna $C_3$ fuera del determinante

$$
2 \cdot
\left|
\begin{array}{ccc}
	a-1 		& b-2 	& c-3 	\\
	2	 		& 4 	& 6 	\\
	d	 		& e 	& f 	\\
\end{array}
\right|
$$

Ahora saco el factor 2 de la segunda file $F_2$

$$
4 \cdot
\left|
\begin{array}{ccc}
	a-1 		& b-2 	& c-3 	\\
	1	 		& 2 	& 3 	\\
	d	 		& e 	& f 	\\
\end{array}
\right|
$$

Aplico la siguiente combinación lineal $F_1=F_1+F_2$
$$
4 \cdot
\left|
\begin{array}{ccc}
	a 		& b 	& c 	\\
	1 		& 2 	& 3 	\\
	d 		& e 	& f 	\\
\end{array}
\right|
$$

Cambio la segunda fila $F_2$ por la tercera $F_3$

$$
-4 \cdot
\left|
\begin{array}{ccc}
	a 		& b 	& c 	\\
	d 		& e 	& f 	\\
	1 		& 2 	& 3 	\\
\end{array}
\right|
$$

Sustituyo el valor del determinante que conozco por el enunciado para obtener
el enunciado

$$-4 \cdot 3 = \boxed{-12}$$

#EvAU #2ºBachillerato #determinante #matriz
