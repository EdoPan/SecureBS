-- create
CREATE TABLE books (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  name TEXT NOT NULL,
  author TEXT NOT NULL,
  price FLOAT NOT NULL,
  quantity INTEGER NOT NULL
);

-- insert
INSERT INTO books (name, author, price, quantity) VALUES ("Can't Hurt Me", "David Googins", 23.99, 4);
INSERT INTO books (name, author, price, quantity) VALUES ("Atomic Habits", "James Clear", 21.37, 5);

-- create
CREATE TABLE carts (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  session_id TEXT NOT NULL,
  book_id INTEGER NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp()
);

-- create
CREATE TABLE users (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL,
  password VARCHAR(200) NOT NULL,
  email VARCHAR(50) NOT NULL,
  need_verification tinyint(1) DEFAULT 0
  
);

-- create
CREATE TABLE recovery_number (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  username varchar(20) NOT NULL,
  number INT NOT NULL,
  request_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  operation VARCHAR(20) NOT NULL
 );

-- create
CREATE TABLE login_attempts (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL,
  attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

-- create
CREATE TABLE orders (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  user_id INTEGER NOT NULL,
  book_id INTEGER NOT NULL,
  country TEXT NOT NULL,
  postal_code VARCHAR(5) NOT NULL,
  city TEXT NOT NULL,
  full_address TEXT NOT NULL,
  card_number VARCHAR(4) NOT NULL,
  card_owner TEXT NOT NULL
);

SET GLOBAL event_scheduler = ON;

DELIMITER //

CREATE EVENT IF NOT EXISTS cleanup_expired_carts
ON SCHEDULE EVERY 15 MINUTE
DO
BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE v_cart_id INT;
    DECLARE v_book_id INT;

    DECLARE cur CURSOR FOR 
        SELECT id, book_id FROM carts WHERE created_at < NOW() - INTERVAL 15 MINUTE;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN cur;

    read_loop: LOOP
        FETCH cur INTO v_cart_id, v_book_id;
        IF done THEN
            LEAVE read_loop;
        END IF;

        -- Aggiorna la quantità disponibile del libro
        UPDATE books 
        SET quantity = quantity + 1 
        WHERE id = v_book_id;

        -- Rimuovi l'articolo dal carrello
        DELETE FROM carts WHERE id = v_cart_id;
    END LOOP;

    CLOSE cur;
END //

DELIMITER ;