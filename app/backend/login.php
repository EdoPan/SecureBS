<?php
session_start();
require '../frontend/login.php';
require_once './utils/db_manager.php';
include_once 'utils/utils.php';

// check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    redirect_with_message("index", "You are already logged in");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // validate input fields
    $errors = array();
    $data = $_POST;
    $errors = validate_fields("login", $data);

    if (count($errors) > 0) {
        redirect_with_message("login", "Invalid fields");
    }

    // check if the user exists
    $db = DBManager::getInstance();
    $query = "SELECT * FROM users WHERE username = ?";
    $params = [$_POST['username']];
    $param_types = "s";
    $result = $db->execute_query($query, $params, $param_types);

    if(empty($result)) {
        redirect_with_message("login", "User not found");
    }

    $password_corrected = password_verify($_POST['password'], $result[0]['password']);

    if ($password_corrected === true) {
        $_SESSION['user_id'] = $result[0]['id'];
        session_regenerate_id(true);
    } else {
        redirect_with_message("login", "Password is incorrect");
    }
    
    // check if it's needed to regenrate the session id
    if (!isset($_SESSION['last_generated'])) {
        $_SESSION['last_generated'] = time();
    }

    if (time() - $_SESSION['last_generated'] > 600) {
        session_regenerate_id(true);
        $_SESSION['last_generated'] = time();
    }
    
    redirect_to_page("index");
}