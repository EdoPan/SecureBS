<?php
//session_start();
require '../frontend/register.php';
require_once './utils/db_manager.php';
include_once 'utils/utils.php';
// check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    redirect_with_error("index", "You are already logged in");
    exit;
}

/**
 * Register fields:
 * - email
 * - username
 * - pwd
 * - confirm_pwd
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // check if two passwords are equal
    if ($_POST["password"] !== $_POST["pswd"]) {
        redirect_with_error("register", "Passwords do not match");
    }

    $errors = array();
    $data = $_POST;
    $errors = validate_fields("register", $data);

    if (count($errors) > 0) {
        redirect_with_error("register", "Invalid fields");
    }

    // check the username
    $db = DBManager::getInstance();
    $query = "SELECT * FROM users WHERE username = ?";
    $params = [$_POST['username']];
    $param_types = "s";
    $result = $db->execute_query($query, $params, $param_types);

    if(!empty($result)) {
        redirect_with_error("register", "Username already exists");
    }

    // check the email
    $query = "SELECT * FROM users WHERE email = ?";
    $params = [$_POST['email']];
    $param_types = "s";
    $result = $db->execute_query($query, $params, $param_types);

    if(!empty($result)) {
        redirect_with_error("register", "Email already exists");
    }

    // all check passed, now insert the user
    $query = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
    $params = [$_POST["email"], $_POST["username"], password_hash($_POST["password"], PASSWORD_DEFAULT)];
    $param_types = "sss";
    $result = $db->execute_query($query, $params, $param_types);

    if ($result > 0){
        redirect_to_page("login");
    } else {
        redirect_with_error("register", "Impossible to create user");
    }


}
