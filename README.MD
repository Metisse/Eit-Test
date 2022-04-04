
# EIT-TEST

## Getting started

Get started with Docker
,we need Database 

```bash
docker pull mariadb:10.6.4
docker run --name eit-mariadb -p 3366:3306 -e MARIADB_ROOT_PASSWORD=mypass123 -d mariadb:10.6.4
```
```bash
docker pull phpmyadmin/phpmyadmin:latest
docker run --name eit-phpmyadmin -d --link eit-mariadb:db -p 8081:80 phpmyadmin/phpmyadmin
```


## Start projet 

Install vendor 
```bash
composer install
```
Create DB
```bash
php bin/console doctrine:database:create
```
Initialise the fixtures
```bash
php bin/console doctrine:fixtures:load
```
Start the server
```bash
symfony serve:start
```

## Run the projet

http://localhost:8000/contact