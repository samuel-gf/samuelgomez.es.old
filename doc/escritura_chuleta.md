# Documentación del proyecto

## Cabeceras

- h1 Título del artículo o apartado "ejercicios resueltos"
- h2 Subapartado del artículo, o enunciado del ejercicio
- h3 Subapartado dentro de un ejercicio, lo que viene a ser un caso concreto o un apartado
- h4 
- h5 Título colocado sobre h1 que se suele emlear como un complemento al título principal, por ejemplo "Últimos artículos"


## Referencias de uso de Markdown

- Una imagen `![Comentario]({{BASE_IMG}}imagen.jpg)`
- Una imagen con estilo propio `![Comentario]({{BASE_IMG}}imagen_con_estilo.jpg){.miEstilo}`
	El estilo puede ser: .leftImg, .rightImg, .wideImg
- Referencia interna [ecuación 1](#ec1) 
	y su punto de destino **(1)**<a name="ec1"></a>



## Sustituciones realizadas por mi script php
### Fecha
Puedes poner:

- {{FECHA}} y se sustituirá por el valor de la fecha de hoy
- {{BASE_IMG}}2019/mi_imagen.jpg	para sustituir por el directorio que contiene las imágenes
- yyyy-mm-dd es el otro formato. Se sustituirá por un formato humano más legible



## Fuentes de imágenes libres

- [Observatorio Europeo del Sur](https://www.eso.org/public/images/)
- [Imágenes de la NASA](https://www.nasa.gov/multimedia/imagegallery/index.html)


## Búscar un patrón en un conjunto de ficheros de texto
Busca y dice el nombre del archivo y la línea que lo contiene
`ack PATRON`


## Combinar varias imágenes en horizontal (o en vertical)

- `convert +append *.jpg final_horizontal.jpg`
- `convert -append *.jpg final_vertical.jpg`
