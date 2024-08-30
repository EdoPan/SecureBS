<?php
require './db_manager.php';
require_once './logger.php';
require_once './utils.php';
session_start();

$logger = Log::getInstance();

$db = DBManager::getInstance();
$book_id = $_GET['book_id'];
$query = 'SELECT DISTINCT user_id, book_id FROM orders WHERE user_id = ? AND book_id = ?;';
$params = [$_SESSION['user_id'], $book_id];
$param_types = "ii";
$result = $db->execute_query($query, $params, $param_types);

if (!empty($result)) {
    $filename = "../../books/{$book_id}.pdf";
    header("Content-Type:application/pdf");
    header("Content-Disposition:attachment;filename=\"{$book_id}.pdf\"");
    header('Content-Length: ' . filesize($filename));
    readfile($filename);

    $logger->info("User requested a download", ['username' => $username, 'file' => $filename]);

} else {
    redirect_with_message("profile", "Something went wrong");
}