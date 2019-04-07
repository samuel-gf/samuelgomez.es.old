# Discutir el sistema de ecuaciones en función del parámetro
$$
\left.
\begin{array}{cccccc}
	x&+y&-z&=&\lambda \\
	\lambda x&+2y&-z&=&3\lambda \\
	2x&+\lambda y &-z&=&6
\end{array}
\right\}
$$

**Solución** Escribimos el sistema de ecuaciones como matriz $A$

$$
A= \left(
\begin{array}{cccc}
	1 		& 1 & -1 \\
	\lambda & 2 &-1  \\
	2 		&	\lambda & -1
\end{array}
\right)
$$

Calculamos el rango de $A$ a partir de sus determinantes. Sabemos que el
rango de $A$ es 3 porque es de 3x3, excepto cuando su determinante sea 0,
buscamos este caso

$$
|A|= \left|
\begin{array}{ccc}
	1 		& 1 & -1 \\
	\lambda & 2 &-1  \\
	2 		&	\lambda & -1
\end{array}
\right| = -\lambda^2+2\lambda=0
$$

Obtenemos que si $\lambda$ es 0 o 2 el deteminante vale 0
$$\lambda \in \{0, 2\} \rightarrow |A| = 0 $$

Ahora sabemos que en estos dos casos el rango de $\lambda$ no es 3 pero
¿cuál es entonces su rango?

Buscamos el siguiente número menor, probamos con rango 2 para ello busco
una matriz de 2x2 que obtengo de la matriz $A$

$$
|A|= \left|
\begin{array}{cc}
	1 & -1 \\
	2 & -1
\end{array}
\right| = 1 \not= 0
$$

Luego he descubierto que la matriz $A$ sí es rango 2 independientemente
del valor de $\lambda$

|$\lambda$ | Rango(A)|
|:--------:|:-------:|
|0   	   | 2       |
|2   	   | 2       |
|otro      | 3       |


Ahora estudiaré el rango de la matriz ampliada $A^*$ para los casos &lambda;=0 y &lambda;=2

$$
A= \left(
\begin{array}{ccc|c}
	1 		& 1 & -1 & \lambda \\
	\lambda & 2 &-1 & 3\lambda \\
	2 		&	\lambda & -1 & 6
\end{array}
\right)
$$

### Si $\lambda = 0$

Hago el determinante pero sustituyo el valor de &lambda; por el valor 0. Como es la matriz
ampliada elijo tres columnas de las cuatro posibles. En este caso elijo las columnas
1, 2 y 4

$$
|A^*|= \left|
\begin{array}{ccc}
	1 & 1 & 0 \\
	0 & 2 	& 0  \\
	2 &	0 & 6
\end{array}
\right| = 12 \not= 0
$$

Luego para &lambda;=0 el Rango de $A^*$ es 3

$$\lambda=0 \rightarrow \text{Rango}(A^*)=3$$

### Si $\lambda=2$

He buscado todos los determinantes posibles a partir de elegir tres columnas de las
cuatro posibles. No he encontrado ninguna que dé un valor diferente de cero, luego
no puede ser de rango 3. Probaré a ver si es de rango 2, para ello selecciono un
determinante de 2x2. En principio sería rango 2 salvo que el determinante valga 0

$$
|A|= \left|
\begin{array}{cc}
	1 & -2 \\
	2 & \phantom{-}6
\end{array}
\right| = 10 \not= 0
$$

Como el resultado no es nulo el rango es 2

Construyo una tabla con los datos obtenidos hasta ahora

|$\lambda$| Rango(A)| Rango($A^*$)| Nº incógnitas | Sistema |
|:-------:|:-------:|:-----------:|:-------------:|:-------:|
|0   	  |    2    |      3      |       3       |  S.I.   |
|2   	  |    2    |      2      |       3       |  S.C.I. |
|otro     |    3    |      3      |       3       |  S.C.D. |

Donde S.I. significa sistema incompatible; S.C.D. sistema compatible determinado y
S.C.I. es sistema compatible indeterminado

Esta última columna la obtenemos aplicando el teorema de Rouche-Fröbenius

#SistemaDeEcuaciones #2ºbachillerato #determinante #Rouche-Fröbenius
