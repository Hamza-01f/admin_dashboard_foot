<?php

$server_name = 'host.docker.internal';
$db_username = 'root';
$db_password = 'root_password';
$db_name = 'adminfutchampions';

$connection = mysqli_connect($server_name,$db_username,$db_password,$db_name);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

?>