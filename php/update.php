<?php
ob_start();
include_once __DIR__ . "/../my_php_project/config/db_connection.php";
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $request = "
    SELECT p.*, n.nationality, n.flag, c.club_name, c.logo, gf.*, pf.*
    FROM players p
    INNER JOIN nationality n ON p.nationality_id = n.id
    INNER JOIN club c ON p.club_id = c.id
    LEFT JOIN gk_field gf ON p.id = gf.players_id
    LEFT JOIN players_field pf ON p.id = pf.players_id
    WHERE p.id = '$id'
";
    $result = mysqli_query($connection, $request);
    if (!$result) {
        die("error:" . mysqli_error($connection));
    } else {
        $row = mysqli_fetch_assoc($result);
    }
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>
<?php

$club_query = "SELECT id FROM club";
$club_result = mysqli_query($connection, $club_query);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_player'])) {
    $id = $_POST['id'];
    $fname = $_POST['name_player'];
    $fposition = $_POST['position'];
    $frating = $_POST['rating'];
    $fphoto = $_POST['photo'];
    $fnationality = $_POST['nationality'];
    $fflag = $_POST['flag'];
    $flogo = $_POST['logo'];
    $fclub = $_POST['club'];


    while ($club_row = mysqli_fetch_assoc($club_result)) {
        $fclub = $club_row['id'];
    }
    $update_query = "UPDATE players SET
        name_player='$fname',
        position='$fposition',
        rating='$frating',
        photo='$fphoto',
        nationality_id='$fnationality',
        club_id='$fclub'
        WHERE id='$id'";
    if (mysqli_multi_query($connection, $update_query)) {

        if ($fposition === "GK") {
            $fdiving = $_POST['diving'];
            $fhandling = $_POST['handling'];
            $fkicking = $_POST['kicking'];
            $freflexes = $_POST['reflexes'];
            $fspeed = $_POST['speed'];
            $fpositioning = $_POST['positioning'];


            $gk_update_query = "UPDATE gk_field SET
                        diving='$fdiving',
                        handling='$fhandling',
                        kicking='$fkicking',
                        reflexes='$freflexes',
                        speed='$fspeed',
                        positioning='$fpositioning'
                        WHERE id='$id'";

            $result =      mysqli_query($connection, $gk_update_query);
        } else {
            $fpace = $_POST['pace'];
            $fshooting = $_POST['shooting'];
            $fpassing = $_POST['passing'];
            $fdribbling = $_POST['dribbling'];
            $fdefending = $_POST['defending'];
            $fphysical = $_POST['physical'];


            $field_update_query = "UPDATE players_field SET
                        pace='$fpace',
                        shooting='$fshooting',
                        passing='$fpassing',
                        dribbling='$fdribbling',
                        defending='$fdefending',
                        physical='$fphysical'
                        WHERE id='$id'";

            $result =  mysqli_query($connection, $field_update_query);
        }
    }
    if (!$result) {
        die("error:" . mysqli_error($connection));
    } else {
        header(header: 'location:./../index.php');
        ob_end_flush();
        exit();
    }
}
?>

