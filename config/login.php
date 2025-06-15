<?php
session_start();
include 'db.php';

// Cek apakah form login udah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    echo "Username dapet: " . $username . "<br>";
    echo "Password dapet: " . $password . "<br>";


    // Ambil data user dari DB
    $query = "SELECT * FROM users WHERE username = '$username'";

        echo "Query: " . $query . "<br>";

    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error SQL: " . mysqli_error($conn));
    }

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        echo "Password di DB: ".$user['password']."<br>";
        echo "Password inputan: ".$password."<br>";
        

        // Cek password
        if (password_verify($password, $user['password'])) {
            // Login sukses, buat session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            

            // Redirect ke halaman sesuai role
            if ($user['role'] == 'admin') {
                header("Location: ../index.html");
            } elseif ($user['role'] == 'dokter') {
                header("Location: dokter_dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit();
        } else {
            $error = "Password salah!";
        }
        
    } else {
        $error = "Username tidak ditemukan oi!";
    }

    
    
}

if(isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>