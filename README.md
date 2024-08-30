# Microblog Docker Setup

This README provides instructions for setting up and running the Microblog application using Docker.

## Getting Started

1. Clone the repository:
   ```
   git clone https://kendarylperezyns@bitbucket.org/kenprz/microblog.git
   cd microblog
   ```

2. Make the setup script executable:
   ```
   chmod +x setup.sh
   ```

3. Run the setup script:
   ```
   ./setup.sh
   ```

   This script will:
   - Install Composer dependencies
   - Start the Docker containers
   - Install NPM dependencies
   - Generate the application key
   - Run database migrations and seed the database
   - Compile assets
   - Run node

4. Access your application at `http://localhost`

... (rest of the README remains the same)