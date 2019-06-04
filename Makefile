-include .env

.SILENT:
.PHONY: cs clear it test quality up get-url get-urls curl warmup

help: ## Display all commands
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

install: ## Init the project
	docker-compose run --rm composer install --prefer-dist --optimize-autoloader --classmap-authoritative

quality: ## Check the code quality
	docker-compose run --rm php vendor/bin/phpinsights

test: ## Test code
	docker-compose run --rm php vendor/bin/phpunit --cache-result-file=var/cache/.phpunit.result

clear: ## Clear the cache
	docker-compose run --rm php bin/console c:c

cs: ## Launch CS fixer.
	docker-compose run --rm php vendor/bin/ecs check --fix src

update: ## Update the project
	docker-compose run --rm composer update

get-url: ## Get forged url : $ make get-url IMAGE=image TRANSFORMATION=default
	docker-compose run --rm php bin/console phumbor-cli:image:get-url $(IMAGE) --transformation=$(TRANSFORMATION)

get-urls: ## Get forged urls: $ make get-urls IMAGES='image1 image2' TRANSFORMATIONS='{t1,t2}'
	docker-compose run --rm php bin/console phumbor-cli:images:get-url $(IMAGES) --transformations=$(TRANSFORMATIONS)

warmup: ## Warmup thumbor url: $ make warmup IMAGES='image1 image2' TRANSFORMATIONS='{t1,t2}'
	docker-compose run --rm php bin/console phumbor-cli:images:get-url $(IMAGES) --transformations=$(TRANSFORMATIONS) | wget -i -
