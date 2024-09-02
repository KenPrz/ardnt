# Microblog Docker Setup

This README provides instructions for setting up and running the Microblog application using Docker.

## Getting Started

1. Clone the repository:
   ```
   git clone https://kendarylperezyns@bitbucket.org/kenprz/microblog.git
   cd microblog
   ```
2. run `docker-compose build`

3. run `docker-compose up`

4. run `docker-compose exec web bash`

5. run `php artisan migrate:fresh --seed`

6. Access your application at `http://localhost`