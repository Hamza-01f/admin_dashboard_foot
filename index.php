<!DOCTYPE html>
<html lang="en">
<?php
    include_once __DIR__."/my_php_project/config/db_connection.php";

    $sql_rq = "SELECT players.id, 
                      name_player, 
                      position, 
                      rating, 
                      photo, 
                      nationality.nationality, 
                      nationality.flag, club.logo, 
                      club.club_name,

                      players_fields.pace, 
                      players_fields.shooting, 
                      players_fields.passing, 
                      players_fields.dribbling, 
                      players_fields.defending, 
                      players_fields.physical,

                      gk_fields.diving, 
                      gk_fields.handling, 
                      gk_fields.kicking, 
                      gk_fields.reflexes, 
                      gk_fields.speed, 
                      gk_fields.positioning

                      FROM players 
                      INNER JOIN nationality ON players.nationality_id = nationality.id
                      INNER JOIN club ON players.club_id = club.id

                      LEFT JOIN  players_fields ON players.id = players_fields.players_id
                      LEFT JOIN gk_fields ON players.id = gk_fields.players_id
    ;";
    $query = mysqli_query($connection, $sql_rq);

    if (!$query) {
        die("Query failed: " . mysqli_error($connection));
    }
    if(isset($_GET['insert_msg'])){
      echo $_GET['insert_msg'];
    }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./frontend/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
<nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="images/logo.png" alt="">
            </div>

            <span class="logo_name">FutChampions</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="#">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">squad plane</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Analytics</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-thumbs-up"></i>
                    <span class="link-name">favorits players</span>
                </a></li>
            </ul>
            <button type="button" class="bg-blue-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105" data-bs-toggle="modal" data-bs-target="#addPlayerModal">
                            ADD PLAYER
           </button>
            <ul class="logout-mode">
                <li><a href="#">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>
    <div class="dashboard">
    <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
            
            <img src="images/profile.jpg" alt="">
        </div>
        <div class="mt-20">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Players Info</h2>
            <div class="overflow-x-auto bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-lg shadow-lg p-4 mb-8">
                <table class="table-auto w-full text-white text-sm">
                    <thead class="bg-gradient-to-r from-blue-700 to-blue-500 text-xl text-white">
                        <tr>
                            <th class="px-4 py-2 border-b border-gray-300">Number</th>
                            <th class="px-4 py-2 border-b border-gray-300">Name</th>
                            <th class="px-4 py-2 border-b border-gray-300">Position</th>
                            <th class="px-4 py-2 border-b border-gray-300">Rating</th>
                            <th class="px-4 py-2 border-b border-gray-300">Photo</th>
                            <th class="px-4 py-2 border-b border-gray-300">Nationality</th>
                            <th class="px-4 py-2 border-b border-gray-300">Flag</th>
                            <th class="px-4 py-2 border-b border-gray-300">Club</th>
                            <th class="px-4 py-2 border-b border-gray-300">Logo</th>
                            <th class="px-4 py-2 border-b border-gray-300">Pace</th>
                            <th class="px-4 py-2 border-b border-gray-300">Shooting</th>
                            <th class="px-4 py-2 border-b border-gray-300">Passing</th>
                            <th class="px-4 py-2 border-b border-gray-300">Dribbling</th>
                            <th class="px-4 py-2 border-b border-gray-300">Defending</th>
                            <th class="px-4 py-2 border-b border-gray-300">Physical</th>
                            <th class="px-4 py-2 border-b border-gray-300">Action</th>
                        </tr>
                    </thead>
                    <tbody class="transition duration-500 ease-in-out transform hover:scale-105">
                        <?php
                        if (mysqli_num_rows($query) > 0) {
                            $cont = 1;
                            while ($row = mysqli_fetch_array($query)) {
                                if ($row['position'] != 'GK') {
                                    ?>
                                    <tr class=" hover:bg-gray-500 transition-colors duration-300">
                                        <td class="px-4 py-2 border-b text-center"><?php echo $cont; ?></td>
                                        <td class="px-4 py-2 border-b"><?php echo $row['name_player']; ?></td>
                                        <td class="px-4 py-2 border-b"><?php echo $row['position']; ?></td>
                                        <td class="px-4 py-2 border-b"><?php echo $row['rating']; ?></td>
                                        <td class="px-4 py-2 border-b text-center"><img src="<?php echo $row['photo']; ?>" alt="Player Photo" class="rounded-full h-10 w-10 object-cover"></td>
                                        <td class="px-4 py-2 border-b"><?php echo $row['nationality']; ?></td>
                                        <td class="px-4 py-2 border-b text-center"><img src="<?php echo $row['flag']; ?>" alt="Country Flag" class="rounded-full h-10 w-10 object-cover"></td>
                                        <td class="px-4 py-2 border-b"><?php echo $row['club_name']; ?></td>
                                        <td class="px-4 py-2 border-b text-center"><img src="<?php echo $row['logo']; ?>" alt="Club Logo" class="h-10 w-10 object-cover"></td>
                                        <td class="px-4 py-2 border-b"><?php echo $row['pace']; ?></td>
                                        <td class="px-4 py-2 border-b"><?php echo $row['shooting']; ?></td>
                                        <td class="px-4 py-2 border-b"><?php echo $row['passing']; ?></td>
                                        <td class="px-4 py-2 border-b"><?php echo $row['dribbling']; ?></td>
                                        <td class="px-4 py-2 border-b"><?php echo $row['defending']; ?></td>
                                        <td class="px-4 py-2 border-b"><?php echo $row['physical']; ?></td>
                                        <td class="px-4 py-2 border-b text-center">
                                            <a href="/php/update.php?editid=<?php echo htmlentities($row['id']); ?>" class="text-blue-600 hover:text-blue-800 transition duration-300 ease-in-out">
                                                <svg height="35" width="35" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                                </svg>
                                            </a>
                                            <a href="php/delete.php?delid=<?php echo htmlentities($row['id']); ?>" class="text-red-600 hover:text-red-800 transition duration-300 ease-in-out" onclick="return confirm('Do you really want to delete?');">
                                                <svg height="35" width="35" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                    <path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    $cont++;
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
     </div>
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Goalkeepers Info</h2>
    <div class="overflow-x-auto bg-gradient-to-r from-green-500 via-teal-500 to-blue-500 rounded-lg shadow-lg p-4">
        <table class="table-auto w-full text-white text-sm">
            <thead class="bg-gradient-to-r from-blue-700 to-blue-500 text-xl text-white">
                <tr>
                    <th class="px-4 py-2 border-b border-gray-300">Number</th>
                    <th class="px-4 py-2 border-b border-gray-300">Name</th>
                    <th class="px-4 py-2 border-b border-gray-300">Position</th>
                    <th class="px-4 py-2 border-b border-gray-300">Rating</th>
                    <th class="px-4 py-2 border-b border-gray-300">Photo</th>
                    <th class="px-4 py-2 border-b border-gray-300">Nationality</th>
                    <th class="px-4 py-2 border-b border-gray-300">Flag</th>
                    <th class="px-4 py-2 border-b border-gray-300">Club</th>
                    <th class="px-4 py-2 border-b border-gray-300">Logo</th>
                    <th class="px-4 py-2 border-b border-gray-300">Diving</th>
                    <th class="px-4 py-2 border-b border-gray-300">Handling</th>
                    <th class="px-4 py-2 border-b border-gray-300">Kicking</th>
                    <th class="px-4 py-2 border-b border-gray-300">Reflexes</th>
                    <th class="px-4 py-2 border-b border-gray-300">Speed</th>
                    <th class="px-4 py-2 border-b border-gray-300">Positioning</th>
                    <th class="px-4 py-2 border-b border-gray-300">Action</th>
                </tr>
            </thead>
            <tbody class="transition duration-500 ease-in-out transform hover:scale-105">
                <?php
                mysqli_data_seek($query, 0);
                if (mysqli_num_rows($query) > 0) {
                    $cont = 1;
                    while ($row = mysqli_fetch_array($query)) {
                        if ($row['position'] == 'GK') {
                            ?>
                            <tr class=" hover:bg-gray-500 transition-colors duration-300">
                                <td class="px-4 py-2 border-b text-center"><?php echo $cont; ?></td>
                                <td class="px-4 py-2 border-b"><?php echo $row['name_player']; ?></td>
                                <td class="px-4 py-2 border-b"><?php echo $row['position']; ?></td>
                                <td class="px-4 py-2 border-b"><?php echo $row['rating']; ?></td>
                                <td class="px-4 py-2 border-b text-center"><img src="<?php echo $row['photo']; ?>" alt="Player Photo" class="rounded-full h-10 w-10 object-cover"></td>
                                <td class="px-4 py-2 border-b"><?php echo $row['nationality']; ?></td>
                                <td class="px-4 py-2 border-b text-center"><img src="<?php echo $row['flag']; ?>" alt="Country Flag" class="rounded-full h-10 w-10 object-cover"></td>
                                <td class="px-4 py-2 border-b"><?php echo $row['club_name']; ?></td>
                                <td class="px-4 py-2 border-b text-center"><img src="<?php echo $row['logo']; ?>" alt="Club Logo" class="h-10 w-10 object-cover"></td>
                                <td class="px-4 py-2 border-b"><?php echo $row['diving']; ?></td>
                                <td class="px-4 py-2 border-b"><?php echo $row['handling']; ?></td>
                                <td class="px-4 py-2 border-b"><?php echo $row['kicking']; ?></td>
                                <td class="px-4 py-2 border-b"><?php echo $row['reflexes']; ?></td>
                                <td class="px-4 py-2 border-b"><?php echo $row['speed']; ?></td>
                                <td class="px-4 py-2 border-b"><?php echo $row['positioning']; ?></td>
                                <td class="px-4 py-2 border-b text-center">
                                    <a href="/php/update.php?editid=<?php echo htmlentities($row['id']); ?>" class="text-blue-600 hover:text-blue-800 transition duration-300 ease-in-out">
                                        <svg height="35" width="35" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                        </svg>
                                    </a>
                                    <a href="php/delete.php?delid=<?php echo htmlentities($row['id']); ?>" class="text-red-600 hover:text-red-800 transition duration-300 ease-in-out" onclick="return confirm('Do you really want to delete?');">
                                        <svg height="35" width="35" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            <?php
                            $cont++;
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addPlayerModal" tabindex="-1" aria-labelledby="addPlayerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="addPlayerModalLabel">Add New Player</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="form-player" class="needs-validation" action="./php/addplayer.php" method="POST" novalidate>
          <div class="row g-3">                               
              <div class="col-md-6">
                  <label for="name_player" class="form-label">Player Name</label>
                  <input type="text" class="form-control" name="name_player">
                  <div class="invalid-feedback">Please provide a player name.</div>
              </div>
              <div class="col-md-6">
                  <label for="position" class="form-label">Position</label>
                  <select class="form-control" id="position" name="position">
                      <option>Select Position</option>
                      <option value="GK">GK</option>
                      <option value="CB">CB</option>
                      <option value="CM">Midfielder</option>
                      <option value="LW">LW</option>
                      <option value="ST">ST</option>
                      <option value="RW">RW</option>
                  </select>
                  <div class="invalid-feedback">Please select a position.</div>
              </div>
              <div class="col-md-6">
                  <label for="rating" class="form-label">Rating</label>
                  <input type="number" class="form-control" id="rating" name="rating" min="1" max="99">
                  <div class="invalid-feedback">Please provide a rating between 1 and 99.</div>
              </div>
              <div class="col-md-6">
                  <label for="photo" class="form-label">Photo URL</label>
                  <input type="url" class="form-control" id="photo" name="photo">
                  <div class="invalid-feedback">Please provide a valid URL for the photo.</div>
              </div>
              <div class="col-md-6">
                  <label for="nationality" class="form-label">Nationality</label>
                  <select class="form-control"  name="nationality">
                     <option>Select Nationality</option>
                      <option value="144">Argentina</option>
                      <option value="145">Portugal</option>
                      <option value="146">belguim</option>
                      <option value="147">France</option>
                      <option value="148">Netherlands</option>
                      <option value="149">Germany</option>
                      <option value="150">Egypt</option>
                      <option value="151">Croatia</option>
                      <option value="152">Morocco</option>
                      <option value="153">Norway</option>
                      <option value="154">Canada</option>
                  </select>
              </div>
              <div class="col-md-6">
                  <label for="club" class="form-label">Club</label>
                  <select class="form-control"  name="club">
                      <option>Select Club</option>
                      <option value="61">Inter Miami</option>
                      <option value="62">Al Nassr</option>
                      <option value="63">Manchester City</option>
                      <option value="64">Real Madrid</option>
                      <option value="65">Al Hilal</option>
                      <option value="66">Liverpool</option>
                      <option value="67">Bayern Munich</option>
                      <option value="68">Atletico Madrid</option>
                      <option value="69">Al-Ittihad</option>
                      <option value="70">Manchester United</option>
                  </select>
              </div>
              <div id="field-stats" class="col-12" style="display: none;">
                  <div class="row">
                      <div class="col-md-4">
                          <label for="pace" class="form-label">Pace</label>
                          <input type="number" class="form-control" id="pace" name="pace">
                      </div>
                      <div class="col-md-4">
                          <label for="shooting" class="form-label">Shooting</label>
                          <input type="number" class="form-control" id="shooting" name="shooting">
                      </div>
                      <div class="col-md-4">
                          <label for="passing" class="form-label">Passing</label>
                          <input type="number" class="form-control" id="passing" name="passing">
                      </div>
                      <div class="col-md-4">
                          <label for="dribbling" class="form-label">Dribbling</label>
                          <input type="number" class="form-control" id="dribbling" name="dribbling">
                      </div>
                      <div class="col-md-4">
                          <label for="defending" class="form-label">Defending</label>
                          <input type="number" class="form-control" id="defending" name="defending">
                      </div>
                      <div class="col-md-4">
                          <label for="physical" class="form-label">Physical</label>
                          <input type="number" class="form-control" id="physical" name="physical">
                      </div>
                  </div>
              </div>
              <div id="gk-stats" class="col-12" style="display: none;">
                  <div class="row">
                      <div class="col-md-4">
                          <label for="diving" class="form-label">Diving</label>
                          <input type="number" class="form-control" id="diving" name="diving">
                      </div>
                      <div class="col-md-4">
                          <label for="handling" class="form-label">Handling</label>
                          <input type="number" class="form-control" id="handling" name="handling">
                      </div>
                      <div class="col-md-4">
                          <label for="kicking" class="form-label">Kicking</label>
                          <input type="number" class="form-control" id="kicking" name="kicking">
                      </div>
                      <div class="col-md-4">
                          <label for="reflexes" class="form-label">Reflexes</label>
                          <input type="number" class="form-control" id="reflexes" name="reflexes">
                      </div>
                      <div class="col-md-4">
                          <label for="speed" class="form-label">Speed</label>
                          <input type="number" class="form-control" id="speed" name="speed">
                      </div>
                      <div class="col-md-4">
                          <label for="positioning" class="form-label">Positioning</label>
                          <input type="number" class="form-control" id="positioning" name="positioning">
                      </div>
                  </div>
              </div>
          </div>
      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input href="index.php" type="submit" form="form-player" class="btn btn-success" name="add_player" value="ADD Player"> 
      </div>
    </div>
  </div>
</div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="./frontend/script.js"></script>
</html>

