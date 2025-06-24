<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error SQL: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            $_SESSION['success'] = "Selamat datang, {$user['username']}! Login berhasil.";

            if ($user['role'] == 'admin') {
                header("Location: ../admin/dashboard.php");
            } elseif ($user['role'] == 'dokter') {
                header("Location: dokter_dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Klinik-ku</title>

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

    .login-card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 40px 30px;
      width: 100%;
      max-width: 420px;
    }

    .login-card h3 {
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

    .buatAkun a {
      font-size: 0.9rem;
      text-decoration: none;
      color: #124265;
    }

    .buatAkun a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>

  <div class="login-card">
    <h3 class="text-center">Login Klinik-ku</h3>

    <?php if (isset($_GET['logout']) && $_GET['logout'] == 'success'): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Anda berhasil logout. Silakan login kembali.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if(isset($error)): ?>
      <div class="alert alert-danger alert-dismissible fade show"><?= $error ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" id="username" required autofocus>
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">Login</button>
      </div>

      <div class="text-center buatAkun">
        <a href="register.php">Belum punya akun? Daftar di sini</a>
      </div>
    </form>
  </div>

  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
