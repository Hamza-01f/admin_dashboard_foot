<?php

$database_info = include __DIR__."/config.php";
$connection = mysqli_connect(
    $database_info['servername'],
    $database_info['username'],
    $database_info['password'],
    $database_info['database']
);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}