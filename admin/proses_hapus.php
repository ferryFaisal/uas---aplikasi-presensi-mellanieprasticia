<?php
require 'connect.php';

$nim = $_GET['nim'];
$query = "DELETE FROM mahasiswa WHERE nim = '$nim' ";

//periksa query, apakah ada kesalahan
if (mysqli_query($conn, $query)) {
    if (isset($_SESSION['login']) && $_SESSION['role'] == "Admin") {
        header('Location: data_mhs.php');
        ob_end_flush();
    } else {
        echo "<script>alert('Data berhasil dihapus.');window.location='data_mhs.php';</script>";
    }
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
