# KKHS Board of Governors Website

This repository contains the KKHS Board of Governors website and content management system. It powers the public-facing pages for announcements, events, gallery, about us, achievements, and contact information, while also providing an authenticated admin area for managing that content.

## Tech Stack

- PHP 8.2+
- Laravel 12
- Livewire 3
- Livewire Flux UI
- MySQL
- Vite
- Tailwind CSS 4
- Alpine.js
- OpenRouter API integration

## Project Structure

```text
kkhs-bog/
|-- app/                Laravel application logic, models, controllers, and Livewire components
|-- bootstrap/          Framework bootstrap files
|-- config/             Application and service configuration
|-- database/           Migrations, factories, and seeders
|-- public/             Public web root and static assets
|-- resources/          Blade views, frontend assets, and UI resources
|-- routes/             Web, auth, admin, and console routes
|-- storage/            Logs, cache, compiled views, and uploads
|-- tests/              Feature and unit tests
|-- .env.example        Example environment configuration
|-- artisan             Laravel CLI entry point
|-- composer.json       PHP dependencies and Composer scripts
|-- package.json        Frontend dependencies and npm scripts
|-- vite.config.js      Vite build configuration
```

## Run Locally

### Prerequisites

- Laragon
- PHP
- Composer
- Node.js and npm
- OpenRouter account for the chatbot feature

### Setup Steps

1. Install Laragon.
2. Start the required Laragon services, especially MySQL.
3. Use phpMyAdmin if you want a GUI to create or manage the local database.
4. Install dependencies:

```bash
composer install
npm install
```

5. Copy the environment file and update it based on `.env.example`:

```bash
cp .env.example .env
php artisan key:generate
```

6. Set your database values in `.env` for MySQL, for example:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kkhs_bog
DB_USERNAME=root
DB_PASSWORD=
```

7. Create an OpenRouter API token from the [OpenRouter website](https://openrouter.ai/). Add it to `.env` and choose any model you prefer:

```env
OPENROUTER_API_KEY=your-openrouter-api-key
OPENROUTER_MODEL=your-preferred-model
```

8. Run database migrations:

```bash
php artisan migrate
```

9. Start the frontend development server:

```bash
npm run dev
```

10. Start the Laravel application server in a separate terminal:

```bash
php artisan serve
```

## Contributing

If you are maintaining this system for KKHS, create your own fork before making changes. A fork keeps the main repository history cleaner, makes code review safer, and gives maintainers an isolated place to test, discuss, and stage updates before they are merged back into the primary project.
