<?php
$koneksi = new mysqli("localhost", "root", "", "klinik");

$id = $_GET['id'];
$data = $koneksi->query("SELECT * FROM ruangan WHERE id = $id")->fetch_assoc();
$namaRuang = $koneksi->query("SELECT * FROM daftar_ruang");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_nama_ruang = $_POST['id_nama_ruang'];
  $status = $_POST['status'];
  $keterangan = $_POST['keterangan'];

  $koneksi->query("UPDATE ruangan SET id_nama_ruang = '$id_nama_ruang', status = '$status', keterangan = '$keterangan' WHERE id = $id");
  header("Location: ruangan.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Ruangan</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background: #f0f2f5;
      padding: 40px;
    }
    .form-container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h4 class="mb-4 text-center">Edit Ruangan</h4>
    <form method="POST">
      <div class="form-group">
        <label>Nama Ruangan</label>
        <select name="id_nama_ruang" class="form-control" required>
          <option value="">-- Pilih Ruangan --</option>
          <?php while($r = $namaRuang->fetch_assoc()): ?>
            <option value="<?= $r['id'] ?>" <?= $r['id'] == $data['id_nama_ruang'] ? 'selected' : '' ?>>
              <?= $r['nama'] ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control" required>
          <option value="kosong" <?= $data['status'] == 'kosong' ? 'selected' : '' ?>>Kosong</option>
          <option value="dipakai" <?= $data['status'] == 'dipakai' ? 'selected' : '' ?>>Dipakai</option>
          <option value="maintenance" <?= $data['status'] == 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
        </select>
      </div>

      <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control" rows="3"><?= htmlspecialchars($data['keterangan']) ?></textarea>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Update</button>
      <a href="ruangan.php" class="btn btn-secondary btn-block">Batal</a>
    </form>
  </div>

</body>
</html>
