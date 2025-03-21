# VoucherMoney – Transaction Microservice (Laravel 12)

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![License](https://img.shields.io/badge/license-MIT-green.svg)

A clean, scalable Laravel 12 microservice for managing user transactions.  
Built with SOLID principles, service-repository architecture, event-driven logic, and fully tested API.

---

## Features

- Clean **Service/Repository architecture**
- Robust **request validation** with custom rules
- Flexible **currency enum** support (`USD`, `EUR`)
- API responses are standardized via `ApiResponse`
- **Event-driven** design with `TransactionCreated` event and email notifications
- Lightweight **JSON API** with `TransactionResource`
- Fully tested with **Feature Tests** using PHPUnit
- Authenticated via `auth:sanctum`
- Easy to extend for financial apps, wallets, etc.

---

## Tech Stack

- **PHP 8.2+**
- **Laravel 12**
- **MySQL/PostgreSQL**
- **Sanctum Auth**
- **PHP native Enums**
- **Laravel Events/Notifications**
- **PHPUnit 11**

---

## Project Structure

```
app/
├── Contracts/
│   └── Services/, Repositories/
├── Enums/
├── Events/
├── Http/
│   ├── Controllers/
│   ├── Requests/
│   └── Resources/
├── Models/
├── Notifications/
├── Providers/
├── Repositories/
├── Responses/
├── Services/
├── Traits/
bootstrap/
└── app.php
database/
└── migrations/
routes/
└── api.php
tests/
├── Feature/
│   └── Transaction/
```

---

## Authentication

All API routes are protected via `auth:sanctum`.  
Use Laravel Sanctum tokens or session-based auth for testing.

---

## Installation

```bash
git clone https://github.com/boris-shakhverdyan/transactions-service.git
cd transactions-service

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate
php artisan db:seed

php artisan serve
```

---

## Running Tests

```bash
php artisan test
```

Expected output:
```
PASS  Tests\Feature\Transaction\CreateTransactionTest
✓ authenticated user can create transaction

PASS  Tests\Feature\Transaction\CreateTransactionValidationTest
✓ transaction fails with negative amount
✓ transaction fails with invalid currency
```

---

## API Endpoints

| Method | Endpoint                  | Description                  |
|--------|---------------------------|------------------------------|
| GET    | `/api/transactions`       | Get all user transactions    |
| GET    | `/api/transactions/{uuid}` | Get specific transaction     |
| POST   | `/api/transactions`       | Create a new transaction     |

### POST `/api/transactions` example:
```json
{
  "type": "deposit",
  "amount": 100.50,
  "currency": "USD",
  "meta": {
    "source": "referral"
  }
}
```

---

## Events & Notifications

- On successful transaction creation, the system:
    - Fires `TransactionCreated` event
    - Sends `TransactionCreatedNotification` to the user

---

## Author

**Boris Shakhverdyan**  
Backend Developer · Laravel Enthusiast · Clean Code Advocate
[LinkedIn](https://www.linkedin.com/in/boris-shakhverdyan) • [GitHub](https://github.com/boris-shakhverdyan)

---

## License

MIT – Feel free to use, modify, and build upon this project.
