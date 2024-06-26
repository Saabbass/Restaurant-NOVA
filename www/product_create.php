<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if ($_SESSION['rol'] != 'admin' && $_SESSION['rol'] != 'employee') {
  echo "U bent niet bevoegd om deze pagina te bekijken, login in als admin of medewerker!";
  exit;
}
require 'database.php';

$sql = "SELECT * FROM categorie";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'header.php';
?>

<main>
  <div class="container">
    <div class="container_width">
      <section class="form_align">
        <form action="product_create_session.php" method="post" enctype="multipart/form-data">
          <div>
            <h2 class="form_head">Nieuw Gerecht</h2>
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
            <label for="beschrijving">Beschrijving:</label>
            <input type="text" id="beschrijving" name="beschrijving">
          </div>
          <div class="form_group">
            <label for="categorie">Categorie:</label>
            <select type="text" id="categorie" name="categorie">
              <?php foreach ($categories as $categorie) : ?>
                <option value="<?php echo $categorie['categorie_id'] ?>"><?php echo $categorie['categorie_naam'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form_group">
            <label for="inkoopprijs">Inkoopprijs:</label>
            <input type="number" id="inkoopprijs" name="inkoopprijs">
          </div>
          <div class="form_group">
            <label for="verkoopprijs">Verkoopprijs:</label>
            <input type="number" id="verkoopprijs" name="verkoopprijs">
          </div>
          <div class="form_group">
            <label for="image">Afbeelding:</label>
            <input type="file" id="image" name="image">
          </div>
          <div class="form_group">
            <label for="is_vega">Vega:</label>
            <input type="text" id="is_vega" name="is_vega">
          </div>
          <div class="form_group">
            <label for="aantal_vooraad">Vooraad:</label>
            <input type="number" id="aantal_vooraad" name="aantal_vooraad">
          </div>
          <button type="submit" class="button_submit" name="submit">Toevoegen</button>
        </form>
      </section>
    </div>
  </div>
</main>
<?php require 'footer.php' ?>