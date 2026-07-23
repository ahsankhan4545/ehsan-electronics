# Ehsan Electronics — Live Deploy

Marketplace (`ehsani-marketplace`) **Next.js** thi → **Vercel** perfect tha.

Yeh store **Laravel (PHP)** hai → Vercel recommended nahi.
Asan cloud option: **Railway** (free trial / hobby) ya **Render**.

**Live goal:** `https://your-app.up.railway.app` (ya custom domain)

---

## Option A — Railway (recommended)

### 1) GitHub pe project dalo
Pehle ye folder permanent jagah pe rakho (temp Cursor path mat use karo), phir:

```powershell
cd C:\Users\Ehsani\ehsan-electronics
git init
git add .
git commit -m "Ehsan Electronics store"
```

GitHub pe naya repo banao → push:

```powershell
git remote add origin https://github.com/YOUR_USERNAME/ehsan-electronics.git
git branch -M main
git push -u origin main
```

### 2) Railway pe deploy
1. https://railway.app → Login (GitHub se)
2. **New Project** → **Deploy from GitHub repo**
3. Repo select karo
4. **Add Database** → **MySQL** (ya PostgreSQL)
5. Service → **Variables** mein ye set karo:

```env
APP_NAME="Ehsan Electronics"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GENERATE_WITH_php_artisan_key_generate
APP_URL=https://YOUR-APP.up.railway.app

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=yourgmail@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=yourgmail@gmail.com
MAIL_FROM_NAME="Ehsan Electronics"

PAYMENT_BANK_ENABLED=false
PAYMENT_BANK_NAME="HBL"
PAYMENT_BANK_ACCOUNT_TITLE="Ehsan Electronics"
PAYMENT_BANK_ACCOUNT_NUMBER="..."
PAYMENT_BANK_IBAN="..."

PAYMENT_EASYPAISA_ENABLED=true
PAYMENT_EASYPAISA_TITLE="Ehsan Electronics"
PAYMENT_EASYPAISA_NUMBER="03XXXXXXXXX"
```

> Railway MySQL variables ke exact names dashboard pe dikhte hain — unhe link karo.

### 3) Build / start
Is repo mein `Dockerfile` aur `railway.toml` pehle se hain.
Deploy ke baad shell / one-off command:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

### 4) Public URL
Railway → Settings → Networking → **Generate Domain**

---

## Option B — Vercel? (marketplace jaisa)

**Short answer: mat karo is Laravel store ke liye.**

Marketplace Next.js + Prisma thi.  
Laravel ko Vercel pe chalane ke liye heavy hacks chahiye (sessions, DB, queues, file storage — mushkil).

Agar zaroori Vercel hi chahiye to store ko Next.js mein rewrite karna parega (bada kaam).

---

## Local se permanent folder (pehle ye karo)

```powershell
robocopy "C:\Users\Ehsani\.cursor\projects\C-Users-Ehsani-AppData-Local-Temp-a9d018af-e485-410f-9b99-82d37f7058f7\ecommerce-store" "C:\Users\Ehsani\ehsan-electronics" /E /XD node_modules vendor .git /NFL /NDL /NJH /NJS
cd C:\Users\Ehsani\ehsan-electronics
composer install
npm install
npm run build
```

---

## Accounts chahiye
1. GitHub account  
2. Railway account (GitHub login)  
3. Gmail App Password (email ke liye — pehle se hai)

Batao: GitHub username hai? Main next step (repo + Railway files finalize / push guide) abhi complete kar doon.
