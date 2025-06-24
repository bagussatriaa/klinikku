<?php
// File: crud_riwayat_konsultasi.php (ADMIN)
session_start();
include '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
  header("Location: ../auth/loginn.php");
  exit();
}

// Tambah riwayat
if (isset($_POST['simpan'])) {
  $booking_id = intval($_POST['booking_id']);
  $cek = $conn->query("SELECT * FROM riwayat_konsultasi WHERE booking_id = $booking_id") or die($conn->error);
  if ($cek->num_rows == 0) {
    $insert = $conn->query("INSERT INTO riwayat_konsultasi (booking_id) VALUES ($booking_id)") or die($conn->error);
    $_SESSION['success'] = "Riwayat konsultasi berhasil disimpan.";
  } else {
    $_SESSION['success'] = "Data sudah ada di riwayat.";
  }
  header("Location: crud_riwayat_konsultasi.php#riwayat");
  exit();
}

// Hapus riwayat
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  $conn->query("DELETE FROM riwayat_konsultasi WHERE id = $id") or die($conn->error);
  $_SESSION['success'] = "Data riwayat berhasil dihapus.";
  header("Location: crud_riwayat_konsultasi.php#riwayat");
  exit();
}

$opsi = $conn->query("SELECT b.id AS booking_id, b.nama_pasien, d.nama AS nama_dokter, r.keluhan, r.resep, b.tanggal, b.waktu 
  FROM booking_konsultasi b 
  JOIN dokter d ON b.dokter_id = d.id 
  JOIN rekam_medis r ON r.booking_id = b.id 
  WHERE b.status = 'Selesai'") or die($conn->error);

$riwayat = $conn->query("SELECT rk.id, b.id AS booking_id, b.nama_pasien, d.nama AS nama_dokter, r.keluhan, r.resep, b.tanggal, b.waktu 
  FROM riwayat_konsultasi rk 
  LEFT JOIN booking_konsultasi b ON rk.booking_id = b.id 
  LEFT JOIN dokter d ON b.dokter_id = d.id 
  LEFT JOIN rekam_medis r ON r.booking_id = b.id 
  ORDER BY rk.id DESC") or die($conn->error);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Konsultasi - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {font-family: 'Poppins', sans-serif; background: #f8f9fa;}
    h2 {color: #124265; font-weight: 700;}
    .navbar-brand {color: #124265; font-weight: 700; font-size: 24px;}
    .form-label {font-weight: 600;}
    .table th {background: #124265; color: #fff; font-weight: 600;}
    .table-container {background: #fff; border-radius: 10px; padding: 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);}
    .btn-primary {font-weight: 600;}
  </style>
</head>
<body>
<nav class="navbar navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">Klinik-ku</a>
  </div>
</nav>

<div class="container mt-5">
  <h2 class="text-center mb-4">Riwayat Konsultasi</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success text-center">
      <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
  <?php endif; ?>

  <form method="POST" class="card p-4 mb-5">
    <div class="mb-3">
      <label class="form-label">Pilih Data Booking</label>
      <select name="booking_id" class="form-select" required>
        <option value="">-- Pilih --</option>
        <?php while ($row = $opsi->fetch_assoc()): ?>
          <option value="<?= $row['booking_id'] ?>">
            <?= $row['nama_pasien'] ?> - <?= $row['nama_dokter'] ?> (<?= $row['tanggal'] ?> <?= $row['waktu'] ?>)
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan Riwayat</button>
  </form>
<div class="table-container" id="riwayat">
    <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th>Nama Pasien</th>
            <th>Nama Dokter</th>
            <th>Keluhan</th>
            <th>Resep</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($r = $riwayat->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($r['nama_pasien'] ?? '-') ?></td>
              <td><?= htmlspecialchars($r['nama_dokter'] ?? '-') ?></td>
              <td><?= htmlspecialchars($r['keluhan'] ?? '-') ?></td>
              <td><?= htmlspecialchars($r['resep'] ?? '-') ?></td>
              <td><?= htmlspecialchars($r['tanggal'] ?? '-') ?></td>
              <td><?= htmlspecialchars($r['waktu'] ?? '-') ?></td>
              <td>
                <a href="?hapus=<?= $r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>