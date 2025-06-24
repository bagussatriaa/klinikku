<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['username'])) {
  header("Location: ../auth/loginn.php");
  exit();
}

$ruangan = $conn->query("
  SELECT r.id, dr.nama AS nama, r.status
  FROM ruangan r
  JOIN daftar_ruang dr ON r.id_nama_ruang = dr.id
");?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Ruangan - Klinikku</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
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
      font-size: 32px;
    }
    .ruangan-box {
      background: #ffffff;
      border: 1px solid #dee2e6;
      border-radius: 12px;
      padding: 30px 20px;
      text-align: center;
      box-shadow: 0 3px 10px rgba(0,0,0,0.06);
      transition: 0.3s ease;
    }
    .ruangan-box:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    }
    .ruangan-box h5 {
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 12px;
    }
    .status {
      font-weight: 500;
      font-size: 13px;
      padding: 6px 14px;
      border-radius: 20px;
      display: inline-block;
      letter-spacing: 0.5px;
    }
    .Dipakai { background-color: #ffc107; color: #000; }
    .Kosong { background-color: #198754; color: #fff; }
    .Maintenance { background-color: #dc3545; color: #fff; }
    .filter-select {
      max-width: 200px;
      margin: 0 auto 40px;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand" href="../index.php">
      <h1>Klinik-ku</h1>
    </a>
  </div>
</nav>

<section class="hero">
  <div class="container">
    <h2>Daftar Ruangan</h2>
    <p class="text-muted mb-0">Lihat status ruangan yang tersedia di Klinik-ku</p>
  </div>
</section>

<div class="container">
  <div class="filter-select text-center mt-4">
    <select id="filterStatus" class="form-select">
      <option value="All">Tampilkan Semua</option>
      <option value="Kosong">Kosong</option>
      <option value="Dipakai">Dipakai</option>
      <option value="Maintenance">Maintenance</option>
    </select>
  </div>
</div>

<div class="container py-4">
  <div class="row" id="ruanganContainer">
    <?php while ($row = $ruangan->fetch_assoc()): ?>
      <div class="col-md-4 mb-4 ruangan-item" data-status="<?= $row['status'] ?>">
        <div class="ruangan-box">
          <h5><?= htmlspecialchars($row['nama']) ?></h5>
          <span class="status <?= $row['status'] ?>"><?= $row['status'] ?></span>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
  const filter = document.getElementById('filterStatus');
  const items = document.querySelectorAll('.ruangan-item');

  filter.addEventListener('change', function () {
    const selected = this.value;
    items.forEach(item => {
      const status = item.getAttribute('data-status');
      item.style.display = (selected === 'All' || status === selected) ? 'block' : 'none';
    });
  });
</script>
</body>
</html>
