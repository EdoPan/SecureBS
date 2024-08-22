<?php 
require './backend/utils/db_manager.php';
session_start();

$db = DBManager::getInstance();
$query = 'SELECT * FROM books;';
$books = $db->execute_query($query);
if (empty( $books )) {
    $books = ['message' => 'No books available!'];
}

require './frontend/index.php';