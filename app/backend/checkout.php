<?php
require './utils/db_manager.php';
session_start();

$db = DBManager::getInstance();
$query = 'SELECT * FROM books INNER JOIN carts WHERE session_id = ? AND books.id=carts.book_id;';
$params = [session_id()];
$param_types = 's';
$items = $db->execute_query($query, $params, $param_types);

$total = 0;
$shipping = 3.99;

if (!empty($items)) {
    foreach ($items as $item) {
        $total += $item['price'];
    }
} else {
    header('Location: /backend/cart.php');
}

require '../frontend/checkout.php';