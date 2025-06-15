<?php
session_start();
include 'db.php';

// Cek apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi dasar (boleh dikembangin lagi)
    if (empty($username) || empty($password) || empty($nama_lengkap) || empty($email)) {
        $error = "Semua field wajib diisi!";
    } else {
        // Cek apakah username sudah ada
        $queryCek = "SELECT * FROM users WHERE username = '$username'";
        $resultCek = mysqli_query($conn, $queryCek);

        if (mysqli_num_rows($resultCek) > 0) {
            $error = "Username sudah digunakan, coba yang lain.";
        } else {
            // Hash password-nya
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert data ke database, role otomatis 'pasien'
            $queryInsert = "INSERT INTO users (username, password, role, nama_lengkap, email)
                            VALUES ('$username', '$hashed_password', 'pasien', '$nama_lengkap', '$email')";

            if (mysqli_query($conn, $queryInsert)) {
                // Registrasi sukses
                echo "<p style='color:green;'>Registrasi berhasil! Silakan login.</p>";
            } else {
                $error = "Gagal registrasi: " . mysqli_error($conn);
            }
        }
    }
}

if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>
