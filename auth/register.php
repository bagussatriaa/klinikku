<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap'] ?? '');
    $username     = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
    $email        = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $password     = $_POST['password'] ?? '';

    if (empty($username) || empty($password) || empty($nama_lengkap) || empty($email)) {
        $error = "Semua field wajib diisi!";
    } else {
        $queryCek = "SELECT * FROM users WHERE username = '$username'";
        $resultCek = mysqli_query($conn, $queryCek);

        if (mysqli_num_rows($resultCek) > 0) {
            $error = "Username sudah digunakan, coba yang lain.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $queryInsert = "INSERT INTO users (username, password, role, nama_lengkap, email)
                            VALUES ('$username', '$hashed_password', 'pasien', '$nama_lengkap', '$email')";

            if (mysqli_query($conn, $queryInsert)) {
                $success = "Registrasi berhasil! Silakan <a href='loginn.php'>login</a>.";
            } else {
                $error = "Gagal registrasi: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register | Klinik-ku</title>
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #83a4d4, #b6fbff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .register-card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 40px 30px;
      width: 100%;
      max-width: 480px;
    }

    .register-card h3 {
      font-weight: 700;
      color: #124265;
      margin-bottom: 30px;
    }

    .btn-primary {
      background-color: #124265;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0f3a58;
    }

    .form-control:focus {
      border-color: #124265;
      box-shadow: 0 0 0 0.2rem rgba(18, 66, 101, 0.25);
    }

    .alert {
      font-size: 0.9rem;
    }

    .login-link {
      font-size: 0.9rem;
      text-align: center;
      margin-top: 10px;
    }

    .login-link a {
      color: #124265;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="register-card">
    <h3 class="text-center">Daftar Akun Klinik-ku</h3>

    <?php if(isset($error)): ?>
      <div class="alert alert-danger alert-dismissible fade show"><?= $error ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if(isset($success)): ?>
      <div class="alert alert-success alert-dismissible fade show"><?= $success ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" required>
      </div>

      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" id="username" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" required>
      </div>

      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">Register</button>
      </div>

      <div class="login-link">
        Sudah punya akun? <a href="loginn.php">Login di sini</a>
      </div>
    </form>
  </div>

  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
