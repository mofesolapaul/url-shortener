#!/bin/bash

cp docker-compose-dist.yml docker-compose.yml
docker network create urlshortener-bridge
docker-compose up -d --build

printf '\nBUILDING FRONTEND APP\n'
cat <<frontend | docker exec --interactive urlshortener_nginx bash
    cd /app
    npm install
    npm test -- --watchAll=false
    cp .env.dist .env.production.local
    npm run build
    cp -a /app/build/. /var/www/html
frontend

printf '\nBUILDING BACKEND APP\n'
cat <<backend | docker exec --interactive urlshortener_php bash
    composer dump-env prod
    composer install --prefer-dist --no-dev --optimize-autoloader
    APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
    ./bin/console --no-interaction doctrine:migrations:migrate
    screen -S messenger -d -m ./bin/console messenger:consume async
backend
