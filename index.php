<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">Penambahan peserta baru</span>
    </nav>
    <div class="container">
        <br>
        <h4 class="text-center">DAFTAR PESERTA PELATIHAN</h4>
        
        <?php
        include "koneksi.php";

        if (isset($_GET['id_peserta'])) {
            $id_peserta = htmlspecialchars($_GET["id_peserta"]);
            
            $stmt = $kon->prepare("DELETE FROM peserta WHERE id_peserta=?");
            $stmt->bind_param("i", $id_peserta);
            
            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Data Gagal dihapus: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
        ?>

        <div class="my-3">
            <a href="create.php" class="btn btn-primary">Tambah Data</a>
        </div>

        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Sekolah</th>
                    <th>Jurusan</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM peserta ORDER BY id_peserta DESC";
                $hasil = mysqli_query($kon, $sql);
                
                if (mysqli_num_rows($hasil) > 0) {
                    $no = 0;
                    while ($data = mysqli_fetch_array($hasil)) {
                        $no++;
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo htmlspecialchars($data["nama"]); ?></td>
                            <td><?php echo htmlspecialchars($data["sekolah"]); ?></td>
                            <td><?php echo htmlspecialchars($data["jurusan"]); ?></td>
                            <td><?php echo htmlspecialchars($data["no_hp"]); ?></td>
                            <td><?php echo htmlspecialchars($data["alamat"]); ?></td>
                            <td>
                                <a href="update.php?id_peserta=<?php echo $data['id_peserta']; ?>" class="btn btn-warning">Edit</a>
                                <a href="index.php?id_peserta=<?php echo $data['id_peserta']; ?>" 
                                   class="btn btn-danger" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data peserta</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>