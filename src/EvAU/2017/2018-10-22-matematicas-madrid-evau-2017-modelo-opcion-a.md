# Matemáticas Madrid EvAU 2017 modelo opción A

Dadas las matrices:

$$
A=
\left(
\begin{array}{ccc}
	1 & -1 & 1 \\
	1 & 0 & -1 \\
	-1 & 2 & 2 \\
\end{array}
\right)
\;\;\;\;
B=
\left(
\begin{array}{ccc}
	1 & 2 & m \\
	2 & 4 & 1 \\
	m & 2 & -1 \\
\end{array}
\right)
\;\;\;\;
C=
\left(
\begin{array}{ccc}
	1 & 1 & -1 \\
	-1 & 2 & 1 \\
	1 & -2 & 0 \\
\end{array}
\right)
$$


## Primer ejercicio

Calcular el valor de B en función de los valores de m

**Solución** Vamos a emplear el método de los determinantes, para ello, primero probamos con un determinante
pequeño, por ejemplo, de 2x2, y para ellos elegimos los términos que elementos de la matriz
que más nos convenga. Por ejemplo, elegimos los cuatro de abajo a la derecha porque no tienen
la incógnita $m$

Comprobamos cuanto vale su determinante. Si su determinante es distinto de cero entonces la matriz es
al menos de rango 2, $\text{Rango}(B)>=2$

$$
|B|=
\left|
\begin{array}{cc}
	4 & 1 \\
	2 & -1 \\
\end{array}
\right|
=-4-4=-8
$$

Acabamos de comprobar que el rango de $B$ es al menos dos independientemente del valor de $m$. Veamos ahora
si podría ser de rango 3 mediante su determinante

$$
|B|=
\left|
\begin{array}{ccc}
	1 & 2 & m \\
	2 & 4 & 1 \\
	m & 2 & -1 \\
\end{array}
\right|
=-4m^2+6m-2
$$

Lo igualamos a cero porque nuestro objetivo es averiguar para que valor de $m$ el determinante se anula

$$-4m^2+6m-2=0$$

Obtenemos los resultados 1 y $\frac{1}{2}$. Llegamos a la conclusión de que si $m$ toma
alguno de esos valores el determinante se anula (vale 0) y por lo tanto la matriz
no puede ser de rango 3.

**Conclusión** Si $m$ toma el valor 1 o $\frac{1}{2}$ el rango de la matriz será 2, en caso contrario
será de rango 3. En lenguaje matemático se dice:

$$\text{Rango}(B)=\begin{cases}
      2 & \text{si m} \in \{1, \frac{1}{2}\} \\
      3 & \text{para otros valores de m}
   \end{cases}$$


## Segundo ejercicio
Calcular la matriz inversa de $A$ y comprobar que verifica $A^{-1}=\frac{1}{5}(A^2+3c)$

**Solución**

Buscamos la inversa de $A=\left(
	\begin{array}{ccc}
		1 & -1 & 1 \\
		1 & 0 & -1 \\
		-1 & 2 & 2 \\
	\end{array}
	\right)$

Tenemos varias formas de encontrar la inversa $A^{-1}$. En este caso vamos a emplear
la fórmula

$$A^{-1}=\frac{1}{|A|}\cdot adj(A)^T$$

Para poder usarla debemos obtener el determinante $|A|$

$$|A|=\left|
\begin{array}{ccc}
	1 & -1 & 1 \\
	1 & 0 & -1 \\
	-1 & 2 & 2 \\
\end{array}
\right|
=5$$

Ahora vamos a calcular la adjunta $adj(A)$
$$
\begin{array}{lll}
		\phantom{-}\left|\begin{array}{cc} 0 & -1 \\ 2 & 2 \end{array}\right|=2\hspace{1cm} &
	 	-\left|\begin{array}{cc} 1 & -1 \\ -1 & 2 \end{array}\right|=-1\hspace{1cm}&
		\phantom{-}\left|\begin{array}{cc} 1 & 0 \\ -1 & 2 \end{array}\right| = 2
		 \\		 \\
		-\left|\begin{array}{cc} -1 & 1 \\ 2 & 2 \end{array}\right|=4\hspace{1cm} &
	 	\phantom{-}\left|\begin{array}{cc} 1 & 1 \\ -1 & 2 \end{array}\right|=3\hspace{1cm} &
		-\left|\begin{array}{cc} 1 & -1 \\ -1 & 2 \end{array}\right|=-1
		 \\		 \\
		\phantom{-}\left|\begin{array}{cc} -1 & 1 \\ 0 & -1 \end{array}\right|=1\hspace{1cm} &
	 	-\left|\begin{array}{cc} 1 & 1 \\ 1 & -1 \end{array}\right|=2\hspace{1cm} &
		\phantom{-}\left|\begin{array}{cc} 1 & -1 \\ 1 & 0 \end{array}\right|=1
		 \\		 \\
\end{array}$$

Así pues, obtenemos la matriz de adjuntos

$$adj(A)=\left(
\begin{array}{rrr}
	2 & -1 & 2 \\
	4 & 3 & -1 \\
	\phantom{-}1 & 2 & 1
\end{array}
\right)$$

Ahora vamos a calcular la traspuesta de esta misma

$$adj(A)^T=\left(
\begin{array}{rrr}
	2 & 4 & 1 \\
	-1 & 3 & 2 \\
	2 & -1 & \phantom{-}1
\end{array}
\right)$$

Y finalmente la inversa a partir de la fórmula que llamaremos **(1)**<a name="ec1"></a>

$$A^{-1}=\frac{1}{|A|}adj(A)^T=\frac{1}{5}
\left(\begin{array}{rrr}
	2 & 4 & 1 \\
	-1 & 3 & 2 \\
	2 & -1 & \phantom{-}1
\end{array}
\right)$$

También debemos obtener $A^2$

$$A^2=
\left(
\begin{array}{rrr}
	1 & -1 & 1 \\
	1 & 0 & -1 \\
	-1 & 2 & 2 \\
\end{array}
\right)
\cdot
\left(
\begin{array}{rrr}
	1 & -1 & 1 \\
	1 & 0 & -1 \\
	-1 & 2 & 2 \\
\end{array}
\right)
=
\left(
\begin{array}{rrr}
	-1 & 1 & 4 \\
	2 & -3 & -1 \\
	-1 & 5 & 1 \\
\end{array}
\right)
$$

Finalmente sustituimos en la fórmula del enunciado

$$\frac{1}{5}(A^2+3C)=\frac{1}{5}
\left[
	\left(
	\begin{array}{rrr}
		-1 & 1 & 4 \\
		2 & -3 & -1 \\
		-1 & 5 & 1 \\
	\end{array}
	\right)
	+
	\left(
	\begin{array}{rrr}
		3 & 3 & -3 \\
		-3 & 6 & 3 \\
		3 & -6 & 0 \\
	\end{array}
	\right)
\right]$$

Y el resultado final es

$$\frac{1}{5}(A^2+3C)=\frac{1}{5}
\left(
	\begin{array}{rrr}
		2  & 4 & 1\\
		-1 & 3 & 2\\
		2  &-1 & 1
	\end{array}
\right)
$$

Como vemos, esta expresión es la misma que la [ecuación 1](#ec1) por lo tanto, comprobamos que
sí que se cumple la igualdad

#EvAU #2ºBachillerato #determinante #matriz
