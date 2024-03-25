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

// $sql = "SELECT * FROM reservering";
// $stmt = $conn->prepare($sql);
// $stmt->execute();
// $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <form action="reservation_create_session.php" method="post">
          <div>
            <h2 class="form_head">Nieuwe reservering</h2>
          </div>
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
            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam">
          </div>
          <div class="form_group">
            <label for="tafelnummer">tafelnummer:</label>
            <select type="number" id="tafelnummer" name="tafelnummer">
              <?php
              for ($i = 1; $i <= 13; $i++) {
                echo "<option value=\"$i\">$i</option>";
              }
              ?>
            </select>
          </div>
          <div class="form_group">
            <label for="datum">Datum:</label>
            <input type="date" id="datum" name="datum">
          </div>
          <div class="form_group">
            <label for="tijd">Tijd:</label>
            <input type="time" id="tijd" name="tijd">
          </div>
          <div class="form_group">
            <label for="aantal_personen">Aantal personen:</label>
            <input type="number" id="aantal_personen" name="aantal_personen">
          </div>
          <?php if (isset($_SESSION['rol'])) {
            $data = $_SESSION['rol'];
            if ($data === 'admin' || $data === 'employee') {
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
          <?php } ?>
          <button type="submit" class="button_submit" name="submit">Toevoegen</button>
        </form>
      </section>
    </div>
  </div>
</main>
<?php require 'footer.php' ?>