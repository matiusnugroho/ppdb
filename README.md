# PPDB Installation & Usage Guide

## Installation

1. Clone repository
   ```bash
   git clone <repository-url>
   ```
2. Install PHP dependencies with Composer
   ```bash
   composer install
   ```
3. Install JavaScript dependencies for the front-end
   ```bash
   cd front_end
   npm install
   ```

## Local Development

1. Copy `.env.example` to `.env` and adjust configuration as needed.
2. Set the correct application URLs in the `.env` file:
   ```env
   APP_URL=https://ppdb.lab
   SESSION_DOMAIN=.ppdb.lab
   SANCTUM_STATEFUL_DOMAINS=ppdb.lab
   ```
3. Start the Laravel back-end server:
   ```bash
   php artisan serve
   ```
4. In a separate terminal, run the front-end development server:
   ```bash
   cd front_end
   npm run dev
   ```

## Production Deployment

If you do not have SSH access to the production server, trigger the following endpoints in sequence after deploying the code:

1. `https://<your-domain>/setup`
2. `https://<your-domain>/link` (runs `php artisan storage:link`)

These endpoints will perform the necessary setup tasks for the application.
