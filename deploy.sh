#!/bin/bash
set -e

echo "Déploiement du site portfolio..."

# 1. Pull les derniers changements
git pull origin main

# 2. Build et restart Docker
docker compose build --no-cache app
docker compose up -d

# 3. Migrations
docker compose exec app php artisan migrate --force

# 4. Cache de production
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
docker compose exec app php artisan event:cache

# 5. Storage link
docker compose exec app php artisan storage:link

# 6. Permissions
docker compose exec app chown -R www-data:www-data storage bootstrap/cache

echo "Déploiement terminé !"
echo "Site accessible sur le port 8080"