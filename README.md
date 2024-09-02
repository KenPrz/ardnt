# Microblog Docker Setup

This README provides instructions for setting up and running the Microblog application using Docker.

## Getting Started

1. Clone the repository:
   ```
   git clone https://kendarylperezyns@bitbucket.org/kenprz/microblog.git
   cd microblog
   ```
2. Run docker
   `docker-compose up`
3. Seed the database
    `docker-compose exec app php artisan migrate:fresh --seed`

4. Access your application at `http://localhost`