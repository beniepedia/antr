# Repository Guidelines

## Project Structure & Module Organization

-   Laravel app code in `app/` (controllers, models, policies, Livewire in `app/Livewire`).
-   Views and Blade components in `resources/views`; JS/CSS in `resources/js` and `resources/css`.
-   Public assets in `public/`; routes in `routes/`; config in `config/`.
-   Database migrations/seeders in `database/`.
-   Tests in `tests/` (PHPUnit).

## Build, Test, and Development Commands

-   `php artisan serve` — start local server.
-   `php artisan migrate` — run migrations.
-   `npm install` then `npm run dev` — Vite dev build with HMR.
-   `npm run build` — production bundle of CSS/JS.
-   `php artisan test` — run PHPUnit tests.

## Coding Style & Naming Conventions

-   PHP: PSR‑12, 4‑space indentation; classes `PascalCase`, methods/vars `camelCase`.
-   Blade: use components/partials; view filenames `snake_case.blade.php`.
-   JS: ES modules in `resources/js`; keep UI logic small and scoped.
-   Tailwind/FlyonUI: prefer semantic classes; custom styles live in `resources/css/app.css`.

## Testing Guidelines

-   Place tests under `tests/Feature` or `tests/Unit`; name clearly (e.g., `UserCanLoginTest.php`).
-   If tests hit DB, configure testing database and migrations.
-   Run `php artisan test` locally before pushing.

## Commit & Pull Request Guidelines

-   Commits: concise, imperative subject (e.g., `Add tenant dashboard`), optional body for context.
-   PRs: include description, linked issues, and screenshots/GIFs for UI changes.
-   Ensure CI/build passes and tests succeed.

## Security & Configuration Tips

-   Do not commit `.env` or secrets; use `.env.example`.
-   Validate/authorize in controllers/Livewire; use policies/guards.
-   Keep dependencies current (`composer update`, `npm audit`).

## Livewire + FlyonUI Note

-   After Livewire DOM updates or `wire:navigate`, re‑init FlyonUI: call `window.HSStaticMethods.autoInit('all')` (see `resources/js/app.js`).
