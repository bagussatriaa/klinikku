<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
  header("Location: ../auth/loginn.php");
  exit();
}

// Tambah dokter
if (isset($_POST['tambah'])) {
  $nama = trim($_POST['nama']);
  $spesialis_id = intval($_POST['spesialis_id']);
  $conn->query("INSERT INTO dokter (nama, spesialis_id) VALUES ('$nama', $spesialis_id)");
  $_SESSION['success'] = "Dokter berhasil ditambahkan.";
  header("Location: dokter_crud.php");
  exit();
}

// Edit dokter
if (isset($_POST['update'])) {
  $id = intval($_POST['id']);
  $nama = trim($_POST['nama']);
  $spesialis_id = intval($_POST['spesialis_id']);
  $conn->query("UPDATE dokter SET nama = '$nama', spesialis_id = $spesialis_id WHERE id = $id");
  $_SESSION['success'] = "Data dokter berhasil diperbarui.";
  header("Location: dokter_crud.php");
  exit();
}

// Hapus dokter
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  $conn->query("DELETE FROM dokter WHERE id = $id");
  $_SESSION['success'] = "Dokter berhasil dihapus.";
  header("Location: dokter_crud.php");
  exit();
}

// Ambil data untuk form edit
$edit = null;
if (isset($_GET['edit'])) {
  $edit_id = intval($_GET['edit']);
  $edit = $conn->query("SELECT * FROM dokter WHERE id = $edit_id")->fetch_assoc();
}

// Ambil data dokter
$dokter = $conn->query("
  SELECT d.id, d.nama, s.nama_spesialis, s.id AS spesialis_id
  FROM dokter d
  JOIN spesialis s ON d.spesialis_id = s.id
  ORDER BY d.id ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>CRUD Dokter - Klinik-ku</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }
    .navbar {
      background-color: #f8f9fa;
    }
    .navbar-brand {
      font-weight: 700;
      color: #012a4a;
      font-size: 26px;
    }
    h2 {
      font-weight: 700;
      color: #124265;
    }
    .card-header {
      font-weight: 600;
      font-size: 18px;
    }
    .form-control, .form-select {
      font-size: 15px;
    }
    .table thead {
      background-color: #01395e;
      color: white;
    }
    .btn-primary, .btn-warning {
      font-weight: 600;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow-sm fixed-top">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">Klinik-ku</a>
  </div>
</nav>

<!-- Konten -->
<div class="container" style="margin-top: 100px;">
  <h2 class="mb-4 text-center">Manajemen Dokter</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
      <?= $_SESSION['success']; unset($_SESSION['success']); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- Form Tambah / Edit Dokter -->
  <div class="card mb-4">
    <div class="card-header bg-primary text-white">
      <?= $edit ? 'Edit Dokter' : 'Tambah Dokter Baru' ?>
    </div>
    <div class="card-body">
      <form method="post">
        <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
        <div class="row g-2">
          <div class="col-md-6">
            <input type="text" name="nama" class="form-control" placeholder="Nama Dokter" required value="<?= $edit['nama'] ?? '' ?>">
          </div>
          <div class="col-md-4">
            <select name="spesialis_id" class="form-select" required>
              <option value="">-- Pilih Spesialis --</option>
              <?php
                $spesialis = $conn->query("SELECT * FROM spesialis");
                while ($s = $spesialis->fetch_assoc()):
              ?>
                <option value="<?= $s['id'] ?>" <?= isset($edit) && $edit['spesialis_id'] == $s['id'] ? 'selected' : '' ?>>
                  <?= $s['nama_spesialis'] ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" name="<?= $edit ? 'update' : 'tambah' ?>" class="btn btn-<?= $edit ? 'warning' : 'primary' ?> w-100">
              <?= $edit ? 'Update' : 'Tambah' ?>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Tabel Dokter -->
  <div class="card">
    <div class="card-header bg-light">
      <strong>Data Dokter</strong>
    </div>
    <div class="card-body p-0">
      <table class="table table-bordered table-hover m-0">
        <thead class="text-center">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Spesialis</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($dokter->num_rows > 0): $no = 1; ?>
            <?php while ($d = $dokter->fetch_assoc()): ?>
              <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= htmlspecialchars($d['nama']) ?></td>
                <td><?= htmlspecialchars($d['nama_spesialis']) ?></td>
                <td class="text-center">
                  <a href="?edit=<?= $d['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i> Edit</a>
                  <a href="?hapus=<?= $d['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus dokter ini?')"><i class="bi bi-trash"></i> Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="4" class="text-center text-muted">Belum ada data dokter.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>