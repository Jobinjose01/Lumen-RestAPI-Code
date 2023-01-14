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

`admin` is the admin user.

Normal users are `john`, `jane`, `ronald`,`sam`,`susie`

All users default password is  `123456`

## Access URL

[http://localhost:81/index.html](http://localhost:81/index.html)

Database can be access using the below link

[http://localhost:81/db.php](http://localhost:81/index.html)

Host : mysql
DB   : ticket_reservation
User : root
Pass : root

If you want to change the port that is running on docker feel free to change that in the docker yml file , remember to change the `.env` CROSS_ORIGIN param accordingly.

Login with admin details and create the trips , 10 cities already seeded so it can be available in the admin login.

## Front End

Front end of the application is built with `Angular` the source code can be found in the `front_end` folder.

## Access The CLI

docker ps

docker exec -it <redis container ID> redis-cli 

## MYSQL Access 

docker exec -it <postgres container ID> bash
root@containerID:/# mysql -u root -p

## Technology stack

PHP - 8.1.4 ([Lumen Framework](https://lumen.laravel.com/docs/9.x)),
Angular - 12.1.1,
MySQL - 5.7.9



