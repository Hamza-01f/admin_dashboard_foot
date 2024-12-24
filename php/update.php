<?php
ob_start();
include_once __DIR__ . "/../my_php_project/config/db_connection.php";
if (isset($_GET["editid"])) {
    $id = $_GET["editid"];

//     $request = "
//     SELECT p.*, n.nationality, n.flag, c.club_name, c.logo, gf.*, pf.*
//     FROM players p
//     INNER JOIN nationality n ON p.nationality_id = n.id
//     INNER JOIN club c ON p.club_id = c.id
//     LEFT JOIN gk_fields gf ON p.id = gf.players_id
//     LEFT JOIN players_fields pf ON p.id = pf.players_id
//     WHERE p.id = '$id'
// ";
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
    <title>Update Player</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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

            $gk_update_query = "UPDATE gk_fields SET
                        diving='$fdiving',
                        handling='$fhandling',
                        kicking='$fkicking',
                        reflexes='$freflexes',
                        speed='$fspeed',
                        positioning='$fpositioning'
                        WHERE id='$id'";

            $result = mysqli_query($connection, $gk_update_query);
        } else {
            $fpace = $_POST['pace'];
            $fshooting = $_POST['shooting'];
            $fpassing = $_POST['passing'];
            $fdribbling = $_POST['dribbling'];
            $fdefending = $_POST['defending'];
            $fphysical = $_POST['physical'];

            $field_update_query = "UPDATE players_fields SET
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
        header('location:./../index.php');
        ob_end_flush();
        exit();
    }
}
?>

