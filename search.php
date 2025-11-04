<?php
include 'config/database.php';
$q = $_GET['q'];
$stmt = $pdo->prepare("SELECT * FROM kuliner WHERE nama LIKE ? OR kategori LIKE ?");
$stmt->execute(["%$q%", "%$q%"]);
?>
<!DOCTYPE html>
<html><head><!-- Bootstrap same as index --></head><body>
<div class="container mt-4">
  <h3>Hasil pencarian: "<?= htmlspecialchars($q) ?>"</h3>
  <div class="row">
    <?php while ($row = $stmt->fetch()) { ?>
      <div class="col-md-4"> <!-- same card as index.php --> </div>
    <?php } ?>
  </div>
</div>
</body></html>