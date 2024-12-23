<?php

include_once __DIR__ . "/../my_php_project/config/db_connection.php";
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $request = " delete from players
    WHERE players.id = '$id'
";
    $result = mysqli_query($connection, $request);
    if (!$result) {
        die("error:" . mysqli_error($connection));
    } 


}
if (!$result) {
    die("error:" . mysqli_error($connection));
} else {
    header(header: 'location:./../index.php');
}

?>