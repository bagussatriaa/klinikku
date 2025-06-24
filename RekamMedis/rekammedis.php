<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['username'])) {
  header("Location: ../auth/loginn.php");
  exit();
}

// Ambil data rekam medis dari database
$rekam = $conn->query("
  SELECT r.keluhan, r.resep, b.nama_pasien, d.nama AS nama_dokter
  FROM rekam_medis r
  JOIN booking_konsultasi b ON r.booking_id = b.id
  JOIN dokter d ON b.dokter_id = d.id
  ORDER BY r.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Rekam Medis - Klinik-ku</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    .navbar-brand h1 {
      font-size: 28px;
      font-weight: 700;
      color: #124265;
      margin: 0;
    }

    .hero {
      background: linear-gradient(rgba(255,255,255,0.85), rgba(255,255,255,0.85)),
        url('../assets/img/hero-bg.jpg') no-repeat center center;
      background-size: cover;
      padding: 60px 0;
      text-align: center;
    }

    .hero h2 {
      color: #124265;
      font-weight: 700;
    }

    .table th {
      background-color: #124265;
      color: #fff;
      font-weight: 600;
    }

    .table td, .table th {
      vertical-align: middle;
    }

    .table-container {
      background: #fff;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand" href="../index.php">
      <h1>Klinik-ku</h1>
    </a>
  </div>
</nav>

<!-- Hero -->
<section class="hero">
  <div class="container">
    <h2>Rekam Medis</h2>
    <p class="text-muted">Riwayat pemeriksaan dan resep pasien di Klinik-ku</p>
  </div>
</section>

<!-- Tabel Rekam Medis -->
<div class="container py-5">
  <div class="table-container">
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead>
          <tr class="text-center">
            <th>No</th>
            <th>Nama Pasien</th>
            <th>Nama Dokter</th>
            <th>Keluhan</th>
            <th>Resep</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($rekam->num_rows > 0): $no = 1; ?>
            <?php while ($row = $rekam->fetch_assoc()): ?>
              <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_pasien']) ?></td>
                <td><?= htmlspecialchars($row['nama_dokter']) ?></td>
                <td><?= htmlspecialchars($row['keluhan']) ?></td>
                <td><?= htmlspecialchars($row['resep']) ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center text-muted">Belum ada rekam medis.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
