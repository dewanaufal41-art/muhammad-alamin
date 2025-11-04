<?php
session_start();
if (!isset($_SESSION['admin'])) { 
  header("Location: index.php"); 
  exit; 
}

include '../config/database.php';
$stmt = $pdo->query("SELECT * FROM kuliner");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - Kuliner Jogja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .navbar {
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .table img {
      border-radius: 8px;
    }
    .btn-back {
      border-radius: 50px;
      font-weight: 500;
      transition: all 0.2s ease;
    }
    .btn-back:hover {
      transform: translateX(-2px);
    }
    footer {
      margin-top: 30px;
      padding: 20px 0;
      background-color: #fff;
      border-top: 1px solid #ddd;
      text-align: center;
      font-size: 14px;
      color: #777;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <span class="navbar-brand fw-semibold">
        <i class="fas fa-cog"></i> Admin - Kuliner Jogja
      </span>
      <div>
        <a href="../index.php" class="btn btn-outline-light btn-sm me-2">
          <i class="fas fa-home"></i> Kembali
        </a>
        <a href="logout.php" class="btn btn-outline-light btn-sm">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="fw-bold">Daftar Kuliner</h4>
      <a href="tambah.php" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Kuliner
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
          <tr>
            <th>Foto</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Rating</th>
            <th width="150">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $stmt->fetch()) { ?>
            <tr>
              <td class="text-center">
                <img src="../assets/img/<?= htmlspecialchars($row['foto']) ?>" 
                     width="60" height="60" style="object-fit:cover;"
                     onerror="this.onerror=null;this.src='../assets/img/default.jpg';">
              </td>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= htmlspecialchars($row['kategori']) ?></td>
              <td class="text-center">
                <i class="fas fa-star text-warning"></i> <?= htmlspecialchars($row['rating']) ?>
              </td>
              <td class="text-center">
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                  <i class="fas fa-edit"></i> Edit
                </a>
                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger btn-hapus">
                  <i class="fas fa-trash"></i> Hapus
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- Tombol kembali di bawah -->
    <div class="text-center mt-4">
      <a href="../index.php" class="btn btn-secondary btn-back px-4 py-2">
        <i class="fas fa-arrow-left"></i> Kembali ke Halaman Utama
      </a>
    </div>
  </div>

  <footer>
    <p>© <?= date('Y') ?> Kuliner Jogja | Admin Panel</p>
  </footer>

  <script>
    // Ambil parameter URL (status)
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'deleted') {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data kuliner telah dihapus.',
        showConfirmButton: false,
        timer: 1500
      });
    } else if (status === 'error') {
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: 'Terjadi kesalahan saat menghapus data.',
        showConfirmButton: false,
        timer: 1500
      });
    }

    // SweetAlert konfirmasi hapus
    document.querySelectorAll('.btn-hapus').forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        const href = this.getAttribute('href');

        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: "Data kuliner ini akan dihapus permanen!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = href;
          }
        });
      });
    });
  </script>

</body>
</html>
