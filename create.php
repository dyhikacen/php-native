<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php?pesan=belum_login");
    exit;
}

require_once "koneksi.php";

$error = "";

if (isset($_POST['submit'])) {
    $nama     = mysqli_real_escape_string($connect, $_POST['nama']);
    $alamat   = mysqli_real_escape_string($connect, $_POST['alamat']);
    $tempat   = mysqli_real_escape_string($connect, $_POST['tempat']);
    $ttl      = mysqli_real_escape_string($connect, $_POST['ttl']);
    $agama    = mysqli_real_escape_string($connect, $_POST['agama']);
    $no_hp    = mysqli_real_escape_string($connect, $_POST['no_hp']);
    $email    = mysqli_real_escape_string($connect, $_POST['email']);
    $password = md5($_POST['password']);

    $foto          = $_FILES['foto']['name'];
    $tmp_foto      = $_FILES['foto']['tmp_name'];
    $file_ext      = pathinfo($foto, PATHINFO_EXTENSION);
    $nama_foto     = time() . '-' . preg_replace("/[^a-zA-Z0-9]/", "", $nama) . '.' . $file_ext;
    $lokasi_upload = "upload/";

    if (!is_dir($lokasi_upload)) {
        mkdir($lokasi_upload, 0777, true);
    }

    if (!empty($foto)) {
        if (move_uploaded_file($tmp_foto, $lokasi_upload . $nama_foto)) {
            $sql = "INSERT INTO siswa (nama, alamat, tempat, ttl, agama, no_hp, email, password, foto) 
                    VALUES ('$nama', '$alamat', '$tempat', '$ttl', '$agama', '$no_hp', '$email', '$password', '$nama_foto')";
            $query = mysqli_query($connect, $sql);

            if ($query) {
                header("Location: index.php");
                exit;
            } else {
                $error = "Gagal disimpan ke database: " . mysqli_error($connect);
            }
        } else {
            $error = "Gagal mengupload foto. Pastikan hak akses folder diizinkan.";
        }
    } else {
        $error = "Silakan pilih foto terlebih dahulu.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Siswa - PHP Native</title>
</head>
<body>

    <h2>Tambah Data Siswa</h2>
    <p><a href="index.php">&laquo; Kembali ke Data Siswa</a></p>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><strong>Error:</strong> <?php echo $error; ?></p>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <table cellpadding="5">
            <tr>
                <td><label for="nama">Nama Lengkap</label></td>
                <td>: <input type="text" name="nama" id="nama" required></td>
            </tr>
            <tr>
                <td><label for="tempat">Tempat Lahir</label></td>
                <td>: <input type="text" name="tempat" id="tempat" required></td>
            </tr>
            <tr>
                <td><label for="ttl">Tanggal Lahir</label></td>
                <td>: <input type="date" name="ttl" id="ttl" required></td>
            </tr>
            <tr>
                <td><label for="agama">Agama</label></td>
                <td>: 
                    <select name="agama" id="agama" required>
                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Hindu">Hindu</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="no_hp">Nomor HP</label></td>
                <td>: <input type="text" name="no_hp" id="no_hp" required></td>
            </tr>
            <tr>
                <td><label for="email">Email</label></td>
                <td>: <input type="email" name="email" id="email" required></td>
            </tr>
            <tr>
                <td><label for="password">Password</label></td>
                <td>: <input type="password" name="password" id="password" required></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat</label></td>
                <td>: <textarea name="alamat" id="alamat" rows="4" cols="40" required></textarea></td>
            </tr>
            <tr>
                <td><label for="foto">Foto Siswa</label></td>
                <td>: <input type="file" name="foto" id="foto" accept="image/*" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="submit">Simpan Data</button>
                    <a href="index.php">Batal</a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>