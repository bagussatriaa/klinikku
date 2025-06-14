<?php
$koneksi = new mysqli("localhost", "root", "", "klinik");

// Proses filter pencarian
$where = [];
if (!empty($_GET['cari'])) {
  $cari = $koneksi->real_escape_string($_GET['cari']);
  $where[] = "daftar_ruang.nama LIKE '%$cari%'";
}
if (!empty($_GET['status'])) {
  $status = $koneksi->real_escape_string($_GET['status']);
  $where[] = "ruangan.status = '$status'";
}

$sql = "SELECT ruangan.*, daftar_ruang.nama AS nama_ruangan 
        FROM ruangan 
        JOIN daftar_ruang ON ruangan.id_nama_ruang = daftar_ruang.id";
if (!empty($where)) {
  $sql .= " WHERE " . implode(" AND ", $where);
}
$data = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Ruangan Klinik</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background: #f4f6f9;
      padding: 20px;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .btn {
      border-radius: 20px;
    }
    .status-kosong { color: green; font-weight: bold; }
    .status-dipakai { color: red; font-weight: bold; }
    .status-maintenance { color: orange; font-weight: bold; }
  </style>
</head>
<body>

  <div class="container">
    <div class="card p-4">
      <h3 class="mb-4 text-center">Daftar Ruangan Klinik</h3>

      <div class="mb-3 d-flex flex-column flex-md-row justify-content-between">
        <form class="form-inline mb-2 mb-md-0" method="GET">
          <input type="text" name="cari" class="form-control mr-2 mb-2 mb-md-0" placeholder="Cari nama ruangan..." value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
          <select name="status" class="form-control mr-2 mb-2 mb-md-0">
            <option value="">-- Semua Status --</option>
            <option value="kosong" <?= (isset($_GET['status']) && $_GET['status'] == 'kosong') ? 'selected' : '' ?>>Kosong</option>
            <option value="dipakai" <?= (isset($_GET['status']) && $_GET['status'] == 'dipakai') ? 'selected' : '' ?>>Dipakai</option>
            <option value="maintenance" <?= (isset($_GET['status']) && $_GET['status'] == 'maintenance') ? 'selected' : '' ?>>Maintenance</option>
          </select>
          <button class="btn btn-primary" type="submit">Filter</button>
        </form>
        <a href="tambah_ruangan.php" class="btn btn-success">+ Tambah Ruangan</a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="thead-light">
            <tr>
              <th>No</th>
              <th>Nama Ruangan</th>
              <th>Status</th>
              <th>Keterangan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($data->num_rows > 0): ?>
              <?php $no = 1; while($r = $data->fetch_assoc()): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($r['nama_ruangan']) ?></td>
                <td class="status-<?= $r['status'] ?>">
                  <?= ucfirst($r['status']) ?>
                </td>
                <td><?= htmlspecialchars($r['keterangan']) ?></td>
                <td>
                  <a href="edit_ruangan.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="hapus_ruangan.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus ruangan ini?')">Hapus</a>
                </td>
              </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center">Tidak ada data ruangan ditemukan.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>
</html>
