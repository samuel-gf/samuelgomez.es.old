MD := $(shell find src -name '*.md')
HTML := $(subst src/,html/,$(MD:.md=.html))
TEMPLATES := $(shell find templates -name '*.php')

all: $(HTML) const.php html/index.html html/contacto.html html/sitemap.xml

html/%.html: src/%.md $(TEMPLATES)
	php makeArticle.php $@

html/index.html: $(MD) $(TEMPLATES)
	php makeIndex.php

html/contacto.html: pages/contact.php $(TEMPLATES)
	php makeContact.php

html/sitemap.xml: $(MD)
	php makeSitemap.php

clean:
	@find html -name *.html -exec rm {} \;
	@rm -f html/sitemap.xml
