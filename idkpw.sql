CREATE DATABASE idkpw;
USE idkpw;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50)
);

INSERT INTO users (username, password)
VALUES 
('dat', '12222'),
('admin', '123'),
('aqw', 'ddd');
