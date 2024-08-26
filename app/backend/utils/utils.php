<?php
include_once "validation.php";
include_once "mail.php";
include_once "navigation.php";

$regexes = [
    'firstname' => "/[\\-'A-Z a-zÀ-ÿ]+",
    'lastname' => "/[\\-'A-Z a-zÀ-ÿ]+",
    'full_address' => "/[\\-'A-Z a-zÀ-ÿ0-9.,]+",
    'city' => "/[\\-'A-Z a-zÀ-ÿ.]+",
    'postal_code' => "\d+",
    'country' => "[\\-'A-Z a-z]+",
    'card_number' => "\b\d{4}[\\- ]?\d{4}[\\- ]?\d{4}[\\- ]?\d{4}\b",
    'cvv' => "\d{3}",
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
        "card_owner" => $regexes['firstname']
    ]
];