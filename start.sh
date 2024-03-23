#!/usr/bin/env bash
rm .env
if [ ! -f .env ]; then
    touch .env
    echo LOCAL_IP=0.0.0.0 >> .env
    echo MYSQL_PORT=3307 >> .env
    echo MYSQL_ROOT_PASSWORD=root >> .env
    echo MYSQL_USER=root >> .env
    echo MYSQL_DB=roomvu >> .env
fi

docker-compose build
docker-compose up -d
docker-compose exec worker composer install
docker-compose down
docker-compose up -d