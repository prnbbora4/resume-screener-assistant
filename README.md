# Resume Screener Assistant

A Laravel 13 application for comparing candidate resumes with job descriptions and producing structured, AI-assisted screening reports.

## Requirements

- PHP 8.3 or later
- Composer
- Node.js and npm
- SQLite with PDO SQLite enabled
- An OpenAI API key for analysis

## Local setup

```powershell
composer install
if (-not (Test-Path .env)) { Copy-Item .env.example .env }
php artisan key:generate
if (-not (Test-Path database/database.sqlite)) { New-Item -ItemType File database/database.sqlite }
php artisan migrate
npm install
npm run build
```

Set `OPENAI_API_KEY` in `.env`. The model, API base URL, and request timeout can be configured with `OPENAI_MODEL`, `OPENAI_BASE_URL`, and `OPENAI_TIMEOUT`. Do not put API keys in frontend code or commit them.

Start the application and a queue worker in separate terminals:

```powershell
php artisan serve
php artisan queue:work --tries=3 --timeout=60
```

Resume/job text is carried only in an encrypted queue payload while a job is pending. The payload is deleted after processing; failed-job payload storage is disabled by default. Completed analyses retain the candidate name and structured report, not the source documents. Use HTTPS in any deployment.

## Tests and production assets

```powershell
php artisan test
npm run build
```

Before deploying, configure a unique `APP_KEY`, set `APP_ENV=production` and `APP_DEBUG=false`, use HTTPS, run `php artisan migrate --force`, and keep a supervised queue worker running. Configure an appropriate production database, cache, backups, monitoring, and log retention for the hosting environment.

## Access and candidate privacy

This assessment build has public access by design: dashboard, history, and reports do not require login. Do not expose it to the public internet with real candidate data until access control, retention, privacy notice, and applicable employment/AI compliance requirements have been reviewed. The analysis submission route is rate-limited, and AI output is validated before it is saved.
