<?php
require './db_manager.php';
session_start();

$db = DBManager::getInstance();

$action = $_GET['action'];
$book_id = $_GET['id'];

if ($action == 1) {
    // Fetch quantity in order to update the row after the add cart
    $q0 = 'SELECT quantity FROM books WHERE id=' . $book_id . ';';
    $result = $db->query($q0);
    
    // Add to cart
    $quantity = $result->fetchColumn() - 1;
    $q1 = 'INSERT INTO carts (session_id, book_id) VALUES (' . "'" . session_id() . "'" . ',' . $book_id . ');';
    $db->query($q1);

    // Update book quantity
    $q2 = 'UPDATE books SET quantity=' . $quantity . ' WHERE id=' . $book_id . ';';
    $db->query($q2);

    header('Location: /index.php');

} else if ($action == 2) {
    // Fetch quantity in order to update the row after the remove from cart
    $q0 = 'SELECT quantity FROM books WHERE id=' . $book_id; ';';
    $result = $db->query($q0);
    $quantity = $result->fetchColumn() + 1;

    // Update book quantity
    $q1 = 'UPDATE books SET quantity=' . $quantity . ' WHERE id=' . $book_id . ';';
    $db->query($q1);

    // Remove book from cart
    // THIS QUERY DOES NOT WORK IF WE HAVE MORE ITEMS OF THE SAME TYPE
    $q2 = 'DELETE FROM carts WHERE session_id=' . "'" . session_id() . "' " . 'AND book_id=' . $book_id . ';';
    $db->query($q2);

    header('Location: /backend/cart.php');
}