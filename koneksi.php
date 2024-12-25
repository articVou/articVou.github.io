<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_artiva";

try {
    // Buat koneksi dengan MySQLi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        throw new Exception("Koneksi gagal: " . $conn->connect_error);
    }

    // Set karakter encoding ke UTF-8
    $conn->set_charset("utf8");
} catch (Exception $e) {
    // Log error untuk debugging
    error_log("[DB Error] " . $e->getMessage(), 3, __DIR__ . '/error.log');
    die("Terjadi kesalahan pada koneksi database. Silakan coba lagi nanti.");
}
?>
