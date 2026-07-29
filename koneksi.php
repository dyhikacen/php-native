<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "latihancrud";


$koneksidb = mysqli_connect($host, $username, $password, $database);

if($koneksidb) {
    echo "koneksi berhasil";
} else {
    echo "gagal";
}