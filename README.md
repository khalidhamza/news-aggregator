# Innoscripta case study [News Aggregator]

A backend application powered by PHP (Laravel), MySQL, and Docker. This guide helps you get started quickly using Docker.

## Prerequisites
- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Quick Start

1. **Clone the Repository:**
   ```sh
   git clone https://github.com/khalidhamza/innoscripta-news-aggregator-cs.git
   ```
   ```sh
   cd  innoscripta-news-aggregator-cs
   ```

2. **Build and start the containers:**
   ```sh
   docker compose --env-file ./build/.env up -d --build
   ```

   This command will build and start all required services: PHP (Laravel), MySQL, and Nginx.


2. **Prepare the Laravel application:**
   Enter the PHP container to run Laravel and Composer commands:
   ```sh
   docker exec -it news_aggregator_php sh 
   ```
   
   Once inside the container, run:
   ```sh
   composer install
   ```
   ```sh
   cp .env.example .env
   ```
   ```sh
   php artisan key:generate
   ```
   ```sh
   php artisan migrate
   ```
   Exit the container when finished:
   ```sh
   exit
   ```

3. **Access the application:**
   - **App URL:** [http://localhost:8080](http://localhost:8080)

   > Use the credentials set in your `.env` and `docker-compose.yml` files to log in to PGAdmin and manage your database.

## Troubleshooting
- If you encounter permission issues, run:
  ```sh
    chmod -R 775 src/storage
    ```
- Ensure Docker and Docker Compose are running and not blocked by firewall or other services.
