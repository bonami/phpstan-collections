-include local/Makefile

all: deps test

deps:
	docker run -it --rm -v ${PWD}:/app -w /app composer update --prefer-dist --verbose --no-interaction

test:
	$(MAKE) phpunit
	$(MAKE) phpstan
	$(MAKE) fmt-check

phpstan:
	docker run -it --rm -v ${PWD}:/app -w /app php:8.4-cli-alpine php -d memory_limit=-1 bin/phpstan --ansi analyse

phpstan-clear-cache:
	docker run -it --rm -v ${PWD}:/app -w /app php:8.4-cli-alpine php -d error_reporting=-1 -d memory_limit=-1 bin/phpstan --ansi clear-result-cache

phpunit:
	docker run -it --rm -v ${PWD}:/app -w /app php:8.4-cli-alpine php -d error_reporting=-1 bin/phpunit --colors=always -c phpunit.xml

fmt-check:
	docker run -it --rm -v ${PWD}:/app -w /app php:8.4-cli-alpine php bin/phpcs --standard=./ruleset.xml --extensions=php --tab-width=4 -sp ./src ./tests

fmt:
	docker run -it --rm -v ${PWD}:/app -w /app php:8.4-cli-alpine php bin/phpcbf --standard=./ruleset.xml --extensions=php --tab-width=4 -sp ./src ./tests
