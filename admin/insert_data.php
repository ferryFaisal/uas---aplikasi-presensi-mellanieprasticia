<?php
require "connect.php";

$email = $_POST["email"];
$name = $_POST["name"];
$password = sha1($_POST['password']);
$role = $_POST["role"];
$dc = date("Y-m-d");
$dm = date("Y-m-d");


$sql = "INSERT INTO user (email, name, password, role, date_created, date_modified)
VALUES ('$email', '$name', '$password', '$role', '$dc', '$dm')";

if (mysqli_query($conn, $sql)) {
  header("Location: login.php");
} else {
  echo "Pendaftaram Gagal : " . mysqli_error($conn);
}

?>