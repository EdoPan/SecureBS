<?php
require './utils/db_manager.php';
session_start();

$db = DBManager::getInstance();
$query = 'SELECT * FROM books INNER JOIN carts WHERE session_id =' . '"' . session_id() . '"' . 'AND books.id=carts.book_id;';
$result = $db->query($query);

$items = [];
$total = 0;
$shipping = 3.99;

if ($result->rowCount() > 0) {
    $items = $result->fetchAll();
    foreach ($items as $item) {
        $total += $item['price'];
    }
} else {
    header('Location: /backend/cart.php');
}

require '../frontend/checkout.php';