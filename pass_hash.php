<?php 
$pass_hash = password_hash("admin@library.com", PASSWORD_BCRYPT);
echo $pass_hash;

?>