<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "latihan";

$connect = mysqli_connect($host, $user, $pass, $db);

if (!$connect) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>