# Laravel Docker Setup

This README provides instructions for setting up and running the Laravel application using Docker.

## Prerequisites

- Docker
- Docker Compose

## Setup Instructions

1. Clone the repository:
   ```
   git clone <your-repo-url>
   cd <your-project-directory>
   ```

2. Copy the example `.env` file:
   ```
   cp .env.example .env
   ```

3. Update the `.env` file with your specific configuration. Make sure the database credentials match those in your Docker Compose file.

4. Build and start the Docker containers:
   ```
   WWWGROUP=$(id -g) WWWUSER=$(id -u) docker-compose up -d --build
   ```

5. Install Composer dependencies:
   ```
   docker-compose exec laravel.test composer install
   ```

6. Generate application key:
   ```
   docker-compose exec laravel.test php artisan key:generate
   ```

7. Run database migrations:
   ```
   docker-compose exec laravel.test php artisan migrate
   ```

8. (Optional) Seed the database:
   ```
   docker-compose exec laravel.test php artisan db:seed
   ```

## Accessing the Application

- The Laravel application should now be accessible at `http://localhost`
- PHPMyAdmin is available at `http://localhost:8080`
- Mailpit is available at `http://localhost:8025`

## Stopping the Application

To stop the Docker containers, run:
```
docker-compose down
```

## Troubleshooting

- If you encounter permission issues, make sure the `WWWGROUP` and `WWWUSER` variables are correctly set when running Docker Compose.
- If tables are missing, ensure you've run the migrations as described in step 7.
- For any other issues, check the Docker logs:
  ```
  docker-compose logs
  ```

## Additional Commands

- To run Artisan commands:
  ```
  docker-compose exec laravel.test php artisan <command>
  ```
- To access the container's shell:
  ```
  docker-compose exec laravel.test bash
  ```

Remember to rebuild your Docker containers if you make changes to the Dockerfile or docker-compose.yml file.