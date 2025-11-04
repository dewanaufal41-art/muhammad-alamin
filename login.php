<?php
session_start();
include '../config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // MANUAL CHECK: admin / alamin123
    if ($username === 'admin' && $password === 'alamin123') {
        // Simpan session
        $_SESSION['admin'] = 1;
        header("Location: ../index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
    if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin | Kuliner Jogja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
      border: none;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0,0,0,0.3);
      background: rgba(255, 255, 255, 0.95);
    }
    .login-header {
      background: linear-gradient(45deg, #ff6b6b, #feca57);
      color: white;
      padding: 2rem;
      text-align: center;
    }
    .btn-login {
      background: linear-gradient(45deg, #ff6b6b, #feca57);
      border: none;
      border-radius: 12px;
      padding: 0.75rem;
      font-weight: 600;
    }
    .btn-login:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(255, 107, 107, 0.4);
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-md-4 col-sm-8">
        <div class="card login-card">
          <div class="login-header">
            <h3><i class="fas fa-user-shield"></i> ADMIN PANEL</h3>
          </div>
          <div class="card-body p-4">
            <?php if ($error): ?>
              <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
              <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" value="admin" required>
              </div>
              <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" value="alamin123" required>
              </div>
              <button type="submit" class="btn btn-login text-white w-100">
                <i class="fas fa-sign-in-alt"></i> MASUK
              </button>
            </form>

            <hr class="my-4">
            <div class="text-center">
              <small class="text-muted">
                <strong>Manual:</strong> <code class="bg-light px-2 py-1 rounded">admin</code> / 
                <code class="bg-light px-2 py-1 rounded">alamin123</code>
              </small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>