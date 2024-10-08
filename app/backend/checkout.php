<?php
require './utils/db_manager.php';
require_once './utils/logger.php';
require_once 'utils/utils.php';
require './utils/config.php';
require_once './utils/csrf.php';

$logger = Log::getInstance();

$db = DBManager::getInstance();
$q0 = 'SELECT * FROM books INNER JOIN carts WHERE session_id = ? AND books.id=carts.book_id;';
$params = [session_id()];
$param_types = 's';
$items = $db->execute_query($q0, $params, $param_types);

$total = 0;
$shipping = 3.99;

if (!empty($items)) {
    foreach ($items as $item) {
        $total += $item['price'];
    }
} else {
    header('Location: /backend/cart.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $errors = [];
    $data = $_POST;
    $errors = validate_fields("checkout", $data);

    if (count($errors) > 0) {
        $logger->warning("Invalid fields during checkout", ['session_id' => session_id(), 'user_id' => $_SESSION['user_id'], 'errors' => $errors, 'data' => $data]);
        redirect_with_message("checkout", "Invalid fields");
    }

    // CSRF token check
    if(!verify_and_regenerate_csrf_token($_POST['csrf'])){
        $logger->warning("CSRF tokens do not match", ['csrf' => $_POST['csrf']]);
        redirect_to_page("index");
    }

    // Fetch the ids of the books in the cart
    $q1 = 'SELECT * FROM carts WHERE session_id= ?;';
    $params = [session_id()];
    $param_types = 's';
    $r1 = $db->execute_query($q1, $params, $param_types);

    // Perform this query for each items in the cart
    foreach ($r1 as $item) {
        // Insert record in orders
        $q2 = 'INSERT INTO orders (user_id, book_id, country, postal_code, city, full_address, card_number, card_owner) VALUES (?,?,?,?,?,?,?,?);';

        $params = [$_SESSION['user_id'], $item['book_id'], $_POST['country'], $_POST['postal_code'], 
            $_POST['city'], $_POST['full_address'], substr($_POST['card_number'], -4), $_POST['card_owner']];
        $param_types = "sisissss";
        $r2 = $db->execute_query($q2, $params, $param_types);

        // Delete book from cart
        $q3 = 'DELETE FROM carts WHERE session_id= ? AND book_id= ?;';
        $params = [session_id(), $item['book_id']];
        $param_types = "si";
        $r3 = $db->execute_query($q3, $params, $param_types);
        
        // Log orders
        $logger->info("User placed an order", ['user_id' => $_SESSION["user_id"], 'book_id' => $item['book_id']]);
    }
    redirect_to_page("profile");
}

require '../frontend/checkout.php';