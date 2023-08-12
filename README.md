# News Management Application

This repository contains a Laravel-based news management application that implements various features and best practices for a clean and functional API project.

## Prerequisites

- PHP (>= 8.1)
- Composer
- MySQL Database
- Redis (for queuing)

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/yourusername/news-management.git
   ```
2. Install dependencies:

   ```bash
    composer install
    ```
3. Create a copy of the `.env.example` file and rename it to `.env`:

   ```bash
   cp .env.example .env
   ```
4. Generate an application key:

   ```bash
    php artisan key:generate
    ```
5. Create a database and update the `.env` file with the database credentials:
6. install passport:

   ```bash
    php artisan passport:install
    ```
7. Run the database migrations and seeders:

   ```bash
    php artisan migrate --seed
    ```
8. Start the local development server:
    ```bash
    php artisan serve
    ```
9. Run the queue worker:

   ```bash
    php artisan queue:work
    ```
10. Visit `http://localhost:8000` in your postmen to view the application.
11. Run the tests:

   ```bash
    php artisan test
    ```
## API Documentation
To explore and interact with the APIs, you can use the provided Postman collection. Postman Collection Link: https://elements.getpostman.com/redirect?entityId=23687502-e984a8c9-1108-466c-a30a-ecdc39c532cf&entityType=collection

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/23687502-e984a8c9-1108-466c-a30a-ecdc39c532cf?action=collection%2Ffork&source=rip_markdown&collection-url=entityId%3D23687502-e984a8c9-1108-466c-a30a-ecdc39c532cf%26entityType%3Dcollection%26workspaceId%3D6c2ea7c7-601e-4128-b715-7b7bdd9390c0)

## Usage
- Admin users should log in to access the create, update, and delete news endpoints
- Non-admin users can post comments to news articles.
- The oauth/token endpoint should be used to obtain access tokens using Laravel Passport.
- login using admin :
   ```bash
    email: admin@admin.com
    password: password
    ```

## Folder Structure
- `app/Http/Controllers/Api` - Contains the API controllers
- `app/Http/Requests` - Contains the API form requests
- `app/Models` - Contains the Eloquent models
- `app/Repositories` - Contains the repositories for the models
- `app/Http/Middleware` - Contains the middleware
- `app/Http/Resources` - Contains the API resources
- `app/Http/Controllers/Api/Auth` - Contains the authentication controllers
- `app/Http/Controllers/Api/News` - Contains the news controllers
- `app/Http/Controllers/Api/Comment` - Contains the comment controllers
- `database/seeds` - Contains seeders for populating the database with sample data.
- `routes/api.php` - Defines API routes.
- `config` - Contains configuration files, including Laravel Passport settings.



