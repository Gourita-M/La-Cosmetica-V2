<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# Cosmetica-Brief
# La-Cosmetica-V2

## API Overview

Base URL: `/api`

This project includes:
- JWT authentication (`tymon/jwt-auth`)
- Slug-based product access (`spatie/laravel-sluggable`)
- DAO layer for direct database interactions:
  - `OrderDAO`
  - `StatisticsDAO`
  - `CategoryDAO`
  - `ProductDAO`

## Postman / Swagger (Equivalent)

- OpenAPI spec is available at `docs/openapi.yaml`.
- You can import `docs/openapi.yaml` directly in Postman:
  - Postman -> Import -> File -> `docs/openapi.yaml`
- This provides a documented, testable endpoint collection.

## Authentication (JWT)

- `POST /register` - create a `customer` account.
- `POST /login` - get JWT token + role-based permissions.
- Add header for secured routes: `Authorization: Bearer <token>`.

Example login payload:

```json
{
  "email": "customer@example.com",
  "password": "password"
}
```

## Customer Endpoints

- `GET /profile` - authenticated profile.
- `GET /products` - list products (`name`, `description`, `price`, `image`, `images`, `category`).
- `GET /products/{slug}` - product details by slug (example: `/api/products/bio-moisturizing-cream`).
- `POST /orders` - place an order by product slug + quantity.
- `GET /orders` - list own orders.
- `GET /orders/{order}` - get own order details/status.
- `POST /orders/{order}/cancel` - cancel order only when status is `pending`.

Example order payload:

```json
{
  "products": [
    { "slug": "bio-moisturizing-cream", "quantity": 2 },
    { "slug": "vitamin-c-serum", "quantity": 1 }
  ]
}
```

## Employee Endpoints

- `GET /orders` - list all orders.
- `PUT /orders/{order}/status` with `status` in `being_prepared|delivered`.

## Administrator Endpoints

- Category management:
  - `POST /categories`
  - `PUT /categories/{category}`
  - `DELETE /categories/{category}`
- Product management:
  - `POST /products`
  - `PUT /products/{product}`
  - `DELETE /products/{product}`
- Statistics:
  - `GET /statistics` for total sales, most popular products, and distribution by category.

## Error Handling

API exceptions are normalized for `/api/*` responses in `bootstrap/app.php`.

- `401` unauthenticated
- `403` forbidden (role/ownership)
- `404` resource not found (for example unknown product slug)
- `422` validation/state errors (invalid payload, insufficient stock, invalid status transitions)

Validation errors follow this structure:

```json
{
  "message": "Validation error.",
  "errors": {
    "field_name": ["Validation message"]
  }
}
```
