# Laravel + Node.js Notification System

A lightweight, real-time notification system using Laravel, Node.js, and Redis Pub/Sub for seamless communication and storage with PostgreSQL.

## Features
- REST API for publishing notifications (Laravel)
- Notifications stored in PostgreSQL
- Real-time messaging via Redis Pub/Sub
- Node.js microservice (Fastify + TypeScript) consumes and logs notifications
- Laravel updates database upon notification processing
- Scalable, production-ready architecture

## Tech Stack
| Layer        | Technology                    |
|--------------|-------------------------------|
| Backend API  | Laravel 10, PHP 8.3          |
| Microservice | Node.js, Fastify, TypeScript |
| Messaging    | Redis Pub/Sub                 |
| Database     | PostgreSQL                    |

## Prerequisites
- PHP 8.3+
- Composer
- Node.js 18+
- Docker (for Redis)
- PostgreSQL
- Redis PHP extension (`php_redis`)

## Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/notification-system.git
cd notification-system
```
### 2. Set Up Laravel Backend
```bash
cd backend-laravel
composer install
cp .env.example .env
php artisan key:generate

Update .env with your database and Redis settings:
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=notification
DB_USERNAME=postgres
DB_PASSWORD=your_password
REDIS_PORT=6379
REDIS_CLIENT=phpredis
QUEUE_CONNECTION=redis
```
### Run migrations and start the server:
```bash
php artisan migrate
php artisan serve
```

### 3. Run Redis via Docker
```bash
docker run -d --name redis-server -p 6379:6379 redis
```

### 4. Set Up Node.js Microservice
```bash
cd ../consumer-node
npm install
npm run dev
```

### Testing the System
## Send a test notification via cURL:
```bash
curl -X POST http://localhost:8000/api/notifications \
  -H "Content-Type: application/json" \
  -d '{"user_id": 1, "message": "Test from Laravel"}'
```

### Expected output in Node.js console:
```bash
Received notification: { id: 1, user_id: 1, message: 'Test from Laravel' }
Sending notification to user 1: "Test from Laravel"
```

### Notes
#### Ensure Redis and PostgreSQL are running before starting the services.
#### Replace your-username in the clone command with your GitHub username.
#### For Windows, ensure php_redis.dll is enabled in your PHP configuration.
