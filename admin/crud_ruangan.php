<?php

session_start();
include '../config/db.php';

if (!isset($_SESSION['username'])) {
  header("Location: ../auth/loginn.php");
  exit();
}


// Ambil referensi daftar ruang (untuk dropdown)
$daftarRuang = $conn->query("SELECT id, nama FROM daftar_ruang ORDER BY id ASC");

// Tambah data
if (isset($_POST['tambah'])) {
  $id_nama_ruang = intval($_POST['id_nama_ruang']);
  $status = $_POST['status'];
  $keterangan = "";

   $stmt = $conn->prepare("INSERT INTO ruangan (id_nama_ruang, status, keterangan) VALUES (?, ?, ?)");
  $stmt->bind_param("iss", $id_nama_ruang, $status, $keterangan);
  $stmt->execute();

  // if (!$conn->query($query)) {
  //   die("Gagal insert: " . $conn->error);
  // }
  $stmt->close(); 
  header("Location: crud_ruangan.php");
  exit();
}

// Hapus data
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  

  if ($id <= 0) {
  die("ID tidak valid: $id");
}

  // Cek dulu data ini ada gak
  $cek = $conn->query("SELECT * FROM ruangan WHERE id = $id");
  if ($cek->num_rows == 0) {
    die("Data dengan ID itu gak ada bre!");
  }

  // Hapus sekarang
  $query = "DELETE FROM ruangan WHERE id = $id";
  if (!$conn->query($query)) {
    die("Gagal hapus: " . $conn->error);
  }

  header("Location: crud_ruangan.php");
  exit();
}


// Edit data
if (isset($_POST['edit'])) {
  $id = intval($_POST['id']);
  $id_nama_ruang = intval($_POST['id_nama_ruang']);
  $status = $_POST['status'];
  $keterangan = trim($_POST['keterangan']);

  $query = "UPDATE ruangan 
            SET id_nama_ruang = $id_nama_ruang, 
                status = '$status',
                keterangan = '$keterangan'
            WHERE id = $id";

  if (!$conn->query($query)) {
    die("Gagal update: " . $conn->error);
  }

  header("Location: crud_ruangan.php");
  exit();
}


// Ambil data ruangan aktif
$ruangan = $conn->query("
  SELECT 
    r.id AS id_ruangan, 
    dr.nama, 
    r.status 
  FROM ruangan r 
  JOIN daftar_ruang dr ON r.id_nama_ruang = dr.id
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>CRUD Ruangan - Klinikku</title>
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
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">
      <h1>Klinik-ku</h1>
    </a>
  </div>
</nav>

<section class="hero">
  <div class="container">
    <h2>Manajemen Ruangan</h2>
    <p class="text-muted mb-0">Kelola ruangan di Klinik-ku</p>
  </div>
</section>

<div class="container py-4">
  <form method="POST" class="mb-4">
    <div class="row g-3 align-items-center">
      <div class="col-md-5">
        <select name="id_nama_ruang" class="form-select" required>
          <option value="">Pilih Ruangan</option>
          <?php while ($rowRuang = $daftarRuang->fetch_assoc()): ?>
            <option value="<?= $rowRuang['id'] ?>">
              <?= htmlspecialchars($rowRuang['nama']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select name="status" class="form-select" required>
          <option value="Kosong">Kosong</option>
          <option value="Dipakai">Dipakai</option>
          <option value="Maintenance">Maintenance</option>
        </select>
      </div>
      <div class="col-md-3">
        <button type="submit" name="tambah" class="btn btn-primary w-100">Tambah</button>
      </div>
    </div>
  </form>
            
  <div class="row">
    <?php while ($row = $ruangan->fetch_assoc()): ?>
    <div class="col-md-4 mb-4 ruangan-item" data-status="<?= $row['status'] ?>">
      <div class="ruangan-box">
        <h5><?= htmlspecialchars($row['nama']) ?></h5>
        <span class="status <?= $row['status'] ?>"><?= ucfirst($row['status']) ?></span>
        <div class="mt-3">
          <form method="POST" class="d-inline">
            <input type="hidden" name="id" value="<?= $row['id_ruangan'] ?>">
            <input type="hidden" name="nama" value="<?= $row['nama'] ?>">
            <input type="hidden" name="status" value="<?= $row['status'] ?>">
            <button type="submit" name="edit_modal" class="btn btn-warning btn-sm">Edit</button>
          </form>
          <a href="?hapus=<?= $row['id_ruangan'] ?>" onclick="return confirm('Yakin?')" class="btn btn-danger btn-sm">Hapus</a>


        </div>
      </div>
    </div>
  <?php endwhile; ?>
  </div>
</div>

<?php if (isset($_POST['edit_modal'])): ?>
<div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Edit Ruangan</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
          <div class="mb-3">
            <label class="form-label">Nama Ruangan</label>
            <input type="text" name="nama" class="form-control" value="<?= $_POST['nama'] ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
              <option <?= $_POST['status'] == 'Kosong' ? 'selected' : '' ?>>Kosong</option>
              <option <?= $_POST['status'] == 'Dipakai' ? 'selected' : '' ?>>Dipakai</option>
              <option <?= $_POST['status'] == 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
          <a href="crud_ruangan.php" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
