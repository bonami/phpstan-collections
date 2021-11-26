-include local/Makefile

all: deps test

deps:
	docker run -it --rm -v ${PWD}:/app -w /app composer update --prefer-dist --verbose --no-interaction --optimize-autoloader

test:
	docker run -it --rm -v ${PWD}:/app -w /app composer run-script test

phpstan:
	docker run -it --rm -v ${PWD}:/app -w /app composer run-script phpstan

fmt-check:
	docker run -it --rm -v ${PWD}:/app -w /app composer run-script phpcs

fmt:
	docker run -it --rm -v ${PWD}:/app -w /app composer run-script phpcbf
