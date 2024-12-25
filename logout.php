<?php
session_start();
session_destroy(); // Hapus semua data sesi
header("Location: artiva.html"); // Arahkan ke halaman utama
exit();
?>
