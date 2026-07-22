# Ehsan Electronics

Pakistan electronics store — Laravel 12 + Blade + Tailwind.

## Local
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

## Live deploy
See [DEPLOY.md](DEPLOY.md) — **Railway** (not Vercel; this is Laravel PHP).

GitHub: push this repo, then Railway → Deploy from GitHub + MySQL.
