#!/bin/bash

cp docker-compose-dist.yml docker-compose.yml
docker network create urlshortener-bridge
docker-compose up -d --build

printf '\nBUILDING FRONTEND APP\n'
cat <<frontend | docker exec --interactive urlshortener_nginx bash
    cd /app
    npm install
    cp .env.dist .env.production.local
    npm run build
    cp -r /app/build /var/www/html
frontend

printf '\nBUILDING BACKEND APP\n'
cat <<backend | docker exec --interactive urlshortener_php bash
    composer install
backend
