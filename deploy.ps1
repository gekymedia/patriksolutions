# Patriksolutions.com Production Deployment Script (PowerShell)
# Live site: https://patriksolutions.com
#
# Defaults still target the legacy Hestia host. For Hostinger, set:
#   $env:VPS_HOST = "<HOSTINGER_IP>"
#   $env:VPS_USER = "root"
#   $env:DEPLOY_PATH = "/var/www/patriksolutions.com"
#     or Hestia: "/home/<user>/web/patriksolutions.com/public_html"
# See docs/HOSTINGER_VPS_MIGRATION.md

$ErrorActionPreference = "Stop"

$VpsHost = if ($env:VPS_HOST) { $env:VPS_HOST } else { "gekymedia.com" }
$VpsUser = if ($env:VPS_USER) { $env:VPS_USER } else { "root" }
$DeployPath = if ($env:DEPLOY_PATH) { $env:DEPLOY_PATH } else { "/home/gekymedia/web/patriksolutions.com/public_html" }
$WebUser = if ($env:WEB_USER) { $env:WEB_USER } else { "gekymedia" }

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

Write-Host "Deploying to ${VpsUser}@${VpsHost}:${DeployPath}..." -ForegroundColor Cyan
$remoteCmd = "cd '${DeployPath}' && git pull origin main && chown -R ${WebUser}:${WebUser} storage bootstrap/cache && chmod -R 775 storage bootstrap/cache && composer install --no-dev --optimize-autoloader && php artisan migrate --force && php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan optimize && php artisan queue:restart"
ssh "${VpsUser}@${VpsHost}" $remoteCmd
if ($LASTEXITCODE -ne 0) { Write-Host "Remote deploy failed." -ForegroundColor Red; exit 1 }
Write-Host "Deploy complete." -ForegroundColor Green
