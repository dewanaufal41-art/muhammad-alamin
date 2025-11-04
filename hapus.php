<?php
session_start();
if (!isset($_SESSION['admin'])) { 
  header("Location: index.php"); 
  exit; 
}

include '../config/database.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  try {
    // Ambil data kuliner dulu buat hapus file foto-nya
    $stmt = $pdo->prepare("SELECT foto FROM kuliner WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();

    if ($data && !empty($data['foto']) && file_exists("../assets/img/" . $data['foto'])) {
      unlink("../assets/img/" . $data['foto']);
    }

    // Hapus data dari database
    $stmt = $pdo->prepare("DELETE FROM kuliner WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: dashboard.php?status=deleted");
    exit;
  } catch (Exception $e) {
    header("Location: dashboard.php?status=error");
    exit;
  }
} else {
  header("Location: dashboard.php?status=error");
  exit;
}
?>
