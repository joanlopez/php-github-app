all: help

## ==========================
## Symfony GitHub Application
## ==========================
##
## @author Joan López <joanjan14@gmail.com>
## @description Symfony 4 application that use the GitHub's public api
##
## Available commands are:
##

IMAGE_TAG=alpine-php

##  help:		Help
.PHONE : help
help : Makefile
	@sed -n 's/^##//p' $<

##  build:	Build the Docker image
.PHONY : build
build:
	docker build . -t ${IMAGE_TAG}

##  install:	Install the dependencies with Docker
.PHONY : install
install:
	docker run -it --rm -v ${PWD}:/app alpine-php composer install

##  run:		Run a console command
.PHONY : run
run:
	docker run -it --rm -v ${PWD}:/app alpine-php php bin/console $(filter-out $@,$(MAKECMDGOALS))

##  deploy:	Deploy dev server
.PHONY : deploy
deploy:
	docker run -itd --rm -v ${PWD}:/app -p 8000:8000 alpine-php php bin/console server:run 0.0.0.0:8000

## ==========================
## ==========================