<body class="bg-gray-100">

    <div class="container mx-auto py-8">
        <form id="form-player" class="bg-white shadow-lg rounded-lg p-8" method="POST" novalidate>
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name_player" class="block text-lg font-medium text-gray-700">Player Name</label>
                    <input type="text" name="name_player" value="<?php echo $row['name_player']; ?>" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="text-sm text-red-500 mt-1 hidden">Please provide a player name.</div>
                </div>
                <div>
                    <label for="position" class="block text-lg font-medium text-gray-700">Position</label>
                    <select class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="position" onchange="toggleFields()">
                        <option>Select Position</option>
                        <option value="GK" <?php echo ($row['position'] == 'GK') ? 'selected' : ''; ?>>GK</option>
                        <option value="CB" <?php echo ($row['position'] == 'CB') ? 'selected' : ''; ?>>CB</option>
                        <option value="MC" <?php echo ($row['position'] == 'MC') ? 'selected' : ''; ?>>MC</option>
                        <option value="LW" <?php echo ($row['position'] == 'LW') ? 'selected' : ''; ?>>LW</option>
                        <option value="ST" <?php echo ($row['position'] == 'ST') ? 'selected' : ''; ?>>ST</option>
                        <option value="RW" <?php echo ($row['position'] == 'RW') ? 'selected' : ''; ?>>RW</option>
                    </select>
                    <div class="text-sm text-red-500 mt-1 hidden">Please select a position.</div>
                </div>
                <div>
                    <label for="rating" class="block text-lg font-medium text-gray-700">Rating</label>
                    <input type="number" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="rating" min="1" max="99" value="<?php echo $row['rating']; ?>">
                    <div class="text-sm text-red-500 mt-1 hidden">Please provide a rating between 1 and 99.</div>
                </div>
                <div>
                    <label for="photo" class="block text-lg font-medium text-gray-700">Photo URL</label>
                    <input type="url" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="photo" value="<?php echo $row['photo']; ?>">
                    <div class="text-sm text-red-500 mt-1 hidden">Please provide a valid URL for the photo.</div>
                </div>
                <div>
                    <label for="nationality" class="block text-lg font-medium text-gray-700">Nationality</label>
                    <select class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="nationality">
                        <option>Select Nationality</option>
                        <option value="144" <?php echo ($row['nationality_id'] == 144) ? 'selected' : ''; ?>>Argentina</option>
                        <option value="145" <?php echo ($row['nationality_id'] == 145) ? 'selected' : ''; ?>>Portugal</option>
                        <option value="146" <?php echo ($row['nationality_id'] == 146) ? 'selected' : ''; ?>>Belgium</option>
                        <option value="147" <?php echo ($row['nationality_id'] == 147) ? 'selected' : ''; ?>>France</option>
                        <option value="148" <?php echo ($row['nationality_id'] == 148) ? 'selected' : ''; ?>>Netherlands</option>
                        <option value="149" <?php echo ($row['nationality_id'] == 149) ? 'selected' : ''; ?>>Germany</option>
                        <option value="150" <?php echo ($row['nationality_id'] == 150) ? 'selected' : ''; ?>>Egypt</option>
                        <option value="151" <?php echo ($row['nationality_id'] == 151) ? 'selected' : ''; ?>>Croatia</option>
                        <option value="152" <?php echo ($row['nationality_id'] == 152) ? 'selected' : ''; ?>>Morocco</option>
                        <option value="153" <?php echo ($row['nationality_id'] == 153) ? 'selected' : ''; ?>>Norway</option>
                        <option value="154" <?php echo ($row['nationality_id'] == 154) ? 'selected' : ''; ?>>Canada</option>
                    </select>
                    <div class="text-sm text-red-500 mt-1 hidden">Please select a Nationality.</div>
                </div>
                <div>
                    <label for="flag" class="block text-lg font-medium text-gray-700">Flag URL</label>
                    <input type="url" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="flag" value="<?php echo $row['flag']; ?>">
                    <div class="text-sm text-red-500 mt-1 hidden">Please provide a valid URL for the flag.</div>
                </div>
                <div>
                    <label for="club" class="block text-lg font-medium text-gray-700">Club</label>
                    <select class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="club">
                        <option>Select Club</option>
                        <option value="61" <?php echo ($row['club_id'] == 61) ? 'selected' : ''; ?>>Inter Miami</option>
                        <option value="62" <?php echo ($row['club_id'] == 62) ? 'selected' : ''; ?>>Al Nassr</option>
                        <option value="63" <?php echo ($row['club_id'] == 63) ? 'selected' : ''; ?>>Manchester City</option>
                        <option value="64" <?php echo ($row['club_id'] == 64) ? 'selected' : ''; ?>>Real Madrid</option>
                        <option value="65" <?php echo ($row['club_id'] == 65) ? 'selected' : ''; ?>>Al Hilal</option>
                        <option value="66" <?php echo ($row['club_id'] == 66) ? 'selected' : ''; ?>>Liverpool</option>
                        <option value="67" <?php echo ($row['club_id'] == 67) ? 'selected' : ''; ?>>Bayern Munich</option>
                        <option value="68" <?php echo ($row['club_id'] == 68) ? 'selected' : ''; ?>>Atletico Madrid</option>
                        <option value="69" <?php echo ($row['club_id'] == 69) ? 'selected' : ''; ?>>Al-Ittihad</option>
                        <option value="70" <?php echo ($row['club_id'] == 70) ? 'selected' : ''; ?>>Manchester United</option>
                    </select>
                    <div class="text-sm text-red-500 mt-1 hidden">Please select a Club.</div>
                </div>
                <div>
                    <label for="logo" class="block text-lg font-medium text-gray-700">Club URL</label>
                    <input type="url" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="logo" value="<?php echo isset($row['logo']) ? $row['logo'] : ''; ?>">
                    <div class="text-sm text-red-500 mt-1 hidden">Please provide a valid URL for the Club.</div>
                </div>
            </div>

            <div id="field-stats" class="mt-6" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="pace" class="block text-lg font-medium text-gray-700">Pace</label>
                        <input type="number" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="pace" name="pace" value="<?php echo $row['pace']; ?>">
                    </div>
                    <div>
                        <label for="shooting" class="block text-lg font-medium text-gray-700">Shooting</label>
                        <input type="number" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="shooting" name="shooting" value="<?php echo $row['shooting']; ?>">
                    </div>
                    <div>
                        <label for="passing" class="block text-lg font-medium text-gray-700">Passing</label>
                        <input type="number" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="passing" name="passing" value="<?php echo $row['passing']; ?>">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div>
                        <label for="dribbling" class="block text-lg font-medium text-gray-700">Dribbling</label>
                        <input type="number" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="dribbling" name="dribbling" value="<?php echo $row['dribbling']; ?>">
                    </div>
                    <div>
                        <label for="defending" class="block text-lg font-medium text-gray-700">Defending</label>
                        <input type="number" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="defending" name="defending" value="<?php echo $row['defending']; ?>">
                    </div>
                    <div>
                        <label for="physical" class="block text-lg font-medium text-gray-700">Physical</label>
                        <input type="number" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="physical" name="physical" value="<?php echo $row['physical']; ?>">
                    </div>
                </div>
            </div>

            <div id="gk-stats" class="mt-6" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="diving" class="block text-lg font-medium text-gray-700">Diving</label>
                        <input type="number" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="diving" value="<?php echo $row['diving']; ?>">
                    </div>
                    <div>
                        <label for="handling" class="block text-lg font-medium text-gray-700">Handling</label>
                        <input type="number" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="handling" value="<?php echo $row['handling']; ?>">
                    </div>
                    <div>
                        <label for="kicking" class="block text-lg font-medium text-gray-700">Kicking</label>
                        <input type="number" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="kicking" value="<?php echo $row['kicking']; ?>">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div>
                        <label for="reflexes" class="block text-lg font-medium text-gray-700">Reflexes</label>
                        <input type="number" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="reflexes" value="<?php echo $row['reflexes']; ?>">
                    </div>
                    <div>
                        <label for="speed" class="block text-lg font-medium text-gray-700">Speed</label>
                        <input type="number" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="speed" value="<?php echo $row['speed']; ?>">
                    </div>
                    <div>
                        <label for="positioning" class="block text-lg font-medium text-gray-700">Positioning</label>
                        <input type="number" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="positioning" value="<?php echo $row['positioning']; ?>">
                    </div>
                </div>
            </div>

            <button type="submit" name="update_player" class="mt-8 px-6 py-3 bg-blue-500 text-white text-lg rounded-md hover:bg-blue-600">Update Player</button>
        </form>
    </div>

    <script>
        function toggleFields() {
            const position = document.querySelector('select[name="position"]').value;
            const fieldStats = document.getElementById('field-stats');
            const gkStats = document.getElementById('gk-stats');
            
            if (position === 'GK') {
                fieldStats.style.display = 'none';
                gkStats.style.display = 'block';
            } else {
                fieldStats.style.display = 'block';
                gkStats.style.display = 'none';
            }
        }
    </script>

</body>
</html>
