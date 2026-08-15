# Banking Engine — Laravel Rebuild

Codebase target: Laravel 13 + Filament 5 + Livewire 4 + Supabase PostgreSQL.

## Status
- Existing Supabase banking schema retained.
- Laravel-owned auth schema (`laravel.users`, sessions, reset tokens) already exists in Supabase.
- Public calculator renderer included.
- Dynamic field and formula model included.
- Formula evaluation uses Symfony ExpressionLanguage, not `eval()`.
- Filament V5 resource structure included for Segments, Calculators, Parameters, and Regulations.
- Audit trigger in Supabase has been upgraded to read Laravel actor UUID from `app.user_id`, while retaining Supabase Auth fallback.

## Bootstrap in a normal development machine
1. Create a fresh Laravel 13 skeleton, or run `composer install` in this repository once full Laravel framework scaffold files are present.
2. Copy `.env.example` to `.env` and fill `DB_PASSWORD` from Supabase database credentials.
3. `php artisan key:generate`
4. Register `App\\Providers\\Filament\\AdminPanelProvider` if package discovery/scaffold does not do so automatically.
5. `php artisan migrate` for Laravel framework tables that you choose to keep in the `laravel` schema.
6. Create the first user in `laravel.users` with a bcrypt/argon password and `role=super_admin`.
7. `php artisan serve`
8. Public: `/` — Admin: `/admin`

## Important
This archive is an **application overlay/source package**, not a vendor-complete Laravel distribution. The current execution environment has PHP but cannot fetch Composer packages, so `vendor/`, `artisan`, Laravel framework bootstrap files and lockfiles are intentionally not fabricated.

## Existing database
Supabase project: Banking Engine (`pnisrktkkbzspolkfkag`).
Do not expose PostgreSQL passwords or service-role secrets in frontend code.
