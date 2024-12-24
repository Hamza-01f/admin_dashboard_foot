<?php
ob_start();
include __DIR__ . "/../my_php_project/config/db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $name = mysqli_real_escape_string($connection, $_POST['name_player']);
    $position = mysqli_real_escape_string($connection, $_POST['position']);
    $rating = mysqli_real_escape_string($connection, $_POST['rating']);
    $photo = mysqli_real_escape_string($connection, $_POST['photo']);
    $nationality = mysqli_real_escape_string($connection, $_POST['nationality']);
    $flag = mysqli_real_escape_string($connection, $_POST['flag']);
    $logo = mysqli_real_escape_string($connection, $_POST['logo']);
    $club = mysqli_real_escape_string($connection, $_POST['club']);

   
    if ($position === "GK") {
       
        $diving = mysqli_real_escape_string($connection, $_POST['diving']);
        $handling = mysqli_real_escape_string($connection, $_POST['handling']);
        $kicking = mysqli_real_escape_string($connection, $_POST['kicking']);
        $reflexes = mysqli_real_escape_string($connection, $_POST['reflexes']);
        $speed = mysqli_real_escape_string($connection, $_POST['speed']);
        $positioning = mysqli_real_escape_string($connection, $_POST['positioning']);
        
     
        $sql_query_1 = "
            INSERT INTO players (name_player, position, rating, photo, nationality_id, club_id) 
            VALUES ('$name', '$position', '$rating', '$photo', '$nationality', '$club')
        ";

        if (mysqli_query($connection, $sql_query_1)) {
         
            $player_id = mysqli_insert_id($connection);

           
            $sql_query_2 = "
                INSERT INTO gk_fields (diving, handling, kicking, reflexes, speed, positioning, players_id) 
                VALUES ('$diving', '$handling', '$kicking', '$reflexes', '$speed', '$positioning', '$player_id')
            ";
            mysqli_query($connection, $sql_query_2);
        } else {
            die("Error: " . mysqli_error($connection));
        }
    } else {
     
        $pace = mysqli_real_escape_string($connection, $_POST['pace']);
        $shooting = mysqli_real_escape_string($connection, $_POST['shooting']);
        $passing = mysqli_real_escape_string($connection, $_POST['passing']);
        $dribbling = mysqli_real_escape_string($connection, $_POST['dribbling']);
        $defending = mysqli_real_escape_string($connection, $_POST['defending']);
        $physical = mysqli_real_escape_string($connection, $_POST['physical']);
        
   
        $sql_query_1 = "
            INSERT INTO players (name_player, position, rating, photo, nationality_id, club_id) 
            VALUES ('$name', '$position', '$rating', '$photo', '$nationality', '$club')
        ";

        if (mysqli_query($connection, $sql_query_1)) {
  
            $player_id = mysqli_insert_id($connection);

         
            $sql_query_2 = "
                INSERT INTO players_fields (pace, shooting, passing, dribbling, defending, physical, players_id) 
                VALUES ('$pace', '$shooting', '$passing', '$dribbling', '$defending', '$physical', '$player_id')
            ";
            mysqli_query($connection, $sql_query_2);
        } else {
            die("Error: " . mysqli_error($connection));
        }
    }

    header("Location: ./../index.php");
    ob_end_flush();
}

mysqli_close($connection);
?>
