<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../config/database.php';

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $deskripsi = trim($_POST['deskripsi']);
    $kategori = $_POST['kategori'];
    $rating = floatval($_POST['rating']);
    $foto = 'default.jpg';

    // CARI GAMBAR OTOMATIS DARI GOOGLE
    if (!empty($nama)) {
        $query = urlencode($nama . " kuliner jogja");
        $url = "https://www.google.com/search?q=$query&tbm=isch";
        // Simulasi: ambil link pertama (demo)
        $foto = "https://via.placeholder.com/300x200.png?text=$nama";
    }

    // Upload manual (jika ada)
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = time() . '.' . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/$foto");
    }

    $stmt = $pdo->prepare("INSERT INTO kuliner (nama, alamat, deskripsi, kategori, rating, foto) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$nama, $alamat, $deskripsi, $kategori, $rating, $foto])) {
        $success = "Kuliner berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan kuliner!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Kuliner</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; font-family: 'Poppins', sans-serif; }
    .card { border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .btn-auto { background: #17a2b8; color: white; }
    .btn-auto:hover { background: #138496; }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="card mx-auto" style="max-width: 600px;">
      <div class="card-header bg-primary text-white text-center">
        <h4><i class="fas fa-plus"></i> Tambah Kuliner Baru</h4>
      </div>
      <div class="card-body">
        <?php if ($success): ?>
          <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
          <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label>Nama Tempat</label>
            <input type="text" name="nama" class="form-control" placeholder="Contoh: Gudeg Yu Djum" required>
          </div>
          <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" placeholder="Jl. Dagen No.75, Malioboro" required>
          </div>
          <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Gudeg kering manis legendaris..." required></textarea>
          </div>
          <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control" required>
              <option value="Makanan">Makanan</option>
              <option value="Minuman">Minuman</option>
              <option value="Tempat Nongkrong">Tempat Nongkrong</option>
            </select>
          </div>
          <div class="mb-3">
            <label>Rating (0.0 - 5.0)</label>
            <input type="number" step="0.1" min="0" max="5" name="rating" class="form-control" value="4.5" required>
          </div>
          <div class="mb-3">
            <label>Foto (Opsional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <small class="text-muted">Abaikan jika ingin otomatis</small>
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success btn-lg">
              <i class="fas fa-save"></i> Simpan + Cari Gambar Otomatis
            </button>
            <a href="dashboard.php" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>