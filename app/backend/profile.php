<?php
require './utils/db_manager.php';
session_start();

$db = DBManager::getInstance();

// Fetch user info
$q0 = 'SELECT username, email FROM users WHERE id= ?;';
$params = [$_SESSION['user_id']];
$param_types = "i";
$info = $db->execute_query($q0, $params, $param_types);

// Fetch purchased books
$q1 = 'SELECT DISTINCT name, author, price FROM books INNER JOIN orders WHERE orders.user_id = ? AND books.id=orders.book_id;';
$params = [$_SESSION['user_id']];
$param_types = 'i';
$books = $db->execute_query($q1, $params, $param_types);

require '../frontend/profile.php';