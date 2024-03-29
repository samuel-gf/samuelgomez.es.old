MD := $(shell find src -name '*.md') 					# All sources .md
HTML := $(subst src/,html/,$(MD:.md=.html))				# All targets .html (from source .md) 
TEMPLATES := $(shell find templates -name '*.php')		# All templates .php (from templates/)

all: $(HTML) const.php html/index.html html/contacto.html html/menu.html html/sitemap.xml html/atom.xml

html/%.html: src/%.md $(TEMPLATES)
	php makeArticle.php $@

html/index.html: $(MD) $(TEMPLATES)
	php makeIndex.php

html/contacto.html: pages/contact.php $(TEMPLATES)
	php makeContact.php

html/menu.html:	$(MD) makeMenu.php libGeneral.php
	php makeMenu.php

html/sitemap.xml: $(HTML)
	php makeSitemap.php

html/atom.xml: $(HTML)
	php makeAtom.php

clean:
	@find html -name '*.html' -exec rm {} \;
	@rm -f html/sitemap.xml
	@rm -f html/atom.xml
