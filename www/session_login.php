<?php
// session_start();
// require 'header.php';


if (isset($_POST['submit'])) {
  if (isset($_POST['email']) && isset($_POST['password'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
      $emailForm = $_POST['email'];
      $passwordForm = $_POST['password'];
      require 'database.php';

      $sql = "SELECT * FROM gebruiker  WHERE email = '$emailForm'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();

      // $stmt->fetch(PDO::FETCH_NUM);

      //als de email bestaat dan is het resultaat groter dan 0
      if ($stmt->rowCount() > 0) {

        //resultaat gevonden? Dan maken we een user-array $dbuser
        $sql = "SELECT * FROM gebruiker WHERE email='$emailForm'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $dbuser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($passwordForm, $dbuser['wachtwoord'])) {
          if ($dbuser['rol'] == "admin") {
            $userRole = 'admin';
          } else if ($dbuser['rol'] == "employee") {
            $userRole = 'employee';
          } else {
            $userRole = 'customer';
          }

          session_start();
          $_SESSION['user_id']    = $dbuser['gebruiker_id'];
          $_SESSION['email']      = $dbuser['email'];
          $_SESSION['voornaam']  = $dbuser['gebruiker_voornaam'];
          $_SESSION['tussenvoegsel']  = $dbuser['gebruiker_tussenvoegsel'];
          $_SESSION['achternaam']   = $dbuser['gebruiker_achternaam'];
          $_SESSION['rol']       = $userRole;
          //$_SESSION['backgroundColor'] = $dbuser['backgroundColor'];

          if (headers_sent()) {
            die("Redirect failed. Please refresh the page.");
          } else {
            exit(header("Location:index.php"));
            echo "You are logged in";
          }
        } else {
          include 'header.php';
          $_GET['message'] = 'wrongpassword';
          include 'login-message.php';
          include 'footer.php';
          exit;
        }
      } else {
        include 'header.php';
        $_GET['message'] = 'usernotfound';
        include 'login-message.php';
        include 'footer.php';
        exit;
      }
    } else {
      include 'header.php';
      $_GET['message'] = 'Email or Password is empty! Try again.';
      include 'login-message.php';
      include 'footer.php';
      exit;
    }
  } else {
    include 'header.php';
    $_GET['message'] = 'Email or Password is not filled correctly! Try again.';
    include 'login-message.php';
    include 'footer.php';
    exit;
  }
} else {
  include 'header.php';
  $_GET['message'] = 'You tried to login but it did not submit!';
  include 'login-message.php';
  include 'footer.php';
  exit;
}

// include 'footer.php';



// session_start();
// include("database.php");

// if (isset($_POST['email']) && isset($_POST['wachtwoord'])) {

//     function validate($data)
//     {
//         $data = trim($data);
//         $data = stripslashes($data);
//         $data = htmlspecialchars($data);
//         return $data;
//     }

//     $email = validate($_POST['email']);
//     $pass = validate($_POST['wachtwoord']);

//     if (empty($email)) {
//         header("Location: login.php?error=Email-adres is verplicht");
//         exit();
//     } else if (empty($pass)) {
//         header("Location: login.php?error=wachtwoord is verplicht");
//         exit();
//     } else {
//         $sql = "SELECT * FROM users WHERE email = '$email' and wachtwoord = '$pass'";

//         $stmt = $conn->prepare($sql);
//         $stmt->execute();

//         $stmt->fetch(PDO::FETCH_NUM);

//         if ($stmt === 1) {
//             $row = mysqli_fetch_assoc($result);

//             if ($row['email'] === $email && $row['wachtwoord'] === $pass && $row['role'] == 'employee') {
//                 $_SESSION['email'] = $row['email'];
//                 $_SESSION['voornaam'] = $row['voornaam'];
//                 $_SESSION['user_id'] = $row['user_id'];
//                 $_SESSION['role'] = $row['role'];

//                 header("location: index.php");
//                 exit();

//             }elseif($row['email'] === $email && $row['wachtwoord'] === $pass && $row['role'] == 'administrator'){
//                 $_SESSION['email'] = $row['email'];
//                 $_SESSION['voornaam'] = $row['voornaam'];
//                 $_SESSION['user_id'] = $row['user_id'];
//                 $_SESSION['role'] = $row['role'];

//                 header("Location: index.php");
//                 exit();
//             }elseif($row['email'] === $email && $row['wachtwoord'] === $pass && $row['role'] == 'customer'){
//                 $_SESSION['email'] = $row['email'];
//                 $_SESSION['voornaam'] = $row['voornaam'];
//                 $_SESSION['user_id'] = $row['user_id'];
//                 $_SESSION['role'] = $row['role'];

//                 header("Location: index.php");
//                 exit();
//             } else {
//                 header("Location: login.php?error=Incorrect Email-adres of wachtwoord");
//                 exit();
//             }
//         } else {
//             header("Location: login.php?error=Incorrect Email-adres of wachtwoord");
//             exit();
//         }
//     }
// } else {
//     header("Location: login.php?error");
//     exit();
// }
