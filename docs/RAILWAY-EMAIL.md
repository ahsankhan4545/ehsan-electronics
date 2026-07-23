# Fix live email on Railway (Hobby blocks Gmail SMTP)

Railway **Hobby/Free** blocks outbound SMTP (`smtp.gmail.com:587` times out ~30–60s).
That timeout also made **checkout feel stuck**, because this app runs `php artisan serve`
(which does **not** flush the HTTP response before mail runs).

Checkout is now **queued** (instant redirect). Email still needs a working **HTTPS** mailer.

## Required Railway variables (checkout speed)

Set these **now** so order place stays fast even if mail is misconfigured:

```env
MAIL_MAILER=log
MAIL_TIMEOUT=3
```

`log` = checkout instant, email written to Railway logs (not inbox).

## Real inbox email: Resend (HTTPS API)

Gmail SMTP will **not** work on Hobby. Do **not** set `MAIL_MAILER=smtp`.

1. Sign up: https://resend.com (use your store Gmail)
2. Create an API key (`re_...`)
3. Railway → **web** service → **Variables** — set:

```env
MAIL_MAILER=resend-api
RESEND_API_KEY=re_xxxxxxxx
MAIL_FROM_ADDRESS=onboarding@resend.dev
MAIL_FROM_NAME=Ehsan Electronics
MAIL_TIMEOUT=8
```

4. Redeploy (or wait for auto-deploy)
5. Test on Railway:

```bash
railway run php artisan mail:test youremail@gmail.com
```

Or place a test order on the live site and watch queue/worker logs.

### Resend FROM limitations

- `onboarding@resend.dev` only delivers to **your Resend account email** until you verify a domain.
- For customer emails to any address: verify a domain in Resend, then set e.g.  
  `MAIL_FROM_ADDRESS=orders@yourdomain.com`

## Do NOT use on Railway Hobby

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
```

Local Gmail App Password is fine on your PC only. On Hobby it hangs and can slow/break mail delivery.

## Alternative: Railway Pro + Gmail SMTP

Upgrade to **Pro** (SMTP allowed), then you may use Gmail SMTP again. Prefer Resend even then.
