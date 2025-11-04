<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}

include '../config/database.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM kuliner WHERE id = ?");
$stmt->execute([$id]);
$kuliner = $stmt->fetch();

if (!$kuliner) {
    die("Kuliner tidak ditemukan!");
}

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $deskripsi = trim($_POST['deskripsi']);
    $kategori = $_POST['kategori'];
    $rating = floatval($_POST['rating']);
    $foto = $kuliner['foto'];

    // CARI GAMBAR OTOMATIS
    if (!empty($nama)) {
        $foto = "https://via.placeholder.com/300x200.png?text=$nama";
    }

    // Upload manual
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = time() . '.' . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/$foto");
    }

    $stmt = $pdo->prepare("UPDATE kuliner SET nama=?, alamat=?, deskripsi=?, kategori=?, rating=?, foto=? WHERE id=?");
    if ($stmt->execute([$nama, $alamat, $deskripsi, $kategori, $rating, $foto, $id])) {
        $success = "Kuliner berhasil diperbarui!";
        $kuliner = array_merge($kuliner, $_POST, ['foto' => $foto]);
    } else {
        $error = "Gagal memperbarui!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Kuliner</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card mx-auto" style="max-width: 600px;">
      <div class="card-header bg-warning text-dark text-center">
        <h4><i class="fas fa-edit"></i> Edit Kuliner</h4>
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
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($kuliner['nama']) ?>" required>
          </div>
          <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($kuliner['alamat']) ?>" required>
          </div>
          <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" required><?= htmlspecialchars($kuliner['deskripsi']) ?></textarea>
          </div>
          <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-control" required>
              <option value="Makanan" <?= $kuliner['kategori'] == 'Makanan' ? 'selected' : '' ?>>Makanan</option>
              <option value="Minuman" <?= $kuliner['kategori'] == 'Minuman' ? 'selected' : '' ?>>Minuman</option>
              <option value="Tempat Nongkrong" <?= $kuliner['kategori'] == 'Tempat Nongkrong' ? 'selected' : '' ?>>Tempat Nongkrong</option>
            </select>
          </div>
          <div class="mb-3">
            <label>Rating</label>
            <input type="number" step="0.1" min="0" max="5" name="rating" class="form-control" value="<?= $kuliner['rating'] ?>" required>
          </div>
          <div class="mb-3">
            <label>Foto Saat Ini</label><br>
            <img src="../assets/img/<?= $kuliner['foto'] ?>" alt="" width="200" class="img-thumbnail">
          </div>
          <div class="mb-3">
            <label>Ganti Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
          </div>
          <button type="submit" class="btn btn-warning w-100">
            <i class="fas fa-save"></i> Update + Cari Gambar Otomatis
          </button>
          <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
        </form>
      </div>
    </div>
  </div>
</body>
</html>