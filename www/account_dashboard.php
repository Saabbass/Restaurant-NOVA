<?php
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
  require 'database.php';

  $user_id = $_SESSION['user_id'];

  $sql = "SELECT * FROM gebruiker INNER JOIN adres ON gebruiker.adres_id = adres.adres_id WHERE gebruiker.gebruiker_id = $user_id";

  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $account = $stmt->fetch(PDO::FETCH_ASSOC);

?>

  <!-- begin ingoegen van navbar / header -->
  <?php
  require 'header.php';
  ?>
  <!-- einde invoegen van navbar / header -->
  <section class="home_main">
    <section class="container_img">
      <div class="container">
        <div class="container_width">
          <section class="container_scroll">
            <div class="scroll_top">
              <!-- <div class="topnav"> -->
              <!-- <ul class="topmenu">
                  <li <?php if ($_SERVER['SCRIPT_NAME'] == "/account_dashboard.php") { ?> class="active" <?php   }  ?>><a href="account_dashboard.php"><b>Bienvenue</b></a></li>
                  <li <?php if ($_SERVER['SCRIPT_NAME'] == "/user_index.php") { ?> class="active" <?php   }  ?>><a href="user_index.php"><b>Livres</b></a></li>
                  <li <?php if ($_SERVER['SCRIPT_NAME'] == "/bibliotheque.php") { ?> class="active" <?php   }  ?>><a href="bibliotheque.php"><b>Bibliothèque</b></a></li>
                  <li <?php if ($_SERVER['SCRIPT_NAME'] == "/universite.php") { ?> class="active" <?php   }  ?>><a href="universite.php"><b>L'université</b></a></li>
                  <li <?php if ($_SERVER['SCRIPT_NAME'] == "/contact.php") { ?> class="active" <?php   }  ?>><a href="contact.php"><b>Contact</b></a></li>
                </ul> -->

              <?php if ($data == 'admin' || $data == 'employee') { ?>
                <a class="btn-info" href="user_create.php">Maak gebruiker aan</a>
              <?php } ?>
              <div>
                <?php if (isset($_GET['error'])) { ?>
                  <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>
              </div>
              <div>
                <?php if (isset($_GET['success'])) { ?>
                  <p class="success"><?php echo $_GET['success']; ?></p>
                <?php } ?>
              </div>
              <!-- </div> -->
            </div>
            <div class="account_wrapper">
              <div class="account_welcome">
                <h1>Welkom, <?php echo $account['gebruiker_voornaam'] ?></h1>
              </div>
              <div class="account_inner">
                <div class="account_info">
                  <p>Email:</p>
                  <p>Voornaam:</p>
                  <p>Tussenvoegsel:</p>
                  <p>Achternaam:</p>
                  <p>Land:</p>
                  <p>Postcode:</p>
                  <p>Woonplaats:</p>
                  <p>Straat:</p>
                  <p>Huisnummer:</p>
                  <p>Toevoeging:</p>
                  <?php if ($data == 'admin' || $data == 'employee') { ?>
                    <p>Rol:</p>
                  <?php } ?>
                </div>
                <div class="account_info">
                  <p><?php echo $account['email'] ?></p>
                  <p><?php echo $account['gebruiker_voornaam'] ?></p>
                  <p><?php echo $account['gebruiker_tussenvoegsel'] ?></p>
                  <p><?php echo $account['gebruiker_achternaam'] ?></p>
                  <p><?php echo $account['land'] ?></p>
                  <p><?php echo $account['postcode'] ?></p>
                  <p><?php echo $account['woonplaats'] ?></p>
                  <p><?php echo $account['straat'] ?></p>
                  <p><?php echo $account['huisnummer'] ?></p>
                  <p><?php echo $account['toevoeging'] ?></p>
                  <?php if ($data == 'admin' || $data == 'employee') { ?>
                    <p><?php echo $account['rol'] ?></p>
                  <?php } ?>
                </div>
              </div>
              <div class="account_btns">
                <a href="user_delete.php?id=<?php echo $account['gebruiker_id'] ?>" class="btn-delete">delete</a>
                <a href="user_update.php?id=<?php echo $account['gebruiker_id'] ?>" class="btn-update">update</a>
              </div>
            </div>

            <!-- <table>
              <thead>
                <tr>
                  <th>Email</th>
                  <th>Voornaam</th>
                  <th>Tussenvoegsel</th>
                  <th>Achternaam</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $account['email'] ?></td>
                  <td><?php echo $account['gebruiker_voornaam'] ?></td>
                  <td><?php echo $account['gebruiker_tussenvoegsel'] ?></td>
                  <td><?php echo $account['gebruiker_achternaam'] ?></td>
                </tr>
              <tbody>
                <thead>
                  <tr>
                    <th>Land</th>
                    <th>Postcode</th>
                    <th>Woonplaats</th>
                    <th>Straat</th>
                    <th>Huisnummer</th>
                    <th>Toevoeging</th>
                  </tr>
                </thead>

              </tbody>
              <tr>
                <td><?php echo $account['land'] ?></td>
                <td><?php echo $account['postcode'] ?></td>
                <td><?php echo $account['woonplaats'] ?></td>
                <td><?php echo $account['straat'] ?></td>
                <td><?php echo $account['huisnummer'] ?></td>
                <td><?php echo $account['toevoeging'] ?></td>
                <td>
                  <a href="user_delete.php?id=<?php echo $account['gebruiker_id'] ?>" class="btn-delete">delete</a>
                  <a href="updateUser.php?id=<?php echo $account['gebruiker_id'] ?>" class="btn-update">update</a>
                </td>
              </tr>
              </tbody>
            </table> -->
          </section>
        </div>
      </div>
    </section>
  </section>
  <!-- begin footer -->
  <?php
  require 'footer.php';
  ?>
  <!-- einde footer -->
<?php
} else {
  header("Location: index.php");
  exit();
}
?>