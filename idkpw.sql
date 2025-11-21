CREATE DATABASE idkpw;
USE idkpw;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50)
);

INSERT INTO users (username, password)
VALUES 
('admin', '123'),
('dat', '12421'),
('aqư', 'ddd');
