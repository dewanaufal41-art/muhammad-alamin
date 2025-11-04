<?php
include 'config/database.php';

$id = $_GET['id'] ?? null;
if (!$id) {
  header("Location: index.php");
  exit;
}

// Ambil data kuliner
$stmt = $pdo->prepare("SELECT * FROM kuliner WHERE id = ?");
$stmt->execute([$id]);
$kuliner = $stmt->fetch(PDO::FETCH_ASSOC);

// Ambil ulasan
$ulasanStmt = $pdo->prepare("SELECT * FROM ulasan WHERE kuliner_id = ? ORDER BY tanggal DESC");
$ulasanStmt->execute([$id]);
$ulasanList = $ulasanStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($kuliner['nama']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6">
        <img src="assets/img/<?= htmlspecialchars($kuliner['foto'] ?: 'default.jpg') ?>" 
             class="img-fluid rounded" alt="<?= htmlspecialchars($kuliner['nama']) ?>">
      </div>
      <div class="col-md-6">
        <h1><?= htmlspecialchars($kuliner['nama']) ?></h1>
        <p><strong>Alamat:</strong> <?= htmlspecialchars($kuliner['alamat']) ?></p>
        <p><strong>Kategori:</strong> <?= htmlspecialchars($kuliner['kategori']) ?></p>
        <p><strong>Rating:</strong> ⭐ <?= htmlspecialchars($kuliner['rating']) ?></p>
        <hr>
        <p><?= nl2br(htmlspecialchars($kuliner['deskripsi'])) ?></p>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
      </div>
    </div>

    <hr>
    <h5>Berikan Ulasan</h5>
    <form action="tambah_ulasan.php" method="POST" id="ulasanForm" class="mb-4">
      <input type="hidden" name="kuliner_id" value="<?= $kuliner['id'] ?>">

      <div class="mb-3">
        <label>Nama Anda</label>
        <input type="text" name="nama_pengguna" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Rating</label>
        <select name="rating" class="form-select" required>
          <option value="5">⭐⭐⭐⭐⭐ (5)</option>
          <option value="4">⭐⭐⭐⭐ (4)</option>
          <option value="3">⭐⭐⭐ (3)</option>
          <option value="2">⭐⭐ (2)</option>
          <option value="1">⭐ (1)</option>
        </select>
      </div>

      <div class="mb-3">
        <label>Komentar</label>
        <textarea name="komentar" class="form-control" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
    </form>

    <hr>
    <h5>Ulasan Pengunjung</h5>
    <?php if (count($ulasanList) > 0): ?>
      <?php foreach ($ulasanList as $u): ?>
        <div class="border rounded p-3 mb-3 bg-light">
          <strong><?= htmlspecialchars($u['nama_pengguna']) ?></strong>
          <div class="text-warning">
            <?= str_repeat("★", $u['rating']) . str_repeat("☆", 5 - $u['rating']) ?>
          </div>
          <p class="mb-1"><?= nl2br(htmlspecialchars($u['komentar'])) ?></p>
          <small class="text-muted"><?= $u['tanggal'] ?></small>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-muted">Belum ada ulasan untuk tempat ini.</p>
    <?php endif; ?>
  </div>

  <script>
    // Tampilkan SweetAlert setelah kirim ulasan (redirect dari tambah_ulasan.php)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'success') {
      Swal.fire({
        icon: 'success',
        title: 'Terima kasih!',
        text: 'Ulasan kamu berhasil dikirim 😊',
        timer: 2000,
        showConfirmButton: false
      });
    }
  </script>
</body>
</html>
