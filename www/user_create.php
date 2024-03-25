<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  echo "You are not logged in, please login. ";
  echo "<a href='login.php'>Login here</a>";
  exit;
}

if ($_SESSION['rol'] != 'admin' && $_SESSION['rol'] != 'employee') {
  echo "U bent niet bevoegd om deze pagina te bekijken, login in als admin of medewerker!";
  exit;
}

require 'database.php';


// $sql = "SELECT * FROM gebruiker INNER JOIN adres ON gebruiker.adres_id = adres.adres_id WHERE gebruiker.gebruiker_id = $user_id";
// $stmt = $conn->prepare($sql);
// $stmt->execute();
// $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

require 'header.php';
?>

<main>
  <div class="container">
    <div class="container_width">
      <section class="form_align">
        <form action="user_create_session.php" method="post">
          <h1 class="form_head">Account toevoegen</h1>
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
          <div class="form_group">
            <label for="email">E-mail</label>
            <?php if (isset($_GET['email'])) { ?>
              <input type="email" name="email" id="email" value="<?php echo $_GET['email']; ?>">
            <?php } else { ?>
              <input type="text" name="email" id="email" placeholder="Email">
            <?php } ?>
          </div>
          <div class="form_group">
            <!-- for="" is voor het drukken op de naam / label, dan wordt de input automatisch aangetikt -->
            <label for="voornaam">Voornaam</label>
            <?php if (isset($_GET['voornaam'])) { ?>
              <input type="text" name="voornaam" id="voornaam" value="<?php echo $_GET['voornaam']; ?>">
            <?php } else { ?>
              <input type="text" name="voornaam" id="voornaam" placeholder="Voornaam">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="tussenvoegsel">Tussenvoegsel</label>
            <?php if (isset($_GET['tussenvoegsel'])) { ?>
              <input type="text" name="tussenvoegsel" id="tussenvoegsel" value="<?php echo $_GET['tussenvoegsel']; ?>">
            <?php } else { ?>
              <input type="text" name="tussenvoegsel" id="tussenvoegsel" placeholder="Tussenvoegsel">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="achternaam">Achternaam</label>
            <?php if (isset($_GET['achternaam'])) { ?>
              <input type="text" name="achternaam" id="achternaam" value="<?php echo $_GET['achternaam']; ?>">
            <?php } else { ?>
              <input type="text" name="achternaam" id="achternaam" placeholder="Achternaam">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="land">land</label>
            <?php if (isset($_GET['land'])) { ?>
              <input type="text" name="land" id="land" value="<?php echo $_GET['land']; ?>">
            <?php } else { ?>
              <input type="text" name="land" id="land" placeholder="Land">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="postcode">Postcode</label>
            <?php if (isset($_GET['postcode'])) { ?>
              <input type="text" name="postcode" id="postcode" value="<?php echo $_GET['postcode']; ?>">
            <?php } else { ?>
              <input type="text" name="postcode" id="postcode" placeholder="Postcode">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="woonplaats">Woonplaats</label>
            <?php if (isset($_GET['woonplaats'])) { ?>
              <input type="text" name="woonplaats" id="woonplaats" value="<?php echo $_GET['woonplaats']; ?>">
            <?php } else { ?>
              <input type="text" name="woonplaats" id="woonplaats" placeholder="Woonplaats">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="straat">Straat</label>
            <?php if (isset($_GET['straat'])) { ?>
              <input type="text" name="straat" id="straat" value="<?php echo $_GET['straat']; ?>">
            <?php } else { ?>
              <input type="text" name="straat" id="straat" placeholder="Straat">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="huisnummer">Huisnummer</label>
            <?php if (isset($_GET['huisnummer'])) { ?>
              <input type="text" name="huisnummer" id="huisnummer" value="<?php echo $_GET['huisnummer']; ?>">
            <?php } else { ?>
              <input type="text" name="huisnummer" id="huisnummer" placeholder="Huisnummer">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="toevoeging">Toevoeging</label>
            <?php if (isset($_GET['toevoeging'])) { ?>
              <input type="text" name="toevoeging" id="toevoeging" value="<?php echo $_GET['toevoeging']; ?>">
            <?php } else { ?>
              <input type="text" name="toevoeging" id="toevoeging" placeholder="Toevoeging">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="wachtwoord">Wachtwoord</label>
            <input type="password" name="wachtwoord" id="wachtwoord" placeholder="wachtwoord">
          </div>
          <div class="form_group">
            <label for="check_wachtwoord">Herhaal wachtwoord</label>
            <input type="password" name="check_wachtwoord" id="check_wachtwoord" placeholder="herhaal wachtwoord">
          </div>
            <div class="form_group_radio">
              <input type="radio" id="rol1" name="rol" value="admin">
              <label for="rol1">Admin</label>
            </div>
            <div class="form_group_radio">
              <input type="radio" id="rol2" name="rol" value="employee">
              <label for="rol2">Employee</label>
            </div>
            <div class="form_group_radio">
              <input type="radio" id="rol3" name="rol" value="customer">
              <label for="rol3">Customer</label>
            </div>
          <div>
            <button class="button_submit" type="sumbit">Maak nieuwe gebruiker</button>
          </div>
        </form>
      </section>
    </div>
  </div>
</main>
<?php require 'footer.php' ?>