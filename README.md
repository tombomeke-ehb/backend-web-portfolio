# Backend Web Portfolio (Laravel)

Laravel portfolio project for Backend Web.

## Requirements

- PHP 8.3+ (project currently tested on PHP 8.4.x)
- Composer
- A database (MySQL/MariaDB/PostgreSQL/SQLite)

## Setup

1. Clone the repository
2. Install dependencies
   - `composer install`
3. Create your `.env`
   - copy `.env.example` -> `.env`
   - set `APP_KEY`:
     - `php artisan key:generate`
4. Configure database connection in `.env`
5. Run migrations + seeders
   - `php artisan migrate:fresh --seed`
6. Storage symlink (for uploaded images)
   - `php artisan storage:link`
7. Start the server
   - `php artisan serve`

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

- Images not showing after upload: run `php artisan storage:link`
- Changed `.env` but app still uses old values: run `php artisan config:clear`

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
