PHTML := $(shell find src -name '*.phtml')
HTML := $(subst src/,html/,$(PHTML:.phtml=.html))
TEMPLATES := $(shell find templates -name '*.php')

$(HTML) : $(subst src/,html/,$($@:.html=.phtml)) $(TEMPLATES)
	php makeArticle.php $@

templates/menu.php: $(find dst -type d)


clean:
	@find html -name *.html -exec rm {} \;
