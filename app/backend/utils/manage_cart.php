<?php
require './db_manager.php';
require_once './logger.php';

session_start();

$logger = Log::getInstance();

$db = DBManager::getInstance();

$action = $_GET['action'];
$book_id = $_GET['id'];

if ($action == 1) {
    // Fetch quantity in order to update the row after the add cart
    $q0 = 'SELECT quantity FROM books WHERE id= ? ;';
    $params = [$book_id];
    $param_types = 'i';
    $result = $db->execute_query($q0, $params, $param_types);
    
    // Add to cart
    if(!empty($result)){
        $quantity = $result[0]['quantity'] - 1;
    }

    // check if exists already the cart
    $q0 = 'SELECT * FROM carts WHERE session_id= ? ORDER BY created_at DESC;';
    $params = [session_id()];
    $param_types = 's';
    $result = $db->execute_query($q0, $params, $param_types);
    $ts = null;
    if(!empty($result)){
        $ts = $result[0]['created_at'];
    }

    // insert into cart
    $q1 = 'INSERT INTO carts (session_id, book_id, created_at) VALUES (?,?,?);';
    if($ts == null){
        $ts = date('Y-m-d H:i:s');
    }
    $params = [session_id(), $book_id, $ts];
    $param_types = 'sis';
    $db->execute_query($q1, $params, $param_types);

    // Update book quantity
    $q2 = 'UPDATE books SET quantity= ? WHERE id= ?;';
    $params = [$quantity, $book_id];
    $param_types = 'ii';
    $db->execute_query($q2, $params, $param_types);

    $logger->info("User added a book to the cart", ['user_id' => $_SESSION['user_id'], 'book_id' => $book_id]);

    header('Location: /index.php');

} else if ($action == 2) {
    // Fetch quantity in order to update the row after the remove from cart
    $q0 = 'SELECT quantity FROM books WHERE id=?;';
    $params = [$book_id];
    $param_types = 'i';
    $result = $db->execute_query($q0, $params, $param_types);


    if(isset($result[0])){
        $quantity = $result[0]['quantity'] + 1;
    }

    // Update book quantity
    $q1 = 'UPDATE books SET quantity=? WHERE id=?;';
    $params = [$quantity, $book_id];
    $param_types = 'ii';
    $db->execute_query($q1, $params, $param_types);

    // Remove book from cart
    $q2 = 'DELETE FROM carts WHERE id = (SELECT MAX(id) FROM carts WHERE session_id= ? AND book_id=? );';
    $params = [session_id(), $book_id];
    $param_types = 'si';
    $db->execute_query($q2, $params, $param_types);

    $logger->info("User removed a book from to the cart", ['user_id' => $_SESSION['user_id'], 'book_id' => $book_id]);

    header('Location: /backend/cart.php');
}