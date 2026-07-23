# Fix live email on Railway (Hobby blocks Gmail SMTP)

Railway **Hobby/Free** blocks outbound SMTP (`smtp.gmail.com:587` times out ~60s).
Local Gmail App Password works on your PC — it will **not** work on Railway unless you upgrade to **Pro**.

## Recommended: Resend (free HTTPS API)

1. Sign up: https://resend.com (use your store Gmail)
2. Create an API key
3. Railway → web service → Variables:

```env
MAIL_MAILER=resend-api
RESEND_API_KEY=re_xxxxxxxx
MAIL_FROM_ADDRESS=Ehsan Electronics <onboarding@resend.dev>
MAIL_FROM_NAME=Ehsan Electronics
MAIL_TIMEOUT=15
```

4. Redeploy (or wait for auto-deploy)
5. Test:

```bash
railway run php artisan mail:test youremail@gmail.com
```

> Note: `railway run` injects env **locally**. Prefer a one-off order on the live site, or SSH into the service.
> With `onboarding@resend.dev`, Resend only delivers to **your Resend account email** until you verify a domain.

6. For customer emails to any address: verify your domain in Resend, then set `MAIL_FROM_ADDRESS` to e.g. `orders@yourdomain.com`.

## Alternative: Railway Pro + Gmail SMTP

Upgrade to Pro → redeploy → keep:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...app-password...
```
