# Hostinger VPS Migration — Patrik Solutions

Migrate **patriksolutions.com** from the current HestiaCP host (`gekymedia.com`) to a new Hostinger VPS.

## Current production

| Item | Value |
|------|-------|
| Live URL | https://patriksolutions.com |
| Old server | `root@gekymedia.com` |
| Old path | `/home/gekymedia/web/patriksolutions.com/public_html` |
| Stack | Laravel 11, PHP 8.2+, Vite/Tailwind, MySQL, queues |
| Deploy | `deploy.ps1` (SSH) + GitHub Actions `Deploy to VPS` |

## Target (Hostinger VPS)

Recommended layout (HestiaCP on Hostinger — keeps paths familiar):

| Item | Value |
|------|-------|
| SSH | `root@<HOSTINGER_VPS_IP>` |
| Site path | `/home/<user>/web/patriksolutions.com/public_html` |
| PHP | 8.3 |
| Node | 20 LTS |
| DB | MySQL 8 |
| SSL | Let's Encrypt via panel or Certbot |

If you skip Hestia and use a plain LEMP install, default path becomes:

```text
/var/www/patriksolutions.com
```

Set `DEPLOY_PATH` / `VPS_*` secrets to match whichever layout you choose.

## What you must provide before cutover

1. **Hostinger VPS IP** (and optional hostname)
2. **Root (or sudo) SSH access** — password or private key
3. **Panel choice**: HestiaCP (recommended) or bare Ubuntu LEMP
4. **System user / site path** if not using default Hestia layout
5. **DNS access** for `patriksolutions.com` (and `www`) A/AAAA records
6. Confirmation that **MySQL dumps** and **`storage/`** can be copied from the old server

## Migration phases

### Phase 1 — Provision the VPS

On a fresh Ubuntu 22.04/24.04 Hostinger VPS:

```bash
# Upload and run (as root)
bash deploy/hostinger/bootstrap-vps.sh
```

Then either:

- **Option A (Hestia):** install HestiaCP, create user + domain `patriksolutions.com`, point document root at `public/`
- **Option B (LEMP):** run `bash deploy/hostinger/provision-site.sh patriksolutions.com`

### Phase 2 — Deploy application code

```bash
# From your PC (after setting env vars — see deploy.ps1)
$env:VPS_HOST = "<HOSTINGER_VPS_IP>"
$env:VPS_USER = "root"
$env:DEPLOY_PATH = "/home/<user>/web/patriksolutions.com/public_html"
.\deploy\hostinger\setup-site.ps1
```

Or manually on the VPS:

```bash
cd /path/to/site
git clone https://github.com/gekymedia/patriksolutions.git .
composer install --no-dev --optimize-autoloader
cp .env.example .env   # then paste production values
php artisan key:generate   # only if starting fresh; prefer old APP_KEY
npm ci && npm run build
```

### Phase 3 — Copy data from old server

On the **old** server (`gekymedia.com`):

```bash
# Database
mysqldump -u USER -p DATABASE > /tmp/patriksolutions.sql

# Uploads / app storage (exclude caches)
cd /home/gekymedia/web/patriksolutions.com/public_html
tar czf /tmp/patriksolutions-storage.tar.gz storage/app storage/logs
```

Copy to Hostinger and restore:

```bash
scp root@gekymedia.com:/tmp/patriksolutions.sql /tmp/
scp root@gekymedia.com:/tmp/patriksolutions-storage.tar.gz /tmp/

mysql -u USER -p NEW_DATABASE < /tmp/patriksolutions.sql
cd /path/to/site
tar xzf /tmp/patriksolutions-storage.tar.gz
php artisan storage:link
# Fix ownership for web user (Hestia example):
chown -R USER:USER storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

Copy the production `.env` from the old server and update:

- `APP_URL=https://patriksolutions.com`
- `DB_*` for the new MySQL instance
- Keep the same `APP_KEY` so encrypted data / sessions stay valid

### Phase 4 — Cron, queue, SSL

```cron
* * * * * cd /path/to/site && php artisan schedule:run >> /dev/null 2>&1
```

Queue worker (systemd or supervisor), e.g.:

```ini
[program:patriksolutions-worker]
command=php /path/to/site/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
```

Issue SSL (Hestia UI or Certbot) before flipping DNS.

### Phase 5 — DNS cutover

1. Lower TTL on `patriksolutions.com` A/AAAA (e.g. 300s) a day ahead if possible
2. Point A (and AAAA) to the Hostinger VPS IP
3. Verify: `curl -I https://patriksolutions.com`
4. Smoke-test login, Stripe (if used), and file uploads
5. Keep old server read-only / powered for 48–72h as rollback

### Phase 6 — Update deploy tooling & CI secrets

GitHub Actions secrets for this repo:

| Secret | Description |
|--------|-------------|
| `VPS_HOST` | Hostinger VPS IP or hostname |
| `VPS_USERNAME` | SSH user (often `root`) |
| `VPS_SSH_KEY` | Private key for deploy |
| `DEPLOY_PATH` | Absolute path to the app root |

Local PowerShell deploy:

```powershell
$env:VPS_HOST = "<HOSTINGER_VPS_IP>"
$env:VPS_USER = "root"
$env:DEPLOY_PATH = "/home/<user>/web/patriksolutions.com/public_html"
.\deploy.ps1
```

## Rollback

1. Point DNS A/AAAA back to the old `gekymedia.com` IP
2. Do **not** run migrations on the old DB after cutover unless you also reverse-sync data

## Checklist

- [ ] Hostinger VPS reachable over SSH
- [ ] PHP 8.3 + extensions, Composer, Node 20, MySQL, Redis (optional), Nginx/Apache
- [ ] Site provisioned and document root → `public/`
- [ ] Code cloned / deployed
- [ ] DB imported
- [ ] `storage/` restored + `storage:link`
- [ ] `.env` production values + same `APP_KEY`
- [ ] SSL active
- [ ] Scheduler + queue worker running
- [ ] DNS updated
- [ ] CI secrets + `deploy.ps1` env updated
- [ ] Old server retained briefly for rollback
