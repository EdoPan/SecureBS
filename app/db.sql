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
  book_id INTEGER NOT NULL
);

-- insert
INSERT INTO carts (session_id, book_id) VALUES ("5ce1pgu3g228tcmlk3vppdqfgt", 1);

-- create
CREATE TABLE users (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL,
  password VARCHAR(200) NOT NULL,
  email VARCHAR(50) NOT NULL
  
);

CREATE TABLE recovery_number (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  user_id VARCHAR(20) NOT NULL,
  number INT NOT NULL,
  request_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  opertion VARCHAR(20) NOT NULL
 );

-- create
CREATE TABLE orders (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  user_id INTEGER NOT NULL,
  book_id INTEGER NOT NULL,
  country TEXT NOT NULL,
  postal_code INTEGER NOT NULL,
  city TEXT NOT NULL,
  full_address TEXT NOT NULL,
  card_number INTEGER NOT NULL,
  card_owner TEXT NOT NULL
);