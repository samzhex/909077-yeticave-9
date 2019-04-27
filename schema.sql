CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title CHAR(50) UNIQUE,
    code CHAR(50) UNIQUE
);

CREATE TABLE lot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title CHAR(60),
    lot_desc TEXT,
    picture CHAR(255),
    price INT,
    dt_end TIMESTAMP,
    step INT,
    user_id INT,
    winner_id INT,
    category_id INT
);

CREATE TABLE bet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_bet TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    price INT,
    user_id INT,
    lot_id INT
);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email CHAR(128),
    name CHAR(50) UNIQUE,
    password CHAR(50),
    avatar CHAR(255),
    contacts CHAR(255)
);
