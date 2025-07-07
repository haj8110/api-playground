# README.md

````markdown
# REST API Testing Playground

A Laravel-based REST API playground featuring:

- Dummy Blog + User Management API
- Token Authentication with Laravel Sanctum
- API Rate Limiting
- API Documentation with Swagger (l5-swagger)
- Postman Collections for testing
- Prepared for CI/CD and automated testing

---

## Tech Stack

- PHP 8.x & Laravel 9.x
- MySQL (or any DB supported by Laravel)
- Laravel Sanctum (Token Auth)
- l5-swagger (OpenAPI docs)
- Postman (API testing)
- PHPUnit (automated testing)

---

## Features

- User registration & login (token-based)
- Blog post CRUD with ownership checks
- API rate limiting (global & per route)
- Swagger UI: `/api/documentation`
- Postman collection included (`postman_collection.json`)

---

## Installation

1. Clone repo

```bash
git clone <your-repo-url>
cd api-playground
````

2. Install dependencies

```bash
composer install
```

3. Copy `.env` and set database credentials

```bash
cp .env.example .env
# Edit .env with your DB settings
```

4. Generate app key

```bash
php artisan key:generate
```

5. Run migrations

```bash
php artisan migrate
```

6. Generate Swagger docs

```bash
php artisan l5-swagger:generate
```

7. Run the development server

```bash
php artisan serve
```

---

## Usage

* Access Swagger UI:
  [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

* Import Postman collection in Postman (`postman_collection.json`)
  Test API endpoints with included auth flows.

---

## Testing

Run PHPUnit tests:

```bash
php artisan test
```

---

## API Rate Limiting

* Global rate limiting is applied via middleware (default 60 requests/min).
* Login route has a custom throttle limit (e.g., 5 attempts per minute).

---

## Postman Collection

You can find the Postman collection JSON file in the project root:
`postman_collection.json`

---

## License

MIT License

---
