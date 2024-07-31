-- create
CREATE TABLE books (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  name TEXT NOT NULL,
  author TEXT NOT NULL,
  price FLOAT NOT NULL
);

-- insert
INSERT INTO books (name, author, price) VALUES ("Can't Hurt Me", "David Googins", 23.99);
INSERT INTO books (name, author, price) VALUES ("Atomic Habits", "James Clear", 21.37);