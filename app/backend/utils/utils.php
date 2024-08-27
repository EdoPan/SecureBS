<?php
include_once "validation.php";
include_once "mail.php";
include_once "navigation.php";

$regexes = [
    'card_owner' => "/[\\-'A-Z a-zÀ-ÿ]+/",
    'full_address' => "/[\\-'A-Z a-zÀ-ÿ0-9.,]+/",
    'city' => "/[\\-'A-Za-zÀ-ÿ.]+/",
    'postal_code' => "/\d{5}/",
    'country' => "/[\\-'A-Za-z]+/",
    'card_number' => "/\d{16}/",
    'cvv' => "/\d{3}/",
    'username' => "/^[a-zA-Z0-9]{3,20}$/",
    'password' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
    'email' => "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",
    'number' => '/\d{6}/',
];

$page_regexes = [
    "register" => [
        "username" => $regexes['username'],
        "password" => $regexes['password'],
        "pswd" => $regexes['password'],
        "email" => $regexes['email'],
    ],
    "login" => [
        "username" => $regexes['username'],
        "password" => $regexes['password'],
    ],
    "validate" => [
        "username" => $regexes['username'],
        "number" => $regexes['number'],
    ],
    "checkout" => [
        "country" => $regexes['country'],
        "postal_code" => $regexes['postal_code'],
        "city" => $regexes['city'],
        "full_address" => $regexes['full_address'],
        "card_number" => $regexes['card_number'],
        "card_owner" => $regexes['card_owner']
    ]
];