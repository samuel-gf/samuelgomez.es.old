PHTML := $(shell find src -name '*.phtml')
HTML := $(addprefix html/, $(basename $(notdir $(shell find src -name '*.phtml')))).html
TEMPLATES := $(shell find templates -name '*.php')

$(HTML) : $(TEMPLATES) $(PHTML)
	php makeArticle.php $(basename $(notdir $@)).phtml

clean:
	@rm html/*.html
