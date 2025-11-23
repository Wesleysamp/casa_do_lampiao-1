<?php 
session_name('lampiao');
session_start();
session_destroy();
header('location:../index_inicio.php');
exit;
?>