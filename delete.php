<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php?pesan=belum_login");
    exit;
}

require_once "koneksi.php";

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connect, $_GET['id']);
    
    $query = mysqli_query($connect, "SELECT foto FROM siswa WHERE id = '$id'");
    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        if (!empty($data['foto'])) {
            $foto_path = "upload/" . $data['foto'];
            if (file_exists($foto_path)) {
                @unlink($foto_path);
            }
        }
    }
    
    mysqli_query($connect, "DELETE FROM siswa WHERE id = '$id'");
}

header("Location: index.php");
exit;
?>
