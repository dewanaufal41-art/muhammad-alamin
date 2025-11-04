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
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.95);
    }
    .login-header {
      background: linear-gradient(45deg, #ff6b6b, #feca57);
      color: white;
      padding: 2rem;
      text-align: center;
    }
    .login-header h3 {
      margin: 0;
      font-weight: 700;
      letter-spacing: 1px;
    }
    .login-body {
      padding: 2.5rem;
    }
    .form-control {
      border-radius: 12px;
      padding: 0.75rem 1rem;
      border: 2px solid #e0e0e0;
      transition: all 0.3s;
    }
    .form-control:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    .btn-login {
      background: linear-gradient(45deg, #667eea, #764ba2);
      border: none;
      border-radius: 12px;
      padding: 0.75rem;
      font-weight: 600;
      letter-spacing: 1px;
      transition: all 0.3s;
    }
    .btn-login:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
    }
    .input-group-text {
      background: transparent;
      border-radius: 12px 0 0 12px;
      border: 2px solid #e0e0e0;
      border-right: none;
    }
    .logo {
      width: 80px;
      height: 80px;
      background: white;
      border-radius: 50%;
      margin: 0 auto -40px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      z-index: 10;
      position: relative;
    }
    .logo i {
      font-size: 2.5rem;
      color: #667eea;
    }
    .credit {
      font-size: 0.8rem;
      color: rgba(255,255,255,0.7);
      text-align: center;
      margin-top: 2rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-md-4 col-sm-8">
        
        <!-- Logo -->
        <div class="text-center mb-4">
          <div class="logo">
            <i class="fas fa-utensils"></i>
          </div>
        </div>

        <!-- Card Login -->
        <div class="card login-card">
          <div class="login-header">
            <h3><i class="fas fa-crown"></i> ADMIN PANEL</h3>
          </div>
          <div class="card-body login-body">
            <form method="POST">
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" name="username" class="form-control" placeholder="Username" value="admin" required>
                </div>
              </div>
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  <input type="password" name="password" class="form-control" placeholder="Password" value="admin123" required>
                </div>
              </div>
              <button type="submit" class="btn btn-login text-white w-100">
                <i class="fas fa-sign-in-alt"></i> MASUK SEKARANG
              </button>
            </form>

            <hr class="my-4">
            <div class="text-center">
              <small class="text-muted">
                <i class="fas fa-info-circle"></i> 
                Default: <code class="bg-light px-2 py-1 rounded">admin</code> / 
                <code class="bg-light px-2 py-1 rounded">admin123</code>
              </small>
            </div>
          </div>
        </div>

        <!-- Credit -->
        <div class="credit">
          © 2025 Kuliner Jogja - Made with <i class="fas fa-heart text-danger"></i> by al amin
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>