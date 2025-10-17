# Food Delivery Laravel Test Project

## Overview
This is a Laravel-based real-time analytics and order management system for a food delivery platform. It includes order management, analytics, and event-driven processing using Redis Streams.

## Chosen Architecture and Technologies
- **Framework:** Laravel 10+ (or your version).
- **Database:** MySQL.
- **Event Streaming:** Redis Streams for real-time updates.
- **Security:** Laravel Sanctum for API authentication.
- **Other Tools:** PHPUnit for testing, Eloquent for ORM.

## Setup Instructions
Follow these steps to set up and run the project:

1. **Clone the Repository:**
https://github.com/Uzain-Ali/Food-Delivery-App


2. **Install Dependencies:**
- Ensure you have Composer installed.
- Run:
  ```
  composer install
  ```

3. **Environment Configuration:**
- Copy the `.env.example` file to `.env` (if it exists) and update the following:
  - **Database:** Set `DB_DATABASE=your_db_name`, `DB_USERNAME=your_db_user`, `DB_PASSWORD=your_db_password`.
  - **Redis:** Ensure Redis is installed and running. If you're on Windows, you mentioned running `.\redis-server.exe`. Configure:
    ```
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    ```
    - To start Redis: Navigate to your project directory and run `.\redis-server.exe` in a separate terminal window.

4. **Database Setup:**
- Create a MySQL database (e.g., `food_delivery_db`).
- Run migrations:
  ```
  php artisan migrate
  ```
- Run seeders to populate initial data:
  ```
  php artisan db:seed
  ```

5. **Start the Application:**
- Generate an application key if needed:
  ```
  php artisan key:generate
  ```
- Serve the application:
  ```
  php artisan serve
  ```
- For API testing, use tools like Postman. Ensure Sanctum is set up for authentication.

6. **Running Tests:**
- Run the full test suite:
  ```
  php artisan test
  ```
- Or run a specific test:
  ```
  php artisan test --filter=it_returns_average_delivery_times_for_authenticated_user
  ```

7. **API Documentation:**
- Check the included Postman collection (`postman_collection.json`) for API endpoints.
- Alternatively, use Swagger documentation in the `docs/` folder.

## Assumptions and Limitations
- This project assumes a local development environment with MySQL and Redis installed.
- Sensitive data (e.g., database credentials) should be configured in `.env`.
- Redis must be running for event-driven features to work.

## Deliverables
- **Complete Code:** All Laravel files are included.
- **Tests:** Unit and integration tests are in the `tests/` directory.
- **Documentation:** API docs are provided.

Thank you for reviewing!