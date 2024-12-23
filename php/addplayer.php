<?
ob_start();
include __DIR__."/../my_php_project/config/db_connection.php";
if(isset($_POST['add_player'])){
      
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name_player'];
    $position = $_POST['position'];
    $rating = $_POST['rating'];
    $photo = $_POST['photo'];
    $nationality = $_POST['nationality'];
    $flag = $_POST['flag'];
    $logo = $_POST['logo'];
    $club = $_POST['club'];
    $pace = $_POST['pace'];
    $shooting = $_POST['shooting'];
    $passing = $_POST['passing'];
    $dribbling = $_POST['dribbling'];
    $defending = $_POST['defending'];
    $physical = $_POST['physical'];
    $diving = $_POST['diving'];
    $handling = $_POST['handling'];
    $kicking = $_POST['kicking'];
    $reflexes = $_POST['reflexes'];
    $speed = $_POST['speed'];
    $positioning = $_POST['positioning'];
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    
        if($position === "GK"){
            $sql_query = "
            INSERT INTO players (name_player, position, rating, photo, nationality_id, club_id) 
            VALUES ('$name', '$position', '$rating', '$photo', '$nationality', '$club');
            INSERT INTO gk_field (diving, handling, kicking, reflexes, speed, positioning) 
            VALUES ('$diving', '$handling', '$kicking', '$reflexes', '$speed', '$positioning');
        ";
        }else{
            $sql_query = "
            INSERT INTO players (name_player, position, rating, photo, nationality_id, club_id) 
            VALUES ('$name', '$position', '$rating', '$photo', '$nationality', '$club');
            INSERT INTO players_field (pace, shooting, passing, dribbling, defending, physical) 
            VALUES ('$pace', '$shooting', '$passing', '$dribbling', '$defending', '$physical');
        ";
        }

      


    $result = mysqli_multi_query($connection,$sql_query);
    header("Location:./../index.php");
    ob_end_flush();
    
}
mysqli_close($connection);
?>



