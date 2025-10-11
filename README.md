# Innoscripta case study [News Aggregator]

A backend application powered by PHP (Laravel), MySQL, and Docker. This guide helps you get started quickly using Docker.

---
## Prerequisites

Before you begin, ensure you have the following installed:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
---

## Quick Start

### 1. Clone the Repository
   ```bash
    git clone https://github.com/khalidhamza/innoscripta-news-aggregator-cs.git
   ```
   ```bash   
    cd innoscripta-news-aggregator-cs
   ```

### 2. Build and start the containers
   ```sh
   docker compose --env-file ./build/.env up -d --build
   ```

   This command will build and start all required services: PHP (Laravel), MySQL, and Nginx.


### 3. Prepare the Laravel application
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

### 4. Access the application
   - **App URL:** [http://localhost:8080](http://localhost:8080)


---

## API Documentation

You can explore and test the API using the provided Postman documentation and collection.

- **Online Documentation:** [News Aggregator API Docs](https://documenter.getpostman.com/view/3572491/2sB3QKtATJ)
- **Local Collection File:** `NewsAggregatorApis.postman_collection.json` (available in the project root folder)

To use locally:
1. Open Postman.
2. Go to **File → Import**.
3. Select the collection file and start testing the API endpoints.

---

##  Project Structure

```
├── build/                     # Docker configuration and environment files
├── src/                       # Laravel application source code
├── docker-compose.yml          # Main Docker Compose configuration
├── NewsAggregatorApis.postman_collection.json
└── README.md                   # This documentation file
```

---

##  Author

**Khalid Hamza**  
[GitHub Profile](https://github.com/khalidhamza)