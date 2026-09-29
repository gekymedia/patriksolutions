# One-time: Set up Git on patriksolutions.com server (legacy Hestia layout).
# For a new Hostinger VPS, prefer: .\deploy\hostinger\setup-site.ps1
# See docs/HOSTINGER_VPS_MIGRATION.md
#
# Override target with:
#   $env:VPS_HOST / $env:VPS_USER / $env:DEPLOY_PATH

$ErrorActionPreference = "Stop"
$VpsHost = if ($env:VPS_HOST) { $env:VPS_HOST } else { "gekymedia.com" }
$VpsUser = if ($env:VPS_USER) { $env:VPS_USER } else { "root" }
$SiteRoot = if ($env:SITE_ROOT) { $env:SITE_ROOT } else { "/home/gekymedia/web/patriksolutions.com" }

$remoteSetup = "set -e; SITE_ROOT='${SiteRoot}'; PUBLIC=`"`$SITE_ROOT/public_html`"; REPO='https://github.com/gekymedia/patriksolutions.git'; echo '=== Patriksolutions server git setup ==='; cd `"`$SITE_ROOT`" || exit 1; if [ -d `"`$PUBLIC/.git`" ]; then echo 'Already a git repo. Run deploy.ps1 to pull.'; exit 0; fi; if [ -d `"`$PUBLIC`" ]; then echo 'Backing up existing public_html...'; mv `"`$PUBLIC`" `"`$PUBLIC.bak.`$(date +%Y%m%d)`"; fi; echo 'Cloning repo...'; git clone `"`$REPO`" public_html; cd public_html; composer install --no-dev --optimize-autoloader; [ -f .env ] || cp .env.example .env 2>/dev/null || true; echo 'Done. Edit .env on server if needed, then: php artisan migrate --force'"

Write-Host "Running one-time git setup on ${VpsUser}@${VpsHost} (patriksolutions.com)..." -ForegroundColor Cyan
ssh "${VpsUser}@${VpsHost}" $remoteSetup
Write-Host "Server setup finished." -ForegroundColor Green
