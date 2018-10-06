SOURCES := $(shell find src -name '*.phtml')
OBJECTS := $(addprefix html/, $(basename $(notdir $(shell find src -name '*.phtml')))).html


$(OBJECTS) : $(SOURCES)
	php makeArticle.php $(notdir $<)

clean:
	@rm html/*.html
