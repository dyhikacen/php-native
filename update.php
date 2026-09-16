<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php?pesan=belum_login");
    exit;
}

require_once "koneksi.php";

$error = "";
$id = isset($_GET['id']) ? mysqli_real_escape_string($connect, $_GET['id']) : '';

$query_edit = mysqli_query($connect, "SELECT * FROM siswa WHERE id = '$id'");
$data = mysqli_fetch_array($query_edit);

if (!$data) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['submit'])) {
    $id_post   = mysqli_real_escape_string($connect, $_POST['id']);
    $nama      = mysqli_real_escape_string($connect, $_POST['nama']);
    $alamat    = mysqli_real_escape_string($connect, $_POST['alamat']);
    $tempat    = mysqli_real_escape_string($connect, $_POST['tempat']);
    $ttl       = mysqli_real_escape_string($connect, $_POST['ttl']);
    $agama     = mysqli_real_escape_string($connect, $_POST['agama']);
    $no_hp     = mysqli_real_escape_string($connect, $_POST['no_hp']);
    $email     = mysqli_real_escape_string($connect, $_POST['email']);
    $foto_lama = $_POST['foto_lama'];

    if (!empty($_FILES['foto']['name'])) {
        $foto          = $_FILES['foto']['name'];
        $tmp_foto      = $_FILES['foto']['tmp_name'];
        $file_ext      = pathinfo($foto, PATHINFO_EXTENSION);
        $nama_foto     = time() . '-' . preg_replace("/[^a-zA-Z0-9]/", "", $nama) . '.' . $file_ext;
        $lokasi_upload = "upload/";

        if (!is_dir($lokasi_upload)) {
            mkdir($lokasi_upload, 0777, true);
        }

        if (move_uploaded_file($tmp_foto, $lokasi_upload . $nama_foto)) {
            if (!empty($foto_lama) && file_exists($lokasi_upload . $foto_lama)) {
                @unlink($lokasi_upload . $foto_lama);
            }
            $sql = "UPDATE siswa SET nama='$nama', alamat='$alamat', tempat='$tempat', ttl='$ttl', agama='$agama', no_hp='$no_hp', email='$email', foto='$nama_foto' WHERE id='$id_post'";
        } else {
            $error = "Gagal mengupload foto baru.";
        }
    } else {
        $sql = "UPDATE siswa SET nama='$nama', alamat='$alamat', tempat='$tempat', ttl='$ttl', agama='$agama', no_hp='$no_hp', email='$email' WHERE id='$id_post'";
    }

    if (empty($error)) {
        $query = mysqli_query($connect, $sql);
        if ($query) {
            header("Location: index.php");
            exit;
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($connect);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Data Siswa - PHP Native</title>
</head>
<body>

    <h2>Ubah Data Siswa</h2>
 
    <?php if (!empty($error)): ?>
        <p style="color: red;"><strong>Error:</strong> <?php echo $error; ?></p>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>">
        <input type="hidden" name="foto_lama" value="<?php echo htmlspecialchars($data['foto']); ?>">

        <table borde="1">
            <tr>
                <td><label for="nama">Nama Lengkap</label></td>
                <td>: <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="tempat">Tempat Lahir</label></td>
                <td>: <input type="text" name="tempat" id="tempat" value="<?php echo htmlspecialchars($data['tempat']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="ttl">Tanggal Lahir</label></td>
                <td>: <input type="date" name="ttl" id="ttl" value="<?php echo htmlspecialchars($data['ttl']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="agama">Agama</label></td>
                <td>: 
                    <select name="agama" id="agama" required>
                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam" <?php echo ($data['agama'] == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                        <option value="Kristen" <?php echo ($data['agama'] == 'Kristen') ? 'selected' : ''; ?>>Kristen</option>
                        <option value="Katolik" <?php echo ($data['agama'] == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                        <option value="Buddha" <?php echo ($data['agama'] == 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                        <option value="Hindu" <?php echo ($data['agama'] == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="no_hp">Nomor HP</label></td>
                <td>: <input type="text" name="no_hp" id="no_hp" value="<?php echo htmlspecialchars($data['no_hp']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="email">Email</label></td>
                <td>: <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($data['email']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat</label></td>
                <td>: <textarea name="alamat" id="alamat" rows="4" cols="40" required><?php echo htmlspecialchars($data['alamat']); ?></textarea></td>
            </tr>
            <tr>
                <td><label for="foto">Foto Siswa</label></td>
                <td>: 
                    <?php if (!empty($data['foto']) && file_exists("upload/" . $data['foto'])): ?>
                        <br><img src="upload/<?php echo htmlspecialchars($data['foto']); ?>" width="80" alt="Foto Saat Ini"><br>
                    <?php endif; ?>
                    <input type="file" name="foto" id="foto" accept="image/*">
                    <br><small>*Biarkan kosong jika tidak ingin mengubah foto</small>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="submit">Update Data</button>
                    <a href="index.php">Batal</a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>