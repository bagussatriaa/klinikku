<?php
session_start();

// Hancurin semua session
session_unset();
session_destroy();

// Redirect balik ke login page (atau ke index.php kalo mau)
header("Location: ../auth/loginn.php?logout=success");
exit();
?>
