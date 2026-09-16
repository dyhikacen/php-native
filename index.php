<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: login.php?pesan=belum_login");
    exit;
}

include "koneksi.php";

$perintahSql = "SELECT * FROM siswa ORDER BY id DESC";
$hasil = mysqli_query($connect, $perintahSql);
$totalSiswa = mysqli_num_rows($hasil);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa - PHP Native</title>
</head>
<body>

    <p><a href="logout.php" onclick="return confirm('Apakah anda yakin ingin logout?')">Logout</a></p>

    <h1>Data Siswa</h1>
    <p><a href="create.php">+ Tambah Data Baru</a></p>

    <p>Total Data Siswa: <strong><?php echo $totalSiswa; ?></strong></p>

    <table border="1" cellpadding="4" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Tempat, Tanggal Lahir</th>
                <th>Agama</th>
                <th>No HP</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($totalSiswa > 0) {
                $no = 1;
                while ($data = mysqli_fetch_array($hasil)) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td>
                    <?php if (!empty($data['foto']) && file_exists("upload/" . $data['foto'])): ?>
                        <img src="upload/<?php echo htmlspecialchars($data['foto']); ?>" width="50" alt="Foto">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($data['nama']); ?></td>
                <td><?php echo htmlspecialchars($data['tempat']); ?>, <?php echo htmlspecialchars($data['ttl']); ?></td>
                <td><?php echo htmlspecialchars($data['agama']); ?></td>
                <td><?php echo htmlspecialchars($data['no_hp']); ?></td>
                <td><?php echo htmlspecialchars($data['email']); ?></td>
                <td><?php echo htmlspecialchars($data['alamat']); ?></td>
                <td>
                    <a href="update.php?id=<?php echo $data['id']; ?>">Edit</a> | 
                    <a href="delete.php?id=<?php echo $data['id']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php
                }
            } else {
            ?>
            <tr>
                <td colspan="9" align="center">Belum ada data siswa.</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>