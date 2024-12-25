<?php
// Konfigurasi koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'db_artiva';

$connection = new mysqli($host, $user, $password, $dbname);

// Mengecek apakah koneksi berhasil
if ($connection->connect_error) {
    die("Koneksi gagal: " . $connection->connect_error);
}

// Query untuk mengambil semua data dari tabel seniman
$query = "SELECT * FROM seniman";
$result = $connection->query($query);

// Mengecek apakah query berhasil dijalankan
if ($result->num_rows > 0) {
    $seniman = array();

    // Mengambil semua data seniman dalam bentuk array
    while ($row = $result->fetch_assoc()) {
        $seniman[] = $row;
    }

    // Mengirimkan data sebagai JSON
    echo json_encode($seniman);
} else {
    echo json_encode(array("message" => "Tidak ada data"));
}

// Menutup koneksi
$connection->close();
?>
