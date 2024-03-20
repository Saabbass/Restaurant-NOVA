<?php
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && (($_SESSION['rol']) === 'admin' || ($_SESSION['rol']) === 'employee')) {
require 'database.php';

    $sql = "SELECT * FROM gebruiker";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

    <!DOCTYPE html>
    <html lang="nl-NL">

    <head>
        <title>Webwinkel</title>
    </head>

    <body>
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
                            <table>
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>email</th>
                                        <th>voornaam</th>
                                        <th>achternaam</th>
                                        <th>address</th>
                                        <th>stad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td><?php echo $user['user_id'] ?></td>
                                            <td><?php echo $user['email'] ?></td>
                                            <td><?php echo $user['voornaam'] ?></td>
                                            <td><?php echo $user['achternaam'] ?></td>
                                            <td><?php echo $user['address'] ?></td>
                                            <td><?php echo $user['stad'] ?></td>
                                            <td>
                                                <?php if (isset($_SESSION['role'])) {
                                                    $data = $_SESSION['role'];
                                                    if ($data == 'administrator') {
                                                ?>
                                                        <a href="deleteUser.php?id=<?php echo $user['user_id'] ?>" class="btn-delete">delete</a>
                                                        <a href="updateUser.php?id=<?php echo $user['user_id'] ?>" class="btn-update">update</a>

                                                    <?php } elseif ($data == 'employee') { ?>
                                                        <a href="updateUser.php?id=<?php echo $user['user_id'] ?>" class="btn-update">update</a>
                                                    <?php } else {
                                                    ?>

                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>
            </section>
        </section>
        <!-- begin footer -->
        <?php
        include('footer.php');
        ?>
        <!-- einde footer -->
    </body>

    </html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>