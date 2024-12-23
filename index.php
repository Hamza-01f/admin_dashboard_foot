<!DOCTYPE html>
<html lang="en">
<?php
    include_once __DIR__."/my_php_project/config/db_connection.php";

    $sql_rq = "SELECT players.id, name_player, position, rating, photo, nationality.nationality, nationality.flag, club.logo, club.club_name
    FROM players 
    INNER JOIN nationality ON players.nationality_id = nationality.id
    INNER JOIN club ON players.club_id = club.id
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
        <div class="dash-content">
        <table class="table container-fluid">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                    <th scope="col">position</th>
                    <th scope="col">rating</th>
                    <th scope="col">photo</th>
                    <th scope="col">nationality</th>
                    <th scope="col">flag</th>
                    <th scope="col">club</th>
                    <th scope="col">logo</th>
                    <th><button type='button' class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#addPlayerModal">ADD Player</button></th>
                </tr>
            </thead>
            <tbody>
                <?
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                      echo "<th>".$row['id']."</th>";
                      echo "<th>".$row['name_player']."</th>";
                      echo "<th>".$row['position']."</th>";
                      echo "<th>".$row['rating']."</th>";
                      echo "<td><img src='".$row['photo']."' alt='Club Logo' style='width:50px; height:50px;'></td>";
                      echo "<th>".$row['nationality']."</th>";
                      echo "<td><img src='".$row['flag']."' alt='Club Logo' style='width:35px; height:25px;'></td>";
                      echo "<td>".$row['club_name']."</td>";
                      echo "<td><img src='".$row['logo']."' alt='Club Logo' style='width:50px; height:50px;'></td>";
                      echo "<td>
                      <button type='button' class='btn btn-warning'>
                          <a class='list-group-item list-group-item-action' href='./php/update.php?id=" . $row['id'] . "'>Modifier</a>
                      </button>
                      <button type='button' class='btn btn-danger'>
                          <a class='list-group-item list-group-item-action' href='./php/delete.php?id=" . $row['id'] . "'>SUPPRIMER</a>
                      </button>
                  </td>";
                  
                  
                      echo "</tr>";
                }
                mysqli_close($connection);
                ?>
            </tbody>
        </table>
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
                      <option value="146">belguim</option>
                      <option value="145">Portugal</option>
                      <option value="144">Argentina</option>
                      <option value="152">Morocco</option>
                      <option value="147">France</option>
                  </select>
                  <div class="invalid-feedback">Please select a Nationality.</div>
              </div>
              <div class="col-md-6">
                  <label for="flag" class="form-label">Flag URL</label>
                  <input type="url" class="form-control"  name="flag">
                  <div class="invalid-feedback">Please provide a valid URL for the flag.</div>
              </div>
              <div class="col-md-6">
                  <label for="club" class="form-label">Club</label>
                  <select class="form-control"  name="club">
                      <option>Select Club</option>
                      <option value="63">Manchester City</option>
                      <option value="64">Real Madrid</option>
                      <option value="66">Liverpool</option>
                      <option value="70">Manchester United</option>
                      <option value="67">Bayern Munich</option>
                  </select>
                  <div class="invalid-feedback">Please select a Club.</div>
              </div>
              <div class="col-md-6">
                  <label for="logo" class="form-label">Club URL</label>
                  <input type="url" class="form-control" name="logo">
                  <div class="invalid-feedback">Please provide a valid URL for the Club.</div>
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
        <input type="submit" form="form-player" class="btn btn-success" name="add_player" value="ADD Player">
        
      </div>
    </div>
  </div>
</div>
    <!--  -->
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="./frontend/script.js"></script>
</html>

