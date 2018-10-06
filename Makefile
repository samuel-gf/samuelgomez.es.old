INPUT_FILES = src/*.html

all: $(INPUT_FILES)
	php maker.php $(notdir $<)

clean:
	rm html/*.html
