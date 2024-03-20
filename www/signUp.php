<!-- <!DOCTYPE html>
<html lang="en">

<head>
  <title>Nieuw Product</title>
</head>

<body> -->
  <!-- begin ingoegen van navbar / header -->
  <?php
  require 'header.php';
  ?>
  <!-- einde invoegen van navbar / header -->
  <!-- action en method zijn atributen -->
  <div class="container_img">
    <div class="container">
      <div class="container_width">
        <section class="form_align">
          <form action="session_signUp.php" method="post">
            <h1 class="form_head">Maak een nieuwe gebruiker aan</h1>
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
                <input type="text" name="email" id="email" placeholder="email">
              <?php } ?>
            </div>
            <div class="form_group">
              <!-- for="" is voor het drukken op de naam / label, dan wordt de input automatisch aangetikt -->
              <label for="voornaam">Voornaam</label>
              <?php if (isset($_GET['voornaam'])) { ?>
                <input type="text" name="voornaam" id="voornaam" value="<?php echo $_GET['voornaam']; ?>">
              <?php } else { ?>
                <input type="text" name="voornaam" id="voornaam" placeholder="voornaam">
              <?php } ?>
            </div>
            <div class="form_group">
              <label for="tussenvoegsel">Tussenvoegsel</label>
              <?php if (isset($_GET['tussenvoegsel'])) { ?>
                <input type="text" name="tussenvoegsel" id="tussenvoegsel" value="<?php echo $_GET['tussenvoegsel']; ?>">
              <?php } else { ?>
                <input type="text" name="tussenvoegsel" id="tussenvoegsel" placeholder="tussenvoegsel">
              <?php } ?>
            </div>
            <div class="form_group">
              <label for="achternaam">Achternaam</label>
              <?php if (isset($_GET['achternaam'])) { ?>
                <input type="text" name="achternaam" id="achternaam" value="<?php echo $_GET['achternaam']; ?>">
              <?php } else { ?>
                <input type="text" name="achternaam" id="achternaam" placeholder="achternaam">
              <?php } ?>
            </div>
            <div class="form_group">
              <label for="land">land</label>
              <?php if (isset($_GET['land'])) { ?>
                <input type="text" name="land" id="land" value="<?php echo $_GET['land']; ?>">
              <?php } else { ?>
                <input type="text" name="land" id="land" placeholder="land">
              <?php } ?>
            </div>
            <div class="form_group">
              <label for="postcode">Postcode</label>
              <?php if (isset($_GET['postcode'])) { ?>
                <input type="text" name="postcode" id="postcode" value="<?php echo $_GET['postcode']; ?>">
              <?php } else { ?>
                <input type="text" name="postcode" id="postcode" placeholder="postcode">
              <?php } ?>
            </div>
            <div class="form_group">
              <label for="woonplaats">Woonplaats</label>
              <?php if (isset($_GET['woonplaats'])) { ?>
                <input type="text" name="woonplaats" id="woonplaats" value="<?php echo $_GET['woonplaats']; ?>">
              <?php } else { ?>
                <input type="text" name="woonplaats" id="woonplaats" placeholder="woonplaats">
              <?php } ?>
            </div>
            <div class="form_group">
              <label for="straat">Straat</label>
              <?php if (isset($_GET['straat'])) { ?>
                <input type="text" name="straat" id="straat" value="<?php echo $_GET['straat']; ?>">
              <?php } else { ?>
                <input type="text" name="straat" id="straat" placeholder="straat">
              <?php } ?>
            </div>
            <div class="form_group">
              <label for="huisnummer">Huisnummer</label>
              <?php if (isset($_GET['huisnummer'])) { ?>
                <input type="text" name="huisnummer" id="huisnummer" value="<?php echo $_GET['huisnummer']; ?>">
              <?php } else { ?>
                <input type="text" name="huisnummer" id="huisnummer" placeholder="huisnummer">
              <?php } ?>
            </div>
            <div class="form_group">
              <label for="toevoeging">Toevoeging</label>
              <?php if (isset($_GET['toevoeging'])) { ?>
                <input type="text" name="toevoeging" id="toevoeging" value="<?php echo $_GET['toevoeging']; ?>">
              <?php } else { ?>
                <input type="text" name="toevoeging" id="toevoeging" placeholder="toevoeging">
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
            <!-- <div class="form_group_radio">
              <input type="radio" id="role1" name="role" value="administrator">
              <label for="role1">Administrator</label>
            </div>
            <div class="form_group_radio">
              <input type="radio" id="role2" name="role" value="employee">
              <label for="role2">Employee</label>
            </div>
            <div class="form_group_radio">
              <input type="radio" id="role3" name="role" value="customer" checked>
              <label for="role3">Customer</label>
            </div> -->
            <div>
              <a href="login.php" class="form_content_switch">Ik heb al een account</a>
              <button class="button_submit" type="sumbit">Maak nieuwe gebruiker</button>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
  <!-- begin footer -->
  <?php
  require 'footer.php';
  ?>
  <!-- einde footer -->