MD := $(shell find src -name '*.md')
HTML := $(subst src/,html/,$(MD:.md=.html))
TEMPLATES := $(shell find templates -name '*.php')

all: $(HTML) html/index.html

html/%.html: src/%.md $(TEMPLATES)
	php makeArticle.php $@


html/index.html: $(MD)
	php makeIndex.php

clean:
	@find html -name *.html -exec rm {} \;
