SOURCES := $(shell find src -name '*.phtml')
OBJECTS := $(addprefix html/, $(notdir $(shell find src -name '*.html')))

$(OBJECTS) : $(SOURCES)
	php makeArticle.php $(notdir $<)

clean:
	@rm html/*.html
