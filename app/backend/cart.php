<?php 
require './utils/db_manager.php';
session_start();

$db = DBManager::getInstance();
$query = 'SELECT name, author, price FROM books INNER JOIN carts WHERE session_id =' . '"' . session_id() . '"' . 'AND books.id=carts.book_id;';
$result = $db->query($query);

$items = [];

if ($result->rowCount() > 0) {
    $items = $result->fetchAll();
    
} else {
    $items = ['message' => 'No items in the cart!'];
}

require '../frontend/cart.php';