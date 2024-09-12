<?php

function generate_csrf_token() {
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf'] = $token;
    return $token;
}

function generate_or_get_csrf_token() {
    if(!isset($_SESSION['csrf'])) {
        return generate_csrf_token();
    }
    return $_SESSION['csrf'];
}

function verify_csrf_token($token) {
    if(!isset($_SESSION['csrf'])) {
        return false;
    }
    return $_SESSION['csrf'] === $token;
}

function verify_and_regenerate_csrf_token($token) {
    $check = verify_csrf_token($token);
    if($check) {
        generate_csrf_token();
    }
    return $check;
}