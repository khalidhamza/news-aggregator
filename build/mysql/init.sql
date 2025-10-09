-- Initialize MySQL database for News Aggregator

-- Use the news_aggregator database
USE news_aggregator;

-- Set character set and collation
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Grant all privileges to news_user
GRANT ALL PRIVILEGES ON news_aggregator.* TO 'news_user'@'%';
FLUSH PRIVILEGES;

-- Create full-text search parser for better article search
-- Note: Tables will be created by Laravel migrations
-- This script prepares the database environment

-- Optimize MySQL for read-heavy workloads
SET GLOBAL innodb_buffer_pool_size = 536870912; -- 512MB
SET GLOBAL max_connections = 200;
SET GLOBAL innodb_flush_log_at_trx_commit = 2;

-- Enable performance schema for monitoring
-- SET GLOBAL performance_schema = ON;

-- Log message
SELECT 'News Aggregator database initialized successfully!' AS message;