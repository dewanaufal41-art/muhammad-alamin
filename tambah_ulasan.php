<?php
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $kuliner_id = $_POST['kuliner_id'];
  $nama = trim($_POST['nama_pengguna']);
  $rating = $_POST['rating'];
  $komentar = trim($_POST['komentar']);

  $stmt = $pdo->prepare("INSERT INTO ulasan (kuliner_id, nama_pengguna, rating, komentar) VALUES (?, ?, ?, ?)");
  $stmt->execute([$kuliner_id, $nama, $rating, $komentar]);

  header("Location: detail.php?id=$kuliner_id&status=success");
  exit;
}
?>
