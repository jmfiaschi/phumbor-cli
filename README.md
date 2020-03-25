# phumbor-cli

Little tools in order to forge thumbor url on the fly.

## How to install

```
$ make install
$ make test
```

Change all config files:
* app/config/packages/phumbor.yaml : Custom some transformers.
* .env.dist : Rename .env.dist into .env and config it.

## How to use

Generate an signed url with an image name:
```
$ make get-url IMAGE=image TRANSFORMATION=default
```

Generate a list of url with a url file and some transformers:
```
$ input=($(awk -F/ '{ printf "%s ", $0 } END {print ""}' data/urls.txt)) && make get-urls IMAGES="${input}" TRANSFORMATIONS='--transformations=t1 --transformations=t2'
```

Warmup a list of images:
```
$ input=($(awk -F/ '{ printf "%s ", $0 } END {print ""}' data/urls.txt)) && make warmup IMAGES="${input}" TRANSFORMATIONS='--transformations=t1 --transformations=t2'
```
