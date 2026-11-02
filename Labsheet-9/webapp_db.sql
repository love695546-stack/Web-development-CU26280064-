-- Q1: webapp_db database with users, products and orders tables
CREATE DATABASE IF NOT EXISTS webapp_db
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE webapp_db;

CREATE TABLE users (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username       VARCHAR(50)  NOT NULL UNIQUE,
    email          VARCHAR(100) NOT NULL UNIQUE,
    password       VARCHAR(255) NOT NULL,          -- password_hash() output
    remember_token VARCHAR(255) NULL,              -- used by "Remember Me"
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE products (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100)  NOT NULL,
    category   VARCHAR(50)   NOT NULL,
    price      DECIMAL(10,2) NOT NULL,
    image      VARCHAR(255)  NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE orders (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id     INT UNSIGNED  NOT NULL,
    product_id  INT UNSIGNED  NOT NULL,
    quantity    INT UNSIGNED  NOT NULL DEFAULT 1,
    total_price DECIMAL(10,2) NOT NULL,
    order_date  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)    REFERENCES users(id)    ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Sample data for testing
INSERT INTO products (name, category, price) VALUES
('Laptop Bag',      'Accessories', 899.00),
('Wireless Mouse',  'Electronics', 499.00),
('Keyboard',        'Electronics', 799.00),
('Notebook',        'Stationery',   60.00),
('Pen Set',         'Stationery',  120.00),
('Water Bottle',    'Home',        250.00),
('Desk Lamp',       'Home',        650.00),
('USB Cable',       'Accessories', 150.00);
