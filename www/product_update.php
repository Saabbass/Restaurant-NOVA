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

$product_id = $_GET['id'];

$sql = "SELECT * FROM product WHERE product_id = :product_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":product_id", $product_id);
$stmt->execute();
$product_data = $stmt->fetch(PDO::FETCH_ASSOC);

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
        <form action="product_update_session.php" method="post" enctype="multipart/form-data">
          <div>
            <h2 class="form_head">Gerecht aanpassen</h2>
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
          <input type="hidden" name="product_procesID" id="product_procesID" value="<?php echo $product_id ?>" placeholder="<?php echo $product_id ?>">
          <div class="form_group">
            <label for="naam">Naam:</label>
            <?php if (isset($_GET['naam'])) { ?>
              <input type="text" id="naam" name="naam" value="<?php echo $_GET['product_naam']; ?>">
            <?php } else { ?>
              <input type="text" id="naam" name="naam" value="<?php echo $product_data['product_naam']; ?>" placeholder="<?php echo $product_data['product_naam']; ?>">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="beschrijving">Beschrijving:</label>
            <?php if (isset($_GET['beschrijving'])) { ?>
              <input type="text" id="beschrijving" name="beschrijving" value="<?php echo $_GET['beschrijving']; ?>">
            <?php } else { ?>
              <input type="text" id="beschrijving" name="beschrijving" value="<?php echo $product_data['beschrijving']; ?>" placeholder="<?php echo $product_data['beschrijving']; ?>">
            <?php } ?>
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
            <?php if (isset($_GET['inkoopprijs'])) { ?>
              <input type="number" id="inkoopprijs" name="inkoopprijs" value="<?php echo $_GET['inkoopprijs']; ?>">
            <?php } else { ?>
              <input type="number" id="inkoopprijs" name="inkoopprijs" value="<?php echo $product_data['inkoopprijs']; ?>" placeholder="<?php echo $product_data['inkoopprijs']; ?>">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="verkoopprijs">Verkoopprijs:</label>
            <?php if (isset($_GET['verkoopprijs'])) { ?>
              <input type="number" id="verkoopprijs" name="verkoopprijs" value="<?php echo $_GET['verkoopprijs']; ?>">
            <?php } else { ?>
              <input type="number" id="verkoopprijs" name="verkoopprijs" value="<?php echo $product_data['verkoopprijs']; ?>" placeholder="<?php echo $product_data['verkoopprijs']; ?>">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="image">Afbeelding:</label>
            <?php if (isset($_GET['image'])) { ?>
              <input type="file" id="image" name="image" value="<?php echo $_GET['afbeelding']; ?>">
            <?php } else { ?>
              <input type="file" id="image" name="image" value="<?php echo $product_data['afbeelding']; ?>" placeholder="<?php echo $product_data['afbeelding']; ?>">
            <?php } ?>
            <!-- <input type="file" id="image" name="image"> -->
          </div>
          <div class="form_group">
            <label for="is_vega">Vega:</label>
            <?php if (isset($_GET['is_vega'])) { ?>
              <input type="text" id="is_vega" name="is_vega" value="<?php echo $_GET['is_vega']; ?>">
            <?php } else { ?>
              <input type="text" id="is_vega" name="is_vega" value="<?php echo $product_data['is_vega']; ?>" placeholder="<?php echo $product_data['is_vega']; ?>">
            <?php } ?>
          </div>
          <div class="form_group">
            <label for="aantal_vooraad">Vooraad:</label>
            <?php if (isset($_GET['aantal_vooraad'])) { ?>
              <input type="number" id="aantal_vooraad" name="aantal_vooraad" value="<?php echo $_GET['aantal_vooraad']; ?>">
            <?php } else { ?>
              <input type="number" id="aantal_vooraad" name="aantal_vooraad" value="<?php echo $product_data['aantal_vooraad']; ?>" placeholder="<?php echo $product_data['aantal_vooraad']; ?>">
            <?php } ?>
          </div>
          <button type="submit" class="button_submit" name="submit">Toevoegen</button>
        </form>
      </section>
    </div>
  </div>
</main>
<?php require 'footer.php' ?>