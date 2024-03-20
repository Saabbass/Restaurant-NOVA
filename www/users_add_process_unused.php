<?php

session_start();

require 'database.php';


if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

if ($_SESSION['role'] != 'admin') {
    echo "You are not allowed to view this page, please login as admin";
    exit;
}

//check method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "You are not allowed to view this page";
    exit;
}

//check if all fields are filled in
if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['role']) || empty($_POST['address']) || empty($_POST['city']) || empty($_POST['backgroundColor'])) {
    echo "Please fill in all fields";
    exit;
}

$email = $_POST['email'];
// $password = $_POST['password'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$role = $_POST['role'];
$address = $_POST['address'];
$city = $_POST['city'];
$is_active = 1;

$sqlCheck = "SELECT * FROM users WHERE email='$email'";
$stmt = $conn->prepare($sqlCheck);
$stmt->execute();
$resultCheck = $stmt->fetch(PDO::FETCH_ASSOC);

if($resultCheck > 0){
    echo "This email already exists";
    exit;
}

$sql = "INSERT INTO users (email, password, firstname, lastname, role, address, city, is_active) VALUES ('$email', '$password', '$firstname', '$lastname', '$role', '$address', '$city', '$is_active')";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $user_id = mysqli_insert_id($result);
    $backgroundColor = $_POST['backgroundColor'];
    $font = $_POST['font'];
    $sql = "INSERT INTO user_settings (user_id, backgroundColor, font) VALUES ('$user_id', '$backgroundColor', '$font')";
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        header("Location: users_index.php");
    } else {
        echo "Something went wrong";
    }
}

echo "Something went wrong";
