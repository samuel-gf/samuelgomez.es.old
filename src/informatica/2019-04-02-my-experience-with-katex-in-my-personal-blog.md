---
title: My experience with KaTeX in my personal blog
author: Samuel Gómez
date: 2019-04-02
keywords: KaTeX, blog, speed, printQuality, possibilities
---

# My experience with KaTeX in my personal blog

![KaTeX logo](https://katex.org/img/og_logo.png)

I have been using KaTeX for almos half a year and now I can share my ideas about this fast javascript
library.

First of all **time**. This es the key as I have spent 0.3 seconds while my 
intel core i3 renders the [test page](https://www.intmath.com/cg5/katex-mathjax-comparison.php) 
with KaTeX but I spent 2.5 seconds rendering with MathJax.

So KaTeX is $\text{ratio}=\frac{2.5}{0.3}=8.3$ times faster than MathJax. I suppose this is not an inconvenient
if you have just two or three formulae but in my personal website I need to share as much as I need to
teach mathematics properly, so the decision was not hard to take.

Second, **print quality**. After all, we all want our web sites to be presented as beautiful as possible.
As KaTeX uses the original layout of Donald Knuth, the creator of LaTeX, the results are awesome.

Finally, **possibilities**. Althought I do not use this feature, but KaTeX can be pre-rendered in the server so I can send
the expressions as plain HTML.

#KaTeX #blog #speed #printQuality #possibilities