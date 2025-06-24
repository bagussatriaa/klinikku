<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['username'])) {
  header("Location: ../auth/loginn.php");
  exit();
}

// Ambil daftar dokter
$query = "
  SELECT d.id, d.nama, s.nama_spesialis
  FROM dokter d
  JOIN spesialis s ON d.spesialis_id = s.id
  ORDER BY d.id ASC
";
$dokter = $conn->query($query);

// Ambil ruangan yang sudah dipesan hari ini
$tanggal_hari_ini = date('Y-m-d');
$ruangan_dipakai = [];
$res = $conn->query("SELECT ruangan FROM booking_konsultasi WHERE tanggal = '$tanggal_hari_ini' AND status = 'Menunggu'");
while ($row = $res->fetch_assoc()) {
  $ruangan_dipakai[] = $row['ruangan'];
}

// Proses booking
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = $_POST['nama_pasien'];
  $dokter_id = $_POST['dokter_id'];
  $tanggal = $_POST['tanggal'];
  $waktu = $_POST['waktu'];
  $ruangan = $_POST['ruangan'];

  $stmt = $conn->prepare("INSERT INTO booking_konsultasi (nama_pasien, dokter_id, tanggal, waktu, ruangan, status) VALUES (?, ?, ?, ?, ?, 'Menunggu')");
  $stmt->bind_param("sisss", $nama, $dokter_id, $tanggal, $waktu, $ruangan);
  $stmt->execute();

  header("Location: booking_konsultasi.php?berhasil=1");
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Booking Konsultasi - Klinik-ku</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .navbar-brand {
      font-size: 28px;
      font-weight: 700;
      color: #124265 !important;
    }
    .form-booking {
      background: #fff;
      padding: 35px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    h2 {
      font-weight: 600;
      color: #124265;
    }
    label {
      font-weight: 600;
      margin-bottom: 5px;
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
    .btn-primary {
      background-color: #124265;
      border-color: #124265;
      font-weight: 600;
    }
    .btn-primary:hover {
      background-color: #0d3552;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="../index.php">Klinik-ku</a>
  </div>
</nav>

<!-- Notifikasi -->
<div id="notif">Booking berhasil dikirim!</div>

<div class="container mt-5">
  <h2 class="mb-4 text-center">Form Booking Konsultasi</h2>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <form method="POST" class="form-booking">
        <div class="mb-3">
          <label>Nama Pasien</label>
          <input type="text" name="nama_pasien" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Nama Dokter</label>
          <select name="dokter_id" class="form-control" required>
            <option value="">-- Pilih Dokter --</option>
            <?php while($d = $dokter->fetch_assoc()): ?>
              <option value="<?= $d['id'] ?>">Dr. <?= htmlspecialchars($d['nama']) ?> - <?= $d['nama_spesialis'] ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="mb-3">
          <label>Tanggal</label>
          <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Waktu</label>
          <input type="time" name="waktu" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Ruangan</label>
          <select name="ruangan" class="form-control" required>
            <option value="">-- Pilih Ruangan --</option>
            <?php
              for ($i = 1; $i <= 10; $i++) {
                $ruang = "Ruangan $i";
                $disabled = in_array($ruang, $ruangan_dipakai) ? 'disabled' : '';
                echo "<option value='$ruang' $disabled>$ruang" . ($disabled ? " (Sudah Dipesan)" : "") . "</option>";
              }
            ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Kirim Booking</button>
      </form>
    </div>
  </div>
</div>

<script>
  const notif = document.getElementById('notif');
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('berhasil') === '1') {
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
