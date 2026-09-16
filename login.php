<?php
session_start();
require_once "koneksi.php";

if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
    header("Location: index.php");
    exit;
}

$pesan = "";

if (isset($_POST['login'])) {
    $email        = mysqli_real_escape_string($connect, $_POST['email']);
    $raw_password = mysqli_real_escape_string($connect, $_POST['password']);
    $md5_password = md5($_POST['password']);

    $query = mysqli_query($connect, "SELECT * FROM siswa WHERE email = '$email' AND (password = '$md5_password' OR password = '$raw_password')");
    $cek   = mysqli_num_rows($query);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['id']     = $data['id'];
        $_SESSION['nama']   = $data['nama'];
        $_SESSION['email']  = $data['email'];
        $_SESSION['status'] = "login";

        header("Location: index.php");
        exit;
    } else {
        $pesan = "gagal";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PHP Native</title>
    
</head>
<body>

<div class="login-box">
    <h2>Login Sistem</h2>

    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "gagal" || $pesan == "gagal") {
            echo "<div class='alert alert-danger'>Email atau Password salah!</div>";
        } else if ($_GET['pesan'] == "logout") {
            echo "<div class='alert alert-success'>Anda telah berhasil logout.</div>";
        } else if ($_GET['pesan'] == "belum_login") {
            echo "<div class='alert alert-warning'>Silakan login terlebih dahulu!</div>";
        }
    } else if ($pesan == "gagal") {
        echo "<div class='alert alert-danger'>Email atau Password salah!</div>";
    }
    ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required autocomplete="off" placeholder="Masukkan Email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required placeholder="Masukkan Password">
        </div>
        <button type="submit" name="login" class="btn-submit">Login</button>
    </form>
</div>

</body>
</html>
