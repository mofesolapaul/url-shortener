#!/bin/bash

cp docker-compose-dist.yml docker-compose.yml
docker network create urlshortener-bridge
docker-compose up -d --build

printf '\nBUILDING FRONTEND APP\n'
cat <<frontend | docker exec --interactive urlshortener_nginx bash
frontend

printf '\nBUILDING BACKEND APP\n'
cat <<backend | docker exec --interactive urlshortener_php bash
backend
