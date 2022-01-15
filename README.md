# DevSavvy Online Book Store Reference Project

A reference project for the DevSavvy bootcamp project.

## Usage

To get started, make sure you have [Docker installed](https://docs.docker.com/get-docker/) on your system, and then clone this repository.

## Run The Containers

Spin up the project.

    `docker-compose up -d --build site`

Common Commands:

    // utility containers
    `docker-compose run --rm composer update`
    `docker-compose run --rm artisan config:clear`
    `docker-compose run --rm npm install`
    `docker-compose run --rm npm run prod`
    
    // build
    `docker-compose build --no-cache`
    
    // run
    `docker-compose up -d site`
    
    // stop
    `docker-compose down`
    `docker-compose down --rmi=all --remove-orphans`
    
    // cleanup
    `docker-compose down --rmi=all --remove-orphans`
    `docker image rm -f $(docker image ls -a -q)`
    `docker container rm -f $(docker container ls -a -q)`

## Urls

* http://localhost/
* http://localhost:8081 - phpmyadmin

## Databases

An empty database is created created on the first build.

## Volumes

* /mysql
* /src

## Ports

* nginx: *80*
* mysql: *3306*
* php: *9000*

## Create A New Project

* Delete all the files inside /src
* Delete all the files inside /mysql
* Run these commands inside /src
    * `docker-compose run --rm composer create-project laravel/laravel .`
    * `docker-compose run --rm npm install`
    * `docker-compose run --rm npm run prod`
    * `docker-compose run --rm artisan migrate:fresh`
* Update .env file
    * `LOG_CHANNEL=stderr`    
    * `DB_CONNECTION=mysql`
    * `DB_HOST=mysql`
    * `DB_PORT=3306`
    * `DB_DATABASE=bootcamp_project`
    * `DB_USERNAME=dbuser`
    * `DB_PASSWORD=dbpass`