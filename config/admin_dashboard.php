<?php
$plaintext_password = 'hashadmin';
$hash = password_hash($plaintext_password, PASSWORD_DEFAULT);
echo $hash;
?>