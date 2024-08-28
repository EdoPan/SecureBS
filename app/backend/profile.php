<?php
require './utils/db_manager.php';
include_once 'utils/utils.php';
session_start();

$db = DBManager::getInstance();

if (!isset($_SESSION['user_id'])) {
    redirect_with_message("login", "You are not logged in");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validate input fields
    $errors = array();
    $data = $_POST;
    $errors = validate_fields("change_pwd", $data);

    if (count($errors) > 0) {
        redirect_with_message("profile", "Invalid fields");
    }

    // check if the user exists
    $db = DBManager::getInstance();
    $query = "SELECT * FROM users WHERE id = ?";
    $params = [$_SESSION['user_id']];
    $param_types = "i";
    $result = $db->execute_query($query, $params, $param_types);

    if (empty($result)) {
        redirect_with_message("profile", "Error while retrieving user data");
    }

    $username = $result[0]["username"];
    $email = $result[0]["email"];

    // check if the passwords are not equal
    $current_pwd = $_POST["current_pswd"];
    $new_pwd = $_POST["new_pswd"];

    if ($new_pwd === $current_pwd) {
        redirect_with_message("profile", "The new password must be different from the current one");
    }

    send_change_password_code($username, $email);
    $_SESSION["new_pswd"] = password_hash($new_pwd, PASSWORD_DEFAULT);

    redirect_to_page("change_pwd");
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Fetch user info
    $q0 = 'SELECT username, email FROM users WHERE id= ?;';
    $params = [$_SESSION['user_id']];
    $param_types = "i";
    $info = $db->execute_query($q0, $params, $param_types);

    // Fetch purchased books
    $q1 = 'SELECT DISTINCT name, author, price, book_id FROM books INNER JOIN orders WHERE orders.user_id = ? AND books.id=orders.book_id;';
    $params = [$_SESSION['user_id']];
    $param_types = 'i';
    $books = $db->execute_query($q1, $params, $param_types);
}

require '../frontend/profile.php';