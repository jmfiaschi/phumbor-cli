# phumbor-cli

Little tools in order to forge thumbor url on the fly. You can use it in order to warm up pictures.

## How to install

```bash
make install
make test
```

Change all config files:

* app/config/packages/phumbor.yaml : Custom some transformers.
* .env.dist : Rename .env.dist into .env and config it.

## How to use

Generate an signed url with an image name:

```bash
make get-url IMAGE=image TRANSFORMATION=default
```

Generate a list of url with a url file and some transformers:

```bash
input=($(awk -F/ '{ printf "%s ", $0 } END {print ""}' data/urls.txt)) && make get-urls IMAGES="${input}" TRANSFORMATIONS='--transformations=t1 --transformations=t2'
```

Warmup a list of images:

```bash
input=($(awk -F/ '{ printf "%s ", $0 } END {print ""}' data/urls.txt)) && make warmup IMAGES="${input}" TRANSFORMATIONS='--transformations=t1 --transformations=t2'
```
