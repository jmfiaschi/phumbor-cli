-include .env

.SILENT:
.PHONY: coverage cs it test up get-url get-urls warmup

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

get-url: ## Get forged url : $ make get-url IMAGE=image TRANSFORMATION=default
	docker-compose run --rm php bin/console phumbor-cli:image:get-url $(IMAGE) --transformation=$(TRANSFORMATION)

get-urls: ## Get forged urls: $ make get-urls IMAGES='image1 image2' TRANSFORMATIONS='{t1,t2}'
	docker-compose run --rm php bin/console phumbor-cli:images:get-url $(IMAGES) --transformations=$(TRANSFORMATIONS)

warmup: ## Warmup thumbor url: $ make warmup IMAGES='image1 image2' TRANSFORMATIONS='{t1,t2}'
warmup: get-urls
	@wget -i $^
