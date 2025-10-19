# News Aggregator Application

A robust backend application powered by **PHP (Laravel)**, **MySQL**, and **Docker**, designed to aggregate and unify news articles from multiple trusted sources into a single, centralized API.

This application seamlessly integrates with **NewsAPI**, **The Guardian**, and **The New York Times**, fetching and normalizing articles. It provides a consistent data structure and easy access through a RESTful API, making it ideal for analytics, content aggregation, or news-based applications.

This guide will help you quickly set up, run, and explore the News Aggregator application using Docker.


---
## Prerequisites

Before you begin, ensure you have the following installed:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
---

## Quick Start

### 1. Clone the Repository
   ```bash
    git clone https://github.com/khalidhamza/news-aggregator.git
   ```
   ```bash   
    cd news-aggregator
   ```

### 2. Build and start the containers
   ```sh
   docker compose --env-file ./build/.env up -d --build
   ```

   This command will build and start all required services: PHP (Laravel), MySQL, and Nginx.


### 3. Prepare the Laravel application
   #### 3.1. Enter the PHP container to run Laravel and Composer commands:
   ```sh
   docker exec -it news_aggregator_php sh 
   ```

   #### 3.2. Once inside the container, run the following commands
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
   #### 3.3. Set the news source API key in the `.env` file
   ```env
   NEWSAPI_API_KEY=your_api_key_here
   GUARDIAN_API_KEY=your_api_key_here
   NYTIMES_API_KEY=your_api_key_here
   ```

   #### 3.4. Optimize the application configuration
   ```sh
   php artisan optimize
   ```

   #### 3.5. Exit the container
   ```sh
    exit
   ```
   #### 3.6. Restart the services to apply any changes
   ```sh
    docker compose --env-file ./build/.env restart
   ```

   #### 3.7. (Optional) Fetch articles immediately
   > By default, the news aggregation scheduler runs every **one hour**.
   If you want to populate articles **immediately** without waiting, you can run:
 
   ```sh
    docker exec -it news_aggregator_php sh
   ```

   ```sh
    php artisan articles:sync
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
