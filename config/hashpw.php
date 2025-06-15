<?php
$password = 'adminbaru'; // password asli yang mau dipake
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;
?>
