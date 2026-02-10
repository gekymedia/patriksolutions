# Generate and set APP_KEY on production server (fixes MissingAppKeyException)
# Run once from your machine. SSHs to server and runs: php artisan key:generate --force

$remoteCmd = 'cd /home/gekymedia/web/patriksolutions.com/public_html && php artisan key:generate --force && echo "APP_KEY has been set in .env"'

Write-Host "Setting application encryption key on server..." -ForegroundColor Cyan
ssh root@gekymedia.com $remoteCmd
Write-Host "Done. Reload the site." -ForegroundColor Green
