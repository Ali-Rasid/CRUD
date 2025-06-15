<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Peserta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <style>
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .loading-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    include "koneksi.php";

    if (isset($_GET['id_peserta'])) {
        $id = $_GET['id_peserta'];
        $stmt = $kon->prepare("SELECT * FROM peserta WHERE id_peserta=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id_peserta'];
        $nama = htmlspecialchars($_POST['nama']);
        $sekolah = htmlspecialchars($_POST['sekolah']);
        $jurusan = htmlspecialchars($_POST['jurusan']);
        $no_hp = htmlspecialchars($_POST['no_hp']);
        $alamat = htmlspecialchars($_POST['alamat']);

        if (!preg_match('/^[0-9]{10,13}$/', $no_hp)) {
            echo "<div class='alert alert-danger'>Nomor HP harus 10-13 digit angka</div>";
        } else {
            $stmt = $kon->prepare("UPDATE peserta SET nama=?, sekolah=?, jurusan=?, no_hp=?, alamat=? WHERE id_peserta=?");
            $stmt->bind_param("sssssi", $nama, $sekolah, $jurusan, $no_hp, $alamat, $id);
            
            if ($stmt->execute()) {
                echo '<div class="loading-overlay" id="loadingOverlay">
                        <div class="loading-content">
                            <p>Menyimpan perubahan...</p>
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                      </div>
                      <script>
                        document.getElementById("loadingOverlay").style.display = "flex";
                        setTimeout(function() {
                            alert("Perubahan berhasil disimpan!");
                            window.location.href = "index.php";
                        }, 1500);
                      </script>';
            } else {
                echo "<div class='alert alert-danger'>Gagal update: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
    }
    ?>

    <h2 class="mt-3">Edit Data Peserta</h2>
    <form method="POST" action="">
        <input type="hidden" name="id_peserta" value="<?php echo $data['id_peserta']; ?>">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control" name="nama" value="<?php echo $data['nama']; ?>" required>
        </div>
        <div class="form-group">
            <label>Asal Sekolah</label>
            <input type="text" class="form-control" name="sekolah" value="<?php echo $data['sekolah']; ?>" required>
        </div>
        <div class="form-group">
            <label>Jurusan</label>
            <input type="text" class="form-control" name="jurusan" value="<?php echo $data['jurusan']; ?>" required>
        </div>
        <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" class="form-control" name="no_hp" value="<?php echo $data['no_hp']; ?>" required>
            <small class="text-muted">Contoh: 081234567890</small>
        </div>
        <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea class="form-control" name="alamat" rows="3" required><?php echo $data['alamat']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>