## Usage

To get started, make sure you have [Docker installed](https://docs.docker.com/docker-for-mac/install/) on your system, and then clone this repository.

Next, navigate in your terminal to the directory you cloned this, and spin up the containers for the web server by running `docker-compose up -d --build site`.

- **nginx** - `:81`
- **mysql** - `:3307`
- **php** - `:9000`




## Setup

## Write Permission for logs folder
Run the below commands from the  `project_folder/src`  of the project using CLI

`chmod -R 777 storage/`

## .env Copy
Run the below commands from the `project_folder/src`  of the project using CLI

`cp .env.example .env`

## Migrate the DB schema and Seed the tables

Run the below commands from `project_folder/src`

`docker-compose run --rm artisan migrate` 

`docker-compose run --rm artisan db:seed` 

## Users Available


users are `john`, `jane`, `ronald`,`sam`,`susie`

All users default password is  `123456`

## Access URL

[API Documentation](http://localhost:81/api/documentation)

Database can be access using the below link

[DataBase](http://localhost:81/index.html)

Host : mysql
DB   : splitwise
User : root
Pass : root

Generate Documentation From code base

`docker-compose run --rm artisan swagger-lume:generate`

## PHPUnit Test

`docker-compose run --rm php vendor/bin/phpunit`

## Front End

Front end of the appliation is not developed  , but the API documentation is done with Swagger Package, so you can try out all from that.

## Access The CLI

docker ps

docker exec -it <redis container ID> redis-cli 

## MYSQL Access 

docker exec -it <postgres container ID> bash
root@containerID:/# mysql -u root -p

## Technology stack

PHP - 8.1.4 ([Lumen Framework](https://lumen.laravel.com/docs/9.x)),
MySQL - 5.7.9



