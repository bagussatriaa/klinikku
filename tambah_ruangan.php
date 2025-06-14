<?php
$koneksi = new mysqli("localhost", "root", "", "klinik");
$namaRuang = $koneksi->query("SELECT * FROM daftar_ruang");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_nama_ruang = $_POST['id_nama_ruang'];
  $status = $_POST['status'];
  $keterangan = $_POST['keterangan'];

  $koneksi->query("INSERT INTO ruangan (id_nama_ruang, status, keterangan) VALUES ('$id_nama_ruang', '$status', '$keterangan')");
  header("Location: ruangan.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Ruangan</title>
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
    <h4 class="mb-4 text-center">Tambah Ruangan</h4>
    <form method="POST">
      <div class="form-group">
        <label>Nama Ruangan</label>
        <select name="id_nama_ruang" class="form-control" required>
          <option value="">-- Pilih Ruangan --</option>
          <?php while($r = $namaRuang->fetch_assoc()): ?>
            <option value="<?= $r['id'] ?>"><?= $r['nama'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control" required>
          <option value="">-- Pilih Status --</option>
          <option value="kosong">Kosong</option>
          <option value="dipakai">Dipakai</option>
          <option value="maintenance">Maintenance</option>
        </select>
      </div>

      <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-success btn-block">Simpan</button>
      <a href="ruangan.php" class="btn btn-secondary btn-block">Kembali</a>
    </form>
  </div>

</body>
</html>
