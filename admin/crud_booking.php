<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
  header("Location: ../auth/loginn.php");
  exit();
}

// Aksi
if (isset($_GET['aksi']) && isset($_GET['id'])) {
  $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;


  if ($id > 0) {
  if ($_GET['aksi'] == 'selesai') {
    $conn->query("UPDATE booking_konsultasi SET status = 'Selesai' WHERE id = $id");
  } elseif ($_GET['aksi'] == 'tolak') {
    $conn->query("UPDATE booking_konsultasi SET status = 'Ditolak' WHERE id = $id");
  } elseif ($_GET['aksi'] == 'hapus') {
    $conn->query("DELETE FROM booking_konsultasi WHERE id = $id");
  }
  header("Location: crud_booking.php?notif=1");
  exit();
} }

$booking = $conn->query("SELECT b.id, b.nama_pasien, d.nama AS nama_dokter, b.tanggal, b.waktu, b.ruangan, b.status FROM booking_konsultasi b JOIN dokter d ON b.dokter_id = d.id ORDER BY b.id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Booking - Admin Klinik-ku</title>
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }
    .navbar {
      background-color: #fff;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .navbar-brand {
      font-weight: 700;
      font-size: 24px;
      color: #124265 !important;
    }
    h2 {
      font-weight: 600;
      color: #124265;
    }
    .table thead {
      background-color: #e9f0f7;
    }
    .badge {
      font-size: 0.85rem;
    }
    .btn-sm i {
      margin-right: 4px;
    }
    #notif {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 1050;
      background-color: #198754;
      color: #fff;
      padding: 10px 25px;
      border-radius: 30px;
      font-size: 14px;
      font-weight: 500;
      display: none;
      opacity: 0;
      transition: opacity 0.4s ease;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">Klinik-ku</a>
  </div>
</nav>

<!-- Notifikasi -->
<div id="notif">Perubahan berhasil disimpan!</div>

<!-- Konten -->
<div class="container" style="margin-top: 90px;">
  <h2 class="mb-4 text-center">Manajemen Booking Konsultasi</h2>
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Pasien</th>
          <th>Nama Dokter</th>
          <th>Tanggal</th>
          <th>Waktu</th>
          <th>Ruangan</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($booking->num_rows > 0): ?>
          <?php $no = 1; while ($row = $booking->fetch_assoc()): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['nama_pasien']) ?></td>
              <td><?= htmlspecialchars($row['nama_dokter']) ?></td>
              <td><?= htmlspecialchars($row['tanggal']) ?></td>
              <td><?= htmlspecialchars($row['waktu']) ?></td>
              <td><?= htmlspecialchars($row['ruangan']) ?></td>
              <td>
                <span class="badge bg-<?= 
                  $row['status'] == 'Selesai' ? 'success' : 
                  ($row['status'] == 'Ditolak' ? 'danger' : 'warning') ?>">
                  <?= $row['status'] ?>
                </span>
              </td>
              <td>
                  <?php if ($row['status'] == 'Menunggu'): ?>
                    <a href="crud_booking.php?aksi=selesai&id=<?= $row['id'] ?>" class="btn btn-success btn-sm">
                      <i class="bi bi-check-circle"></i>Selesai
                    </a>
                    <a href="crud_booking.php?aksi=tolak&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">
                      <i class="bi bi-x-circle"></i>Tolak
                    </a>
                  <?php endif; ?>
                  <a href="crud_booking.php?aksi=hapus&id=<?= $row['id'] ?>" class="btn btn-secondary btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                    <i class="bi bi-trash"></i>Hapus
                  </a>
                </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" class="text-center">Belum ada booking.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('notif') === '1') {
    const notif = document.getElementById('notif');
    notif.style.display = 'block';
    setTimeout(() => notif.style.opacity = '1', 100);
    setTimeout(() => {
      notif.style.opacity = '0';
      setTimeout(() => notif.style.display = 'none', 400);
    }, 3000);
  }
</script>

</body>
</html>
