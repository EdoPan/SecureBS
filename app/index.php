<?php 
require './backend/utils/db_manager.php';
session_start();

$db = DBManager::getInstance();
$query = 'SELECT * FROM books;';
$result = $db->query($query);

$books = [];

if ($result->rowCount() > 0) {
    $books = $result->fetchAll();

} else {
    $books = ['message' => 'No books available!'];
}

require './frontend/index.php';