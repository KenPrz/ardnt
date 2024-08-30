# Microblog Docker Setup

This README provides instructions for setting up and running the microblog app using Docker.

## Getting Started

1. Clone the repository:
   ```
   git clone https://kendarylperezyns@bitbucket.org/kenprz/microblog.git
   cd microblog
   ```

2. Copy the `.env` file:
   ```
   cp .env.example .env
   ```

3. Install Composer dependencies:
   ```
   docker run --rm \
   -u "$(id -u):$(id -g)" \
   -v "$(pwd):/var/www/html" \
   -w /var/www/html \
   laravelsail/php83-composer:latest \
   composer install --ignore-platform-reqs
   ```

4. Start the Docker containers:
   ```
   ./vendor/bin/sail up
   ```

## Configuring a Shell Alias

To make it easier to run Sail commands, you can set up an alias:

```
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

After setting up the alias, you can use:

```
sail up
```

to start your application.

## Additional Commands

- To stop the containers:
  ```
  sail down
  ```

- To run artisan commands:
  ```
  sail artisan [command]
  ```

- To run npm commands:
  ```
  sail npm [command]
  ```

Remember to run `sail artisan key:generate` to set the application key if you haven't already.

## Troubleshooting

If you encounter any issues, ensure that:
- Docker is installed and running on your system
- All required ports are available (typically 80, 3306, and others as specified in the docker-compose.yml)
- You have the necessary permissions to run Docker commands

For more information, refer to the [Laravel Sail documentation](https://laravel.com/docs/sail).
