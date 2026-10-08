# Deploying to Hostinger (`public_html`)

Target: https://lightpink-eel-758416.hostingersite.com
The whole project goes into `public_html`. The root `.htaccess` sends every
request into `public/` and blocks direct access to `.env`, `vendor/`, `storage/`
and the rest of the tree.

## 1. hPanel settings

1. **PHP version**: Websites → Dashboard → PHP configuration → select **8.3** or **8.4**.
   Make sure `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `fileinfo`, `gd` are enabled (they are by default).
2. **MySQL database**: Databases → Management → create a database and user. Note the
   name, user and password (they look like `u123456789_rachel`).
3. **Email** (for new-lead alerts): Emails → create a mailbox, e.g. `leads@…`, or use an
   external SMTP such as Resend/Mailgun. Note the SMTP host, port, user and password.
4. **SSL**: Security → SSL → make sure the certificate is active for the domain (it is
   automatic on `hostingersite.com` addresses).

## 2. Build locally

```sh
npm run build                       # refreshes public/build (committed, so git deploys carry it)
composer install --no-dev --optimize-autoloader
```

If you deploy by zip/FTP, upload everything **except** `node_modules/`, `.git/`,
`database/database.sqlite`, `tests/` and your local `.env`.
If you deploy with Hostinger's Git integration, point it at this repo's branch and set the
install path to `public_html`; then run `composer install --no-dev` over SSH.

## 3. Configure on the server

Copy `.env.hostinger.example` to `public_html/.env` (File Manager or SSH) and fill in:

| Key | Value |
| --- | --- |
| `APP_KEY` | run `php artisan key:generate` over SSH, or paste one generated locally |
| `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` | from step 1.2 |
| `MAIL_HOST` / `MAIL_PORT` / `MAIL_USERNAME` / `MAIL_PASSWORD` / `MAIL_FROM_ADDRESS` | from step 1.3 |

Leave `APP_DEBUG=false`, `APP_ENV=production` and `QUEUE_CONNECTION=sync`. Shared hosting
has no queue worker, so `sync` sends the lead email during the form submit.

## 4. Run once over SSH (`cd public_html`)

```sh
php artisan key:generate --force      # only if APP_KEY is still empty
php artisan migrate --force           # creates the tables in MySQL
php artisan site:admin                # creates Rachel's login (prompts for a password)
php artisan storage:link              # optional, not used by the site today
php artisan config:cache && php artisan route:cache && php artisan view:cache
chmod -R ug+rwx storage bootstrap/cache
```

**Do not run `php artisan db:seed` on the live site.** It inserts 28 fake leads and a
month of fake page views.

If the plan has no SSH, generate `APP_KEY` locally with `php artisan key:generate --show`,
paste it into `.env`, and run the migrations + `site:admin` via hPanel's terminal, or
temporarily deploy with the SQLite driver and switch later.

## 5. Check

- https://lightpink-eel-758416.hostingersite.com/ loads with styles and fonts.
- https://lightpink-eel-758416.hostingersite.com/.env returns **403**, not the file.
- https://lightpink-eel-758416.hostingersite.com/up returns `OK`.
- Submit the contact form; the lead appears at `/admin/leads` and an email arrives.
- `/sitemap.xml` and `/robots.txt` show the live domain, not localhost.

## After every code change

```sh
npm run build          # locally, then upload / push
php artisan config:cache && php artisan route:cache && php artisan view:cache   # on the server
```

Any change to `.env` needs `php artisan config:cache` again, or the old values stay cached.
