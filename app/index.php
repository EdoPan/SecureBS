<?php 
require './backend/utils/db_manager.php';
require './backend/utils/utils.php';
require './backend/utils/csrf.php';
require './backend/utils/config.php';

$db = DBManager::getInstance();
$query = 'SELECT * FROM books;';
$books = $db->execute_query($query);
if (empty( $books )) {
    $books = ['message' => 'No books available!'];
}


if(isset($_COOKIE["PHPSESSID"])){
    header('Set-Cookie: PHPSESSID='.$_COOKIE["PHPSESSID"].'; SameSite=None');
}

require './frontend/index.php';