<body>
    <form id="form-player" class="needs-validation" novalidate action="update.php?new_id=<? echo $id; ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="name_player" class="form-label">Player Name</label>
                <input type="text" class="form-control" name="name_player" value="<?php echo $row['name_player']; ?>">
                <div class="invalid-feedback">Please provide a player name.</div>
            </div>
            <div class="col-md-6">
                <label for="position" class="form-label">Position</label>
                <select class="form-control" id="position" name="position" onchange="toggleFields()">

                    <option>Select Position</option>
                    <option value="GK" <?php echo ($row['position'] == 'GK') ? 'selected' : ''; ?>>GK</option>
                    <option value="CB" <?php echo ($row['position'] == 'CB') ? 'selected' : ''; ?>>CB</option>
                    <option value="MC" <?php echo ($row['position'] == 'MC') ? 'selected' : ''; ?>>MC</option>
                    <option value="LW" <?php echo ($row['position'] == 'LW') ? 'selected' : ''; ?>>LW</option>
                    <option value="ST" <?php echo ($row['position'] == 'ST') ? 'selected' : ''; ?>>ST</option>
                    <option value="RW" <?php echo ($row['position'] == 'RW') ? 'selected' : ''; ?>>RW</option>
                </select>

                <div class="invalid-feedback">Please select a position.</div>
            </div>
            <div class="col-md-6">
                <label for="rating" class="form-label">Rating</label>
                <input type="number" class="form-control" name="rating" min="1" max="99" value="<?php echo $row['rating']; ?>">
                <div class="invalid-feedback">Please provide a rating between 1 and 99.</div>
            </div>
            <div class="col-md-6">
                <label for="photo" class="form-label">Photo URL</label>
                <input type="url" class="form-control" name="photo" value="<?php echo $row['photo']; ?>">
                <div class="invalid-feedback">Please provide a valid URL for the photo.</div>
            </div>
            <div class="col-md-6">
                <label for="nationality" class="form-label">Nationality</label>
                <select class="form-control" name="nationality">
                    <option>Select Nationality</option>
                    <option value="7" <?php echo ($row['nationality_id'] == 7) ? 'selected' : ''; ?>>Brazil</option>
                    <option value="2" <?php echo ($row['nationality_id'] == 2) ? 'selected' : ''; ?>>Portugal</option>
                    <option value="1" <?php echo ($row['nationality_id'] == 1) ? 'selected' : ''; ?>>Argentina</option>
                    <option value="10" <?php echo ($row['nationality_id'] == 10) ? 'selected' : ''; ?>>Morocco</option>
                    <option value="4" <?php echo ($row['nationality_id'] == 4) ? 'selected' : ''; ?>>France</option>
                </select>
                <div class="invalid-feedback">Please select a Nationality.</div>
            </div>
            <div class="col-md-6">
                <label for="flag" class="form-label">Flag URL</label>
                <input type="url" class="form-control" name="flag" value="<?php echo $row['flag']; ?>">
                <div class="invalid-feedback">Please provide a valid URL for the flag.</div>
            </div>
            <div class="col-md-6">
                <label for="club" class="form-label">Club</label>
                <select class="form-control" name="club">
                    <option>Select Club</option>
                    <option value="3" <?php echo ($row['club_id'] == 3) ? 'selected' : ''; ?>>Manchester City</option>
                    <option value="4" <?php echo ($row['club_id'] == 4) ? 'selected' : ''; ?>>Real Madrid</option>
                    <option value="6" <?php echo ($row['club_id'] == 6) ? 'selected' : ''; ?>>Liverpool</option>
                    <option value="10" <?php echo ($row['club_id'] == 10) ? 'selected' : ''; ?>>Manchester United</option>
                    <option value="7" <?php echo ($row['club_id'] == 7) ? 'selected' : ''; ?>>Bayern Munich</option>
                </select>
                <div class="invalid-feedback">Please select a Club.</div>
            </div>
            <div class="col-md-6">
                <label for="logo" class="form-label">Club URL</label>
                <input type="url" class="form-control" name="logo" value="<?php echo isset($row['logo']) ? $row['logo'] : ''; ?>">
                <div class="invalid-feedback">Please provide a valid URL for the Club.</div>
            </div>
            <div id="field-stats" class="col-12" style="display: none;">
                <div class="row">
                    <div class="col-md-4">
                        <label for="pace" class="form-label">Pace</label>
                        <input type="number" class="form-control" id="pace" name="pace" value="<?php echo $row['pace']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="shooting" class="form-label">Shooting</label>
                        <input type="number" class="form-control" id="shooting" name="shooting" value="<?php echo $row['shooting']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="passing" class="form-label">Passing</label>
                        <input type="number" class="form-control" id="passing" name="passing" value="<?php echo $row['passing']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="dribbling" class="form-label">Dribbling</label>
                        <input type="number" class="form-control" id="dribbling" name="dribbling" value="<?php echo $row['dribbling']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="defending" class="form-label">Defending</label>
                        <input type="number" class="form-control" id="defending" name="defending" value="<?php echo $row['defending']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="physical" class="form-label">Physical</label>
                        <input type="number" class="form-control" id="physical" name="physical" value="<?php echo $row['physical']; ?>">
                    </div>
                </div>
            </div>
            <div id="gk-stats" class="col-12" style="display: none;">
                <div class="row">
                    <div class="col-md-4">
                        <label for="diving" class="form-label">Diving</label>
                        <input type="number" class="form-control" id="diving" name="diving" value="<?php echo $row['diving']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="handling" class="form-label">Handling</label>
                        <input type="number" class="form-control" id="handling" name="handling" value="<?php echo $row['handling']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="kicking" class="form-label">Kicking</label>
                        <input type="number" class="form-control" id="kicking" name="kicking" value="<?php echo $row['kicking']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="reflexes" class="form-label">Reflexes</label>
                        <input type="number" class="form-control" id="reflexes" name="reflexes" value="<?php echo $row['reflexes']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="speed" class="form-label">Speed</label>
                        <input type="number" class="form-control" id="speed" name="speed" value="<?php echo $row['speed']; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="positioning" class="form-label">Positioning</label>
                        <input type="number" class="form-control" id="positioning" name="positioning" value="<?php echo $row['positioning']; ?>">
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" form="form-player" class="btn btn-success" name="update_player" value="Update">
    </form>

    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleFields() {
            var position = document.getElementById('position').value;
            var fieldStats = document.getElementById('field-stats');
            var gkStats = document.getElementById('gk-stats');

            if (position === 'GK') {
                fieldStats.style.display = 'none';
                gkStats.style.display = 'block';
            } else if (position !== 'Select Position') {
                fieldStats.style.display = 'block';
                gkStats.style.display = 'none';
            } else {
                fieldStats.style.display = 'none';
                gkStats.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', toggleFields);
    </script>
    <script src="../frontend/script.js"></script>
</body>