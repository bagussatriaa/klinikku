<?php
$koneksi = new mysqli("localhost", "root", "", "klinik");

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  $stmt = $koneksi->prepare("DELETE FROM ruangan WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
}

header("Location: ruangan.php");
exit;
