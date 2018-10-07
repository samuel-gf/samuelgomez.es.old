PHTML := $(shell find src -name '*.phtml')
HTML := $(subst src/,html/,$(PHTML:.phtml=.html))
TEMPLATES := $(shell find templates -name '*.php')

all: $(HTML)

html/%.html: src/%.phtml $(TEMPLATES)
	php makeArticle.php $@

#$(HTML) : $(subst html/,src/,$(@:.html=.phtml)) $(TEMPLATES)
#	echo $(subst html/,src/,$(@:.html=.phtml))
#	php makeArticle.php $@



clean:
	@find html -name *.html -exec rm {} \;
