<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan CRUD Sederhanat</title>
</head>
<body>
    <h3>CRUD</h3>
    <h4><a href="create.php">Tambah Data</a></h4>
    <table border="1">
        <thead>
            <tr>
            <td>No</td>
            <td>Nama</td>
            <td>Alamat</td>
            <td>Tempat</td>
            <td>Taggal Lahir</td>
            <td>Agama</td>
            <td>No Hp</td>
            <td>Email</td>
            <td>Foto</td>
            <td>Aksi</td>
        </tr>
        </thead>
        <?php
        include "koneksi.php";
        $perintahSql = "SELECT * FROM siswa";
        $hasil = mysqli_query($koneksidb, $perintahSql);
        $no = 0;
        while($data = mysqli_fetch_array($hasil)){
            $no++;
            ?>
            <tbody>
                <tr>
                    <td><?php echo $no?></td>
                    <td><?php echo $data['nama'];?></td>
                    <td><?php echo $data['alamat'];?></td>
                    <td><?php echo $data['tempat'];?></td>
                    <td><?php echo $data['ttl'];?></td>
                    <td><?php echo $data['agama'];?></td>
                    <td><?php echo $data['no_hp'];?></td>
                    <td><?php echo $data['email'];?></td>
                    <td><?php echo $data['foto'];?></td>
                    <td>
                        <a href="update.php?id=<?php echo $data['id'];?>"></a>
                        <a href="delete.php?id=<?php echo $data['id'];?>"></a>
                    </td>
                </tr>
            </tbody>
            <?php
        }
        ?>
    </table>
</body>
</html>