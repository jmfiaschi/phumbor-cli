# phumbor-cli

Little tools in order to forge thumbor url on the fly.

## How to install

Load all dependancies:
```
$ docker-compose run --rm composer install --prefer-dist --no-interaction --ignore-platform-reqs --optimize-autoloader -vvv --no-scripts
```

Custom your own transformers with this file : app/config/packages/phumbor.yaml

## How to use

To see all symfony's commands:
```
$ docker-compose run --rm php bin/console
```

Generate an url with an image name:
```
$ docker-compose run --rm php bin/console
```

Warmup an image:
```
$ docker-compose run --rm php bin/console phumbor-cli:image:get-url test -t default | xargs wget
```

Warmup a list of images: (todo)
```
$ docker-compose run --rm php bin/console phumbor-cli:images:get-url images | wget -i -
```
