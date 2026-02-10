# One-time: Set up Git on patriksolutions.com server
# Run this from your machine (PowerShell). It SSHs to the server and clones the repo.
# Server: root@gekymedia.com
# Repo: https://github.com/gekymedia/patriksolutions.git

$remoteSetup = 'set -e; SITE_ROOT="/home/gekymedia/web/patriksolutions.com"; PUBLIC="$SITE_ROOT/public_html"; REPO="https://github.com/gekymedia/patriksolutions.git"; echo "=== Patriksolutions server git setup ==="; cd "$SITE_ROOT" || exit 1; if [ -d "$PUBLIC/.git" ]; then echo "Already a git repo. Run deploy.ps1 to pull."; exit 0; fi; if [ -d "$PUBLIC" ]; then echo "Backing up existing public_html..."; mv "$PUBLIC" "$PUBLIC.bak.$(date +%Y%m%d)"; fi; echo "Cloning repo..."; git clone "$REPO" public_html; cd public_html; composer install --no-dev --optimize-autoloader; [ -f .env ] || cp .env.example .env 2>/dev/null || true; echo "Done. Edit .env on server if needed, then: php artisan migrate --force"'

Write-Host "Running one-time git setup on server (patriksolutions.com)..." -ForegroundColor Cyan
ssh root@gekymedia.com $remoteSetup
Write-Host "Server setup finished." -ForegroundColor Green
