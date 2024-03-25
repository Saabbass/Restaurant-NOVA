<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  echo "You are not logged in, please login. ";
  echo "<a href='login.php'>Login here</a>";
  exit;
}

// if ($_SESSION['rol'] != 'admin') {
//   echo "You are not allowed to view this page, please login as admin";
//   exit;
// }

require 'database.php';

$reservation_number = $_GET['id'];

$sql = "SELECT * FROM reservering WHERE reservering_nummer = :reservation_number";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":reservation_number", $reservation_number);
$stmt->execute();
$reservation_data = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM gebruiker";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$data = $_SESSION['rol'];

require 'header.php';
?>

<main>
  <div class="container">
    <div class="container_width">
      <section class="form_align">
        <form action="reservation_update_session.php" method="post">
          <h1 class="form_head">Reservering aanpassen</h1>
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
          <input type="hidden" name="reservation_number" id="reservation_number" value="<?php echo $reservation_number ?>" placeholder="<?php echo $reservation_number ?>">
          <div class="form_group">
            <label for="naam">Naam</label>
            <?php if (isset($_GET['naam'])) { ?>
              <input type="text" name="naam" id="naam" value="<?php echo $_GET['naam']; ?>">
            <?php } else { ?>
              <input type="text" name="naam" id="naam" placeholder="<?php echo $reservation_data['reservering_naam']; ?>" placeholder="<?php echo $reservation_data['reservering_naam']; ?>">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="tafelnummer">Tafelnummer</label>
            <select type="number" id="tafelnummer" name="tafelnummer">
              <?php
              for ($i = 1; $i <= 13; $i++) {
                echo "<option value=\"$i\">$i</option>";
              }
              ?>
            </select>
          </div>
          <div class="form_group">
            <label for="datum">Datum</label>
            <?php if (isset($_GET['datum'])) { ?>
              <input type="date" name="datum" id="datum" value="<?php echo $_GET['datum']; ?>">
            <?php } else { ?>
              <input type="date" name="datum" id="datum" placeholder="<?php echo $reservation_data['datum']; ?>" placeholder="<?php echo $reservation_data['datum']; ?>">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="tijd">Tijd</label>
            <?php if (isset($_GET['tijd'])) { ?>
              <input type="time" name="tijd" id="tijd" value="<?php echo $_GET['tijd']; ?>">
            <?php } else { ?>
              <input type="time" name="tijd" id="tijd" value="<?php echo $reservation_data['tijd']; ?>" placeholder="<?php echo $reservation_data['tijd']; ?>">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="aantal_personen">Aantal personen</label>
            <?php if (isset($_GET['aantal_personen'])) { ?>
              <input type="number" name="aantal_personen" id="aantal_personen" value="<?php echo $_GET['aantal_personen']; ?>">
            <?php } else { ?>
              <input type="number" name="aantal_personen" id="aantal_personen" value="<?php echo $reservation_data['aantal_personen']; ?>" placeholder="<?php echo $reservation_data['aantal_personen']; ?>">
            <?php } ?>
          </div>
          <?php if ($data === 'admin' || $data === 'employee') {
          ?>
            <div class="form_group">
              <label for="reservering_naam">reservering naam:</label>
              <select type="text" id="reservering_naam" name="reservering_naam">
                <?php foreach ($users as $user) : ?>
                  <option value="<?php echo $user['gebruiker_id'] ?>">
                    <?php echo $user['gebruiker_voornaam'] ?>
                    <?php echo $user['gebruiker_achternaam'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          <?php } ?>
          <div>
            <button class="button_submit" type="sumbit">Maak nieuwe gebruiker</button>
          </div>
        </form>
      </section>
    </div>
  </div>
</main>
<?php require 'footer.php' ?>