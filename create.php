<!DOCTYPE html>
<html>
<head>
    <title>Tambah Peserta Baru</title>
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = htmlspecialchars($_POST['nama']);
        $sekolah = htmlspecialchars($_POST['sekolah']);
        $jurusan = htmlspecialchars($_POST['jurusan']);
        $no_hp = htmlspecialchars($_POST['no_hp']);
        $alamat = htmlspecialchars($_POST['alamat']);

        if (!preg_match('/^[0-9]{10,13}$/', $no_hp)) {
            echo "<div class='alert alert-danger'>Nomor HP harus 10-13 digit angka</div>";
        } else {
            $stmt = $kon->prepare("INSERT INTO peserta (nama, sekolah, jurusan, no_hp, alamat) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nama, $sekolah, $jurusan, $no_hp, $alamat);
            
            if ($stmt->execute()) {
                echo '<div class="loading-overlay" id="loadingOverlay">
                        <div class="loading-content">
                            <p>Menyimpan data...</p>
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                      </div>
                      <script>
                        document.getElementById("loadingOverlay").style.display = "flex";
                        setTimeout(function() {
                            alert("Data berhasil disimpan!");
                            window.location.href = "index.php";
                        }, 1500);
                      </script>';
            } else {
                echo "<div class='alert alert-danger'>Gagal menyimpan: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
    }
    ?>

    <h2 class="mt-3">Tambah Peserta Baru</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control" name="nama" required>
        </div>
        <div class="form-group">
            <label>Asal Sekolah</label>
            <input type="text" class="form-control" name="sekolah" required>
        </div>
        <div class="form-group">
            <label>Jurusan</label>
            <input type="text" class="form-control" name="jurusan" required>
        </div>
        <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" class="form-control" name="no_hp" required>
            <small class="text-muted">Contoh: 081234567890</small>
        </div>
        <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea class="form-control" name="alamat" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>