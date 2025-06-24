<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../auth/loginn.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Dashboard Admin - Klinik-ku</title>

  <!-- Fonts & Icon -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />

  <!-- CSS -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/main.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f8fb;
    }
    .admin-section {
      padding: 60px 0;
    }
    .admin-card {
      transition: transform 0.2s;
    }
    .admin-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body class="index-page">

<!-- Header -->
<header id="header" class="header sticky-top">
  <div class="branding d-flex align-items-center">
    <div class="container d-flex justify-content-between align-items-center">
      <a href="../index.php" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Klinik-ku</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="../daftarDokter/dokter.php">Dokter</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <div class="d-flex align-items-center ms-4">
        <strong class="me-3 text-dark">Admin: <?= htmlspecialchars($_SESSION['username']) ?></strong>
        <a class="btn btn-danger" href="../auth/logout.php">Logout</a>
      </div>
    </div>
  </div>
</header>

<!-- Dashboard Section -->
<section class="admin-section">
  <div class="container">
    <div class="section-title text-center mb-5">
      <h2>Dashboard Admin</h2>
      <p>Kelola semua data dan layanan klinik secara real-time</p>
    </div>

    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <a href="dokter_crud.php" class="text-decoration-none text-dark">
          <div class="card admin-card shadow-sm p-4 text-center">
            <i class="bi bi-person-vcard fs-1 text-primary"></i>
            <h5 class="mt-3">Daftar Dokter</h5>
            <p class="text-muted">Tambah, ubah, atau hapus data dokter.</p>
          </div>
        </a>
      </div>

      <div class="col-lg-4 col-md-6">
        <a href="crud_booking.php" class="text-decoration-none text-dark">
          <div class="card admin-card shadow-sm p-4 text-center">
            <i class="bi bi-calendar-check fs-1 text-success"></i>
            <h5 class="mt-3">Booking Konsultasi</h5>
            <p class="text-muted">Atur jadwal & slot konsultasi.</p>
          </div>
        </a>
      </div>

      <div class="col-lg-4 col-md-6">
        <a href="crud_rekam_medis.php" class="text-decoration-none text-dark">
          <div class="card admin-card shadow-sm p-4 text-center">
            <i class="bi bi-journal-medical fs-1 text-warning"></i>
            <h5 class="mt-3">Rekam Medis</h5>
            <p class="text-muted">Lihat & kelola data kesehatan pasien.</p>
          </div>
        </a>
      </div>

      <div class="col-lg-6 col-md-6">
        <a href="crud_ruangan.php" class="text-decoration-none text-dark">
          <div class="card admin-card shadow-sm p-4 text-center">
            <i class="bi bi-hospital fs-1 text-danger"></i>
            <h5 class="mt-3">Ruangan Tersedia</h5>
            <p class="text-muted">Pantau & atur status ruangan klinik.</p>
          </div>
        </a>
      </div>

      <div class="col-lg-6 col-md-6">
        <a href="crud_riwayat_konsultasi.php" class="text-decoration-none text-dark">
          <div class="card admin-card shadow-sm p-4 text-center">
            <i class="bi bi-clock-history fs-1 text-info"></i>
            <h5 class="mt-3">Riwayat Konsultasi</h5>
            <p class="text-muted">Cek seluruh riwayat pasien & dokter.</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer id="footer" class="footer mt-5">
  <div class="container text-center">
    <p>© 2025 <strong class="sitename">Klinik-ku</strong>. All Rights Reserved</p>
  </div>
</footer>

<!-- JS -->
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
