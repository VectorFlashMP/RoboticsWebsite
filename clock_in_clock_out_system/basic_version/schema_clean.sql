
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_code VARCHAR(100) UNIQUE,
    name VARCHAR(100),
    subteam VARCHAR(100)
);


CREATE TABLE logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action ENUM('entry','exit') NOT NULL,
    time DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

