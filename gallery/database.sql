-- Create database and user (example). You can create DB/user via phpMyAdmin or CLI.
-- CREATE DATABASE gallery_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- CREATE USER 'gallery_user'@'localhost' IDENTIFIED BY 'change_me';
-- GRANT ALL PRIVILEGES ON gallery_db.* TO 'gallery_user'@'localhost';
-- FLUSH PRIVILEGES;


CREATE TABLE IF NOT EXISTS photos (
id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255) NOT NULL,
description TEXT NULL,
filename VARCHAR(255) NOT NULL,
uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;