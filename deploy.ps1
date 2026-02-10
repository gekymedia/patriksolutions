# Patriksolutions.com Production Deployment Script (PowerShell)
# Live site: https://patriksolutions.com
# Server: gekymedia.com
# Path: /home/gekymedia/web/patriksolutions.com/public_html

Write-Host "Building frontend assets (Vite)..." -ForegroundColor Cyan
npm ci
npm run build
if ($LASTEXITCODE -ne 0) { throw "Vite build failed" }

Write-Host "Committing and pushing local changes..." -ForegroundColor Cyan
git add .
git add -f public/build
git commit -m "Deploy: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"
if ($LASTEXITCODE -ne 0) { Write-Host "No changes to commit" -ForegroundColor Yellow }
git push origin main

Write-Host "Deploying to production (patriksolutions.com)..." -ForegroundColor Cyan
$remoteCmd = 'cd /home/gekymedia/web/patriksolutions.com/public_html && git pull origin main && chown -R gekymedia:gekymedia storage bootstrap/cache && chmod -R 775 storage bootstrap/cache && composer install --no-dev --optimize-autoloader && php artisan migrate --force && php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan optimize && php artisan queue:restart'
ssh root@gekymedia.com $remoteCmd
