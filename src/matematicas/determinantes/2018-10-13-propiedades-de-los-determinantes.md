---
description: Ejercicios resueltos de determinantes nivel 2º de Bachillerato
---

# Propiedades de los determinantes

![Determinantes]({{BASE_IMG}}2019/determinantes.jpg)

## 1. El determinante del producto de matrices es el producto de sus determinantes
$$|A \cdot B| = |A| \cdot |B|$$

## 2. El determinante de una matriz con alguna fila a columna de ceros es 0
$$A=\left(
\begin{array}{ccc}
	0 & 1 & 7 \\
	0 & 3 & 8 \\
	0 & 2 & 4 \\
\end{array}
\right)$$


## 3. Se puede extraer factor común de una fila o columna multiplicando el determinante por el factor.
*En este ejemplo hemos sacado el factor común 2 de la primera columna*.
$$\left|
\begin{array}{ccc}
	2 & 1 & 2 \\
	6 & 5 & 8 \\
	26 & 21 & 34 \\
\end{array}
\right|
=2\cdot
\left|
\begin{array}{ccc}
	1 & 1 & 2 \\
	3 & 5 & 8 \\
	13 & 21 & 34 \\
\end{array}
\right|
$$

## 4. Si se cambia el orden de una fila o de una columna, el determinante cambia de signo
$$\left|
\begin{array}{ccc}
	1 & 1 & 1 \\
	3 & 5 & 8 \\
	13 & 21 & 17 \\
\end{array}
\right|
=-
\left|
\begin{array}{ccc}
	3 & 5 & 8 \\
	1 & 1 & 1 \\
	13 & 21 & 17 \\
\end{array}
\right|
$$

## 5. Si una matriz es invertible se cumple que
$$|A^{-1}=\frac{1}{|A|}$$

## 6. El determinante de una matriz es igual a su traspuesta
$$|A|=|A^T|$$

## 7. Si una matriz tiene filas alguna fila o columna linealmente dependiente, su determinante es 0. 
*En este ejemplo, la segunda fila es el doble de la primera, por lo que es linealmente dependiente*
$$\left|
\begin{array}{ccc}
	1 & 1 & 2 \\
	2 & 2 & 4 \\
	13 & 21 & 17 \\
\end{array}
\right|=0$$

## 8. El determinante no cambia si se suman filas o columnas multiplicadas por números distintos de 0.
*En este ejemplo hemos sumado a la tercera fila la primera fila dos veces y aún así su determinante es -2*.
$$\left|
\begin{array}{ccc}
	1 & 1 & 2 \\
	3 & 5 & 8 \\
	13 & 21 & 33 \\
\end{array}
\right|=-2=
\left|
\begin{array}{ccc}
	1 & 1 & 2 \\
	3 & 5 & 8 \\
	15 & 23 & 37 \\
\end{array}
\right|
$$




# Ejercicios resueltos

## 1. Hallar el valor del determinante

Sabiendo que:

$$
\left|
\begin{array}{ccc}
	1 & 1 & 1 \\
	a & b & c \\
	d & e & f \\
\end{array}
\right| = 2
$$

Calcular el valor de:

$$
\left|
\begin{array}{ccc}
	6 		& 6 	& 6 	\\
	a-2 	& b-2 	& c-2 	\\
	d/4 	& e/4 	& f/4 	\\
\end{array}
\right|
$$

**Solución** Aplicando exclusivamente las propiedades de los determinantes debemos lograr
que el segundo determinante se convierta en algo parecido al que nos da el enunciado
que es el único que en realidad conocemos:

Saco el factor de la fila 1 $F_1$
$$
6 \cdot
\left|
\begin{array}{ccc}
	1 		& 1 	& 1 	\\
	a-2 	& b-2 	& c-2 	\\
	d/4 	& e/4 	& f/4 	\\
\end{array}
\right|
$$

Saco el factor $\frac{1}{4}$ de la tercera fila $F_3$

$$
\frac{6}{4} \cdot
\left|
\begin{array}{ccc}
	1 		& 1 	& 1 	\\
	a-2 	& b-2 	& c-2 	\\
	d 	& e 	& f 	\\
\end{array}
\right|
$$

Aplicando una combinación lineal a la segunda fila $F_2 = F_2+2\cdot F_1$

$$
\frac{3}{2} \cdot
\left|
\begin{array}{ccc}
	1 		& 1 	& 1 	\\
	a 	& b 	& c 	\\
	d 	& e 	& f 	\\
\end{array}
\right|
$$

Como conocemos el valor del determinante que tenemos en este momento, simplemente
sustituimos por su valor y obtenemos:

$$\frac{3}{2} \cdot 2 = \boxed{3}$$

#2ºBachillerato #determinante #matriz
