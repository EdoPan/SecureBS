<?php 
require './utils/db_manager.php';
require './utils/config.php';
require './utils/csrf.php';

$db = DBManager::getInstance();
$query = 'SELECT * FROM books INNER JOIN carts WHERE session_id = ? AND books.id=carts.book_id AND carts.created_at > NOW() - INTERVAL 15 MINUTE;';
$params = [session_id()];
$param_types = 's';
$items = $db->execute_query($query, $params, $param_types);

$total = 0;

if (!empty($items)) {

    foreach ($items as $item) {
        $total += $item['price'];
    }
} else {
    $items = ['message' => 'No items in the cart!'];
}

require '../frontend/cart.php';