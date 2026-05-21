# LuckyRoll

A Laravel application where users register, receive a unique time-limited page link, and can roll for random prizes.

---

## Requirements

- Docker + Docker Compose
- [Laravel Sail](https://laravel.com/docs/sail) (included via Composer)

---

## Getting Started

### 1. Clone the repository

```bash
git clone git@github.com:densah1989/nuxgame-test.git
cd nuxgame-test
```

### 2. Install dependencies

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

### 3. Configure environment

```bash
cp .env.example .env
```

Open `.env` and set the following (defaults work with Sail out of the box):

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

### 4. Start the application

```bash
./vendor/bin/sail up -d
```

### 5. Generate application key

```bash
./vendor/bin/sail php artisan key:generate
```

### 6. Run migrations

```bash
./vendor/bin/sail php artisan migrate
```

### 7. Open in browser

```
http://localhost
```

---

## Stopping the application

```bash
./vendor/bin/sail down
```

---

## Architecture

The application follows a layered architecture with clear separation of concerns.

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── UserController    # Handles registration
│   │   ├── PageController    # Handles page display, regeneration, deactivation
│   │   └── RollController    # Handles lucky roll and history
│   └── Requests/
│       └── RegisterRequest   # Validates registration input
├── Services/
│   ├── UserService           # User registration logic
│   ├── PageService           # Page generation, regeneration, deactivation logic
│   └── RollService           # Roll logic: random number, win/lose, prize calculation
├── Repositories/
│   ├── UserRepository        # User DB operations
│   ├── PageRepository        # Page DB operations
│   └── RollRepository        # Roll DB operations
├── Models/
│   ├── User
│   ├── Page
│   └── Roll
└── DTOs/
    ├── UserDTO
    ├── PageDTO
    └── RollDTO
```

### Request flow

```
Request → Controller → Service → Repository → Model → Database
```

Controllers handle HTTP concerns only — they delegate all business logic to services.
Services contain the domain rules (prize calculation, route generation, expiry logic).
Repositories abstract all database queries.

### Key business rules

- A unique page link is generated on registration and is **valid for 7 days**
- The link can be **regenerated** (new route) or **deactivated** (soft delete) at any time
- A roll produces a random number from 1–1000
- **Even** number = Win, **Odd** number = Lose
- Prize is calculated from the winning number:

| Number range | Prize       |
|--------------|-------------|
| "> 900"        | 70% of number |
| "> 600"       | 50% of number |
| "> 300"        | 30% of number |
| "≤ 300"        | 10% of number |

---

## Running Tests

### All tests

```bash
./vendor/bin/sail php artisan test
```

### Unit tests only

```bash
./vendor/bin/sail php artisan test tests/Unit
```

### Specific test class

```bash
./vendor/bin/sail php artisan test tests/Unit/Services/RollServiceTest.php
```

### Test coverage

| Test class        | What is covered                                              |
|-------------------|--------------------------------------------------------------|
| `RollServiceTest` | `isWin` logic, `calculatePrize` for all tiers and boundaries |
| `PageServiceTest` | Page generation, route regeneration, deactivation            |
| `UserServiceTest` | User registration, correct DTO propagation to repository     |
