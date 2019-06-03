-include .env

.SILENT:
.PHONY: coverage cs it test up

help: ## Display all commands
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

install: ## Init the project
	docker-compose run --rm composer install --prefer-dist --optimize-autoloader --classmap-authoritative

it: ## Launch code style and test the application
it: cs test

coverage: ## Check the code coverage of the application
	docker-compose run --rm php vendor/bin/phpunit --coverage-text

test: ## Test code
	docker-compose run --rm php vendor/bin/phpunit

cs: ## Launch CS fixer.
	docker-compose run --rm php vendor/bin/phpcbf src/

update: ## Update the project
	docker-compose run --rm composer update
