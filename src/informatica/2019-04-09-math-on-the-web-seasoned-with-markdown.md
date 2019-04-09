# Math on the web seasoned with markdown

Yeahh, so you are looking for a solution to write math fastly. So here is your recipe:

## Markdown
[Markdown](https://www.markdownguide.org/) is your main ingredient. This is a lightweight and super easy
markup language that you can use and learn in just five minutes. Don't you believe me? Let's see an example:

```markdown
# This is the title
This is a simple text just to show you how it works ... hello world!
```

So, you can write the previous text in virtually any kind of plain text code editor. I am using [vim](https://www.vim.org/) 
write now, but you can use whatever you want.

Ok, let's go again, but now with maths 

## KaTeX
[KaTeX](https://katex.org/) is the fastest library to write math on the web I have found. So let's add some math to
our markdown code:

```markdown
# This is the title
This is a simple text just to show you how it works ... hello world!
$$b=\frac{-b\pm\sqrt{b^2-4ac}}{2a}$$
```
As you can see the last line of our code is a math expression written in other language called LaTeX. This is a common
way to write math using a computer. Ok, let's go to the next step of the tutorial.

## LaTeX
[LaTeX](https://www.latex-project.org/) is a high-quality typesetting setting to produce technical and scientific
documents. It is also a common language among mathematicians and physicists who want to produce math with the
computer. The old discussion **Word vs LaTeX** is an never ended issue, but I recommend you to learn LaTeX if
you want really to write math using your computer.

There are many cheat-sheet. I recommend you [the David Hamman's cheat sheet](https://davidhamann.de/2017/06/12/latex-cheat-sheet/)
to begin.

## Pandoc
Finally, you must transform your markdown file to other format. It is important to translate it to a universal format like
pdf. In my experience [Pandoc](https://pandoc.org/) is the best tool. It can transform your previous file with three lines
to a pdf file with the header, the line of text and the math expression.

This is the command line I use to transform my code to **pdf**

```bash
pandoc my_file.md -f markdown+tex_math_dollars-fancy-list --katex -o my_file.pdf
```

After this I get my PDF, but if I need an **html** file I write in the command line:

```bash
pandoc my_file.md -f markdown+tex_math_dollars-fancylist --katex -o my_file.html
```

Pandoc is the perfect tool to transform my markdown file to other formats like pdf or html for the web.
 
## A real example
You can see a real example of [math on the web](http://samuelgomez.es/EvAU/2017/2018-10-22-matematicas-madrid-evau-2017-modelo-opcion-a.html). Good luck and improved effort.

#markdown #html #math #lightweight #katex #latex #pandoc
