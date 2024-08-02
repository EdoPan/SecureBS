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