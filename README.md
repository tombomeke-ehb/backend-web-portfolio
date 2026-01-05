# Backend Web Portfolio (Laravel)

Laravel portfolio project for Backend Web.

## Requirements

- **PHP 8.3+** (project currently tested on PHP 8.4.x)
- **Composer** (PHP package manager)
- A database (MySQL/MariaDB/PostgreSQL/SQLite)

### Installing PHP & Composer (if not installed)

**Option A: Use Laravel Herd (recommended for Windows/Mac)**
- Download from https://herd.laravel.com
- Herd installs PHP + Composer automatically and adds them to PATH

**Option B: Manual installation**
- PHP: https://windows.php.net/download (Windows) or `brew install php` (Mac)
- Composer: https://getcomposer.org/download/

**Verify installation:**
```bash
php -v        # Should show PHP 8.3+
composer -V   # Should show Composer version
```

## Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd backend-web-portfolio
   ```

2. **Install PHP dependencies** (creates the `vendor/` folder)
   ```bash
   composer install
   ```
   > ⚠️ This step is REQUIRED. Without it, nothing works!

3. **Create your `.env` file**
   ```bash
   cp .env.example .env
   ```
   > Do NOT copy `.env` from another machine - paths may differ!

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Configure database** in `.env` (see "Quick Start .env" below for copy-paste config)

6. **Run migrations + seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Create storage symlink** (for uploaded images)
   ```bash
   php artisan storage:link
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```
   Then open http://localhost:8000 in your browser.

## Quick Start .env (for teachers/evaluators)

After copying `.env.example` to `.env`, the default configuration uses **SQLite** which requires no database server. The SQLite database file is **created automatically** when you run migrations.

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

> ✅ No need to manually create `database.sqlite` - it's created automatically!

If you prefer **MySQL**, edit your `.env` and change:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=root
DB_PASSWORD=
```

**Mail configuration:** The default `.env.example` uses `MAIL_MAILER=log` which writes emails to `storage/logs/laravel.log` instead of sending them. This is fine for testing password reset functionality - just check the log file for the reset link.

## Default admin (required by assignment)

- **Username:** `admin`
- **Email:** `admin@ehb.be`
- **Password:** `Password!321`

After seeding you can log in and access the admin panel.

- Admin panel: `/admin`

## Features

Minimum requirements:
- Authentication (login/register/password reset)
- Roles: user/admin and admin user management
- Public profile pages: `/u/{username}`
- News module (public list/detail + admin CRUD)
- FAQ module (public + admin CRUD)
- Contact form (public) + admin inbox

Extra features:
- Admin replies to contact messages
- News comments + admin moderation
- Tags (many-to-many) for news items
- Site settings (maintenance mode + feature toggles)
- User skills shown on public profiles

## Notes for evaluation (migrate:fresh --seed)

The teacher can run:
- `php artisan migrate:fresh --seed`

All required tables are created via migrations.
Seeders populate:
- default admin user
- sample news + FAQ
- sample contact messages
- sample comments
- sample users with skills

## Mail / password reset testing

Password reset uses Laravel's standard flow (forgot-password → email link → reset).

For local testing without sending real emails:
- set `MAIL_MAILER=log`
- submit a password reset request
- check `storage/logs/laravel.log` for the reset email/link

To send real emails, configure SMTP in `.env` (provider-specific).

## Queue

This project can run with `QUEUE_CONNECTION=sync` for simple local testing.
If you use `QUEUE_CONNECTION=database`, run a worker:
- `php artisan queue:work`

## Troubleshooting

### "composer is not recognized" / "php is not recognized"
PHP and/or Composer are not installed or not in your PATH.
- Install Laravel Herd (recommended): https://herd.laravel.com
- Or install PHP + Composer manually (see Requirements section above)

### "ext-fileinfo is missing" during composer install
Your PHP installation is missing the `fileinfo` extension.

**Solution A (recommended):** Enable the extension in php.ini:
1. Open `C:\Program Files\php\php.ini` (or wherever your php.ini is located)
2. Find the line `;extension=fileinfo`
3. Remove the `;` to uncomment it: `extension=fileinfo`
4. Save and retry `composer install`

**Solution B (quick workaround):**
```bash
composer install --ignore-platform-req=ext-fileinfo
```

### "Failed to open stream: No such file or directory ... vendor/autoload.php"
The `vendor/` folder is missing. This happens when:
- You cloned the repo but didn't run `composer install`
- You copied the project without the vendor folder

**Solution:** Run `composer install` first (requires Composer to be installed).

### "Database file at path ... database.sqlite does not exist"
This should be auto-created, but if not:

**Solution (PowerShell):**
```powershell
New-Item -Path database\database.sqlite -ItemType File
```

**Solution (Mac/Linux):**
```bash
touch database/database.sqlite
```

Then run `php artisan migrate:fresh --seed`.

### Images not showing after upload
Run: `php artisan storage:link`

### Changed `.env` but app still uses old values
Run: `php artisan config:clear`

### Database connection errors
- Check your `.env` database settings (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
- For quick local testing, use SQLite (no server needed):
  ```
  DB_CONNECTION=sqlite
  ```
- Make sure you created `database/database.sqlite` if using SQLite

## Sources / references

- Original portfolio/codebase inspiration/source (original site):
  - https://tombomeke.com
  - Used as the starting point for the portfolio layout/content and initial structure.

- Laravel documentation (auth, mail, validation, routing, middleware, Eloquent):
  - https://laravel.com/docs

- Laravel password reset:
  - https://laravel.com/docs/passwords

- MDN Web Docs (client-side form validation patterns, constraint validation API):
  - https://developer.mozilla.org/en-US/docs/Learn/Forms/Form_validation

- Laravel Breeze (starter kit used as base for authentication scaffolding):
  - https://github.com/laravel/breeze

- This project was extended/modified with help from **GitHub Copilot** for refactors, UI polish, and validation helpers.

## License

Educational project.
