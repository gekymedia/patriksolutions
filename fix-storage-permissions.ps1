# Fix storage/framework/views (and related) permission denied on server
# Run from your machine. SSHs to server and sets ownership so PHP can write to storage & bootstrap/cache.
# Hestia: web user is typically the system user (gekymedia).

$remoteCmd = 'cd /home/gekymedia/web/patriksolutions.com/public_html && chown -R gekymedia:gekymedia storage bootstrap/cache && chmod -R 775 storage bootstrap/cache && echo "Done. storage and bootstrap/cache are now writable by the web user."'

Write-Host "Fixing storage/bootstrap permissions on server..." -ForegroundColor Cyan
ssh root@gekymedia.com $remoteCmd
Write-Host "Done." -ForegroundColor Green
