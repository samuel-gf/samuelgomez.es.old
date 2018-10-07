PHTML := $(shell find src -name '*.phtml')
HTML := $(subst src/,html/,$(PHTML:.phtml=.html))
TEMPLATES := $(shell find templates -name '*.php')

$(HTML) : $(subst src/,html/,$($@:.html=.phtml)) $(TEMPLATES)
	php makeArticle.php $@

clean:
	@find html -name *.html -exec rm {} \;
