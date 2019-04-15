# phumbor-cli

Little tools in order to forge thumbor url on the fly.

## How to install

Load all dependancies:
```
$ docker-compose run --rm composer install --prefer-dist --no-interaction --ignore-platform-reqs --optimize-autoloader -vvv --no-scripts
```

Custom your own transformers with this file : app/config/packages/phumbor.yaml

## How to use

Generate an signed url with an image name:
```
$ docker-compose run --rm php bin/console phumbor-cli:image:get-url test
```

Generate a list of url with a url file and some transformers:
```
$ input=($(awk -F/ '{ printf "%s ", $0 } END {print ""}' data/urls.txt)) && docker-compose run --rm php bin/console phumbor-cli:images:get-url $input -vvv --transformations={t1,t2}
```

Warmup an image:
```
$ docker-compose run --rm php bin/console phumbor-cli:image:get-url test -t default | xargs wget
```

Warmup a list of images:
```
$ input=($(awk -F/ '{ printf "%s ", $0 } END {print ""}' data/urls.txt)) && docker-compose run --rm php bin/console phumbor-cli:images:get-url $input -vvv --transformations={t1,t2} | wget -i -
```
