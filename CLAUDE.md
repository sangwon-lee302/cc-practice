# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

A fresh Laravel 10 (PHP 8.1+) application, currently at the stock skeleton stage (default `welcome` route/view, default `User` model/migration only — no custom domain code yet). Per the README, it exists as a learning project for using Claude Code with Laravel. Runs via Laravel Sail (Docker Compose), with MySQL 8.4 as the database service (`DB_HOST=mysql`, matching the `mysql` service in `compose.yaml`).

## Commands

All PHP/artisan commands should run through Sail so they execute inside the app container against the `mysql` service (running commands on the host will fail since `DB_HOST=mysql` doesn't resolve outside Docker).

```bash
# Start the stack (app + MySQL)
./vendor/bin/sail up -d

# Stop the stack
./vendor/bin/sail down

# Run all tests (PHPUnit, Unit + Feature suites)
./vendor/bin/sail artisan test

# Run a single test file / method
./vendor/bin/sail artisan test tests/Feature/ExampleTest.php
./vendor/bin/sail artisan test --filter=test_method_name

# Artisan commands (migrations, tinker, etc.)
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan tinker

# Composer / npm inside the container
./vendor/bin/sail composer install
./vendor/bin/sail npm install

# Frontend dev server / build (Vite)
./vendor/bin/sail npm run dev
./vendor/bin/sail npm run build

# Code style (Laravel Pint)
./vendor/bin/sail composer pint   # if not aliased, use: ./vendor/bin/sail php vendor/bin/pint
```

The test suite (`phpunit.xml`) uses `DB_DATABASE=testing`, `CACHE_DRIVER=array`, `SESSION_DRIVER=array`, and `QUEUE_CONNECTION=sync` for isolation — no extra setup needed beyond a running `mysql` Sail service.

## Architecture

Standard Laravel 10 directory layout — no non-standard structure yet:

- `app/Http/Controllers`, `app/Models`, `app/Providers` — currently only the default `Controller`, `User` model, and default service providers exist.
- `routes/web.php` — only the default `/` route to `welcome.blade.php`.
- `routes/api.php`, `routes/console.php`, `routes/channels.php` — untouched defaults.
- `database/migrations` — only the default `users`, `password_reset_tokens`, `failed_jobs`, `personal_access_tokens` tables (Sanctum is installed via `composer.json` but not yet wired into routes/middleware).
- `tests/Feature` and `tests/Unit` — only the default example tests.

As real features get added, prefer conventional Laravel patterns (thin controllers, Eloquent models in `app/Models`, form requests for validation, migrations for schema changes) consistent with the rest of the framework's conventions.

## Conventions

- コミットメッセージは日本語で書く。
- コードのコメントは日本語で書く。
- テストは PHPUnit で書く（Pest は使わない）。
- コーディング規約は PSR-12 に準拠する。
