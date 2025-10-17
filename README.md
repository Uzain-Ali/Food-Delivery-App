# Food Delivery Laravel Test Project

## Overview
This project implements a real-time analytics and order management system using Laravel. It uses Redis Streams for event-driven processing.

## Chosen Message Broker
- **Redis Streams**: Chosen for its speed, persistence, and seamless integration with Laravel. It's ideal for real-time notifications and analytics, as it supports durable streams without complex setup.

## Architecture Decisions
- **Order Service**: Handles creation and updates, triggering events via Redis.
- **Analytics Service**: Consumes events to update real-time data.
- **Notification Service**: Sends alerts using Laravel notifications.

## Setup Instructions
1. Clone the repo: `git clone https://github.com/yourusername/food-delivery-laravel-test`
2. Install dependencies: `composer install`
3. Copy .env.example to .env and configure DB and Redis.
4. Run migrations: `php artisan migrate`
5. Seed data: `php artisan db:seed`
6. Start the server: `php artisan serve`

## Running with Docker (Optional)
Use `docker-compose up --build`

## Assumptions
- MySQL is used for the database.
- Users table is assumed to exist from Laravel's default migration.