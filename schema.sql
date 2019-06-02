CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title CHAR(50) UNIQUE,
    code CHAR(50) UNIQUE
);

CREATE TABLE lots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_add DATETIME DEFAULT CURRENT_TIMESTAMP,
    title CHAR(60),
    description TEXT,
    picture CHAR(255),
    price INT,
    bid_price INT,
    dt_end DATETIME,
    step INT,
    user_id INT,
    winner_id INT,
    category_id INT
);

CREATE TABLE bets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_bet DATETIME DEFAULT CURRENT_TIMESTAMP,
    price INT,
    user_id INT,
    lot_id INT
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    email CHAR(128) UNIQUE,
    name CHAR(50),
    password CHAR(255),
    avatar CHAR(255),
    contacts CHAR(255)
);
