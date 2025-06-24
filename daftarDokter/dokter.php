<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['username'])) {
  header("Location: ../auth/loginn.php");
  exit();
}

$query = "
  SELECT d.id, d.nama, s.nama_spesialis
  FROM dokter d
  JOIN spesialis s ON d.spesialis_id = s.id
  ORDER BY d.id ASC
";
$dokter = $conn->query($query) or die("Query Error: " . $conn->error);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Dokter - Klinikku</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Raleway:wght@600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }
    .navbar-brand h1 {
      font-family: 'Raleway', sans-serif;
      font-size: 30px;
      font-weight: 700;
      color: #124265;
      margin: 0;
    }
    .hero-section {
      background: linear-gradient(rgba(255,255,255,0.85), rgba(255,255,255,0.85)),
        url('../assets/img/hero-bg.jpg') no-repeat center center;
      background-size: cover;
      padding: 60px 0;
      text-align: center;
    }
    .hero-section h2 {
      font-weight: 700;
      color: #124265;
      margin-bottom: 10px;
    }
    .hero-section p {
      color: #6c757d;
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
<section class="hero-section">
  <div class="container">
    <h2>Daftar Dokter</h2>
    <p class="text-muted">Informasi dokter dan spesialisasi yang tersedia di Klinik-ku</p>
  </div>
</section>

<!-- Tombol Booking di Tengah -->
<div class="container text-center mt-4">
  <a href="../booking/booking_konsultasi.php" class="btn btn-success btn-lg">Booking Konsultasi</a>
</div>

<div class="container py-5">
  <div class="row">
    <?php if ($dokter->num_rows > 0): ?>
      <?php $i = 1; while($d = $dokter->fetch_assoc()): ?>
      <div class="col-md-6 mb-3">
        <div class="p-3 bg-white shadow-sm rounded">
          <strong><?= $i++ ?>. <?= htmlspecialchars($d['nama']) ?></strong><br>
          <small class="text-muted">Spesialis <?= htmlspecialchars($d['nama_spesialis']) ?></small>
        </div>
      </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-12"><p class="text-muted">Belum ada dokter.</p></div>
    <?php endif; ?>
  </div>
</div>

<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
