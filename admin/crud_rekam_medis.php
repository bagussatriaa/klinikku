<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
  header("Location: ../auth/loginn.php");
  exit();
}

// Tambah atau update rekam medis
if (isset($_POST['simpan'])) {
  $booking_id = intval($_POST['booking_id']);
  $keluhan = trim($_POST['keluhan']);
  $resep = trim($_POST['resep']);

  // Cek apakah data rekam medis untuk booking ini sudah ada
  $cek = $conn->query("SELECT * FROM rekam_medis WHERE booking_id = $booking_id");
  if ($cek->num_rows > 0) {
    $conn->query("UPDATE rekam_medis SET keluhan = '$keluhan', resep = '$resep' WHERE booking_id = $booking_id");
    $_SESSION['success'] = "Rekam medis berhasil diperbarui.";
  } else {
    $conn->query("INSERT INTO rekam_medis (booking_id, keluhan, resep) VALUES ($booking_id, '$keluhan', '$resep')");
    $_SESSION['success'] = "Rekam medis berhasil disimpan.";
  }
  header("Location: crud_rekam_medis.php");
  exit();
}

// Hapus data
if (isset($_GET['hapus'])) {
  $booking_id = intval($_GET['hapus']);
  $conn->query("DELETE FROM rekam_medis WHERE booking_id = $booking_id");
  $_SESSION['success'] = "Data rekam medis berhasil dihapus.";
  header("Location: crud_rekam_medis.php");
  exit();
}

$booking = $conn->query("SELECT b.id, b.nama_pasien, d.nama AS nama_dokter FROM booking_konsultasi b JOIN dokter d ON b.dokter_id = d.id WHERE b.status = 'Selesai'");
$rekam = $conn->query("
  SELECT r.booking_id, r.keluhan, r.resep, b.nama_pasien, d.nama AS nama_dokter 
  FROM rekam_medis r 
  JOIN booking_konsultasi b ON r.booking_id = b.id 
  JOIN dokter d ON b.dokter_id = d.id 
  ORDER BY r.booking_id DESC
");
if (!$rekam) {
  die("Query rekam_medis gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>CRUD Rekam Medis - Klinik-ku</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
      font-size: 15px;
    }
    .navbar-brand {
      font-weight: 700;
      color: #124265;
      font-size: 24px;
    }
    h2 {
      font-size: 28px;
      font-weight: 700;
      color: #124265;
    }
    .form-label {
      font-weight: 600;
      font-size: 15px;
    }
    .table th {
      background-color: #124265;
      color: #fff;
      font-weight: 600;
      font-size: 15px;
    }
    .table td {
      font-size: 14px;
    }
    .table-container {
      background: #fff;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    textarea.form-control {
      min-height: 80px;
    }
    .btn-primary {
      font-weight: 600;
    }
    .alert-success {
      font-weight: 500;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">Klinik-ku</a>
  </div>
</nav>

<div class="container mt-5">
  <h2 class="text-center mb-4">Rekam Medis</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success text-center"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <form method="POST" class="card p-4 mb-5">
    <div class="mb-3">
      <label class="form-label">Pasien & Dokter</label>
      <select name="booking_id" class="form-select" required>
        <option value="">-- Pilih --</option>
        <?php while ($b = $booking->fetch_assoc()): ?>
          <option value="<?= $b['id'] ?>"><?= $b['nama_pasien'] ?> - <?= $b['nama_dokter'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Keluhan</label>
      <textarea name="keluhan" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Resep</label>
      <textarea name="resep" class="form-control" required></textarea>
    </div>
    <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan / Update Rekam Medis</button>
  </form>

  <div class="table-container">
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="text-center">
          <tr>
            <th>No</th>
            <th>Nama Pasien</th>
            <th>Nama Dokter</th>
            <th>Keluhan</th>
            <th>Resep</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($rekam->num_rows > 0): $no = 1; ?>
            <?php while ($r = $rekam->fetch_assoc()): ?>
              <tr>
                <td class="text-center fw-semibold"><?= $no++ ?></td>
                <td><?= htmlspecialchars($r['nama_pasien']) ?></td>
                <td><?= htmlspecialchars($r['nama_dokter']) ?></td>
                <td><?= htmlspecialchars($r['keluhan']) ?></td>
                <td><?= htmlspecialchars($r['resep']) ?></td>
                <td class="text-center">
                  <a href="?hapus=<?= $r['booking_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center text-muted">Belum ada data.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
