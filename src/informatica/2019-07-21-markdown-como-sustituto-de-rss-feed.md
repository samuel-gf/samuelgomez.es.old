---
description: Claves para sustituir paulatinamente los feeds RSS por markdown que resulta ser más abierto y fácil
---

# Markdown como sustituto de RSS feed

2019-07-21

![Logotipo de RSS Real Simple Syndication]({{BASE_IMG}}logo/rss.png)

Esta semana estaba escribiendo el código que me permitiese generar un *feed atom* de mi
blog personal y me di cuenta de que emplear *xml* era extremadamente engorroso en los tiempos
que corren.

Habitualmente escribo mis artículos en *markdown* y posteriormente los exporto a *html*
mediante *pandoc*. Veo multitud de ventajas al usar *markdown*.

Entonces experimento un momento *eureka* cuando me di cuenta de que un formato tan sencillo, 
tan libre, tan abierto como es *markdown* sería perfecto para poner información en la red
que pudiese ser procesada por máquinas y que nos permita a los lectores escapar del *algoritmo*.

**¿Cómo podría hacerse esto?** Fácil, tan solo debemos escribir un archivo llamado *index.md* que 
contenga el listado de artículos como el ejemplo que aparece abajo. También tienes un
[ejemplo de markdown que sustituye un feed rss]({{BASE_IMG}}2019/meneame.md)

```
# First post

2019 07 20

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis accumsan, 
augue vulputate dapibus mollis, neque dolor ultricies tortor, eu faucibus 
nisi mauris nec dui. Suspendisse dictum, ex vel molestie posuere, 
dui urna congue neque, sit amet interdum diam mi eu libero. In hac habitasse platea dictumst.

[Read more](https://example.com/first-post)


# Second post

2019 07 21

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis accumsan, 
augue vulputate dapibus mollis, neque dolor ultricies tortor, eu faucibus 
nisi mauris nec dui. Suspendisse dictum, ex vel molestie posuere, 
dui urna congue neque, sit amet interdum diam mi eu libero. In hac habitasse platea dictumst.

[Read more](https://example.com/second-post)
```

## Markdown as a replacement for RSS

This week I was coding to generate my own *atom feed* for my personal blog and I remmembered
the difficulty of *xml code*. 

I usually write my post using *markdown* and then I export them to *html* with *pandoc*.
I see many advantages using *markdown*.

Then I felt an *eureka effect* as I realized that a so simple format, so free (as in freedom),
so open as *markdown* would be perfect to share information. It could be processed by machines
and it would let us escape the *algorithm*.

**How can we do this?** Easy, just write a file named *index.md* with the content of the previous example.
You can also see this [example of markdown replacing a rss feed]({{BASE_IMG}}2019/meneame.md)

#markDown #rss #atom #feed
