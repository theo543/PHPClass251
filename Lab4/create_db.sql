CREATE DATABASE Lab4;
USE Lab4;

CREATE TABLE accounts (
    account_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ip VARCHAR(16) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL
)
