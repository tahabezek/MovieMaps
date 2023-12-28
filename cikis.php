<?php
// Oturumu başlat
session_start();

// Oturumu sonlandır
session_destroy();

// Giriş sayfasına yönlendir
header("Location: anasayfa.php");
exit;
?>
