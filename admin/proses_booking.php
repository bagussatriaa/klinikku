<?php
session_start();
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama_pasien = $conn->real_escape_string($_POST['nama_pasien']);
  $dokter_id = intval($_POST['dokter_id']);
  $tanggal = $conn->real_escape_string($_POST['tanggal']);
  $waktu = $conn->real_escape_string($_POST['waktu']);
  $ruangan = $conn->real_escape_string($_POST['ruangan']);

  // Simpan ke database
  $sql = "INSERT INTO booking_konsultasi (nama_pasien, dokter_id, tanggal, waktu, ruangan)
          VALUES ('$nama_pasien', $dokter_id, '$tanggal', '$waktu', '$ruangan')";

  if ($conn->query($sql)) {
    header("Location: ../booking/booking_konsultasi.php?status=sukses");
    exit();
  } else {
    echo "Error: " . $conn->error;
  }
}
?>
