<?php
require 'koneksi.php'; // Pastikan koneksi.php sudah sesuai

header('Content-Type: application/json');

// Query untuk mengambil data dari tabel galeri
$sql = "SELECT id_artwork AS id, title, artist, price, discount, image, description FROM galeri
        UNION
        SELECT id_shop AS id, title, artist, harga_akhir AS price, diskon AS discount, image, description FROM shop";

$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Mengembalikan data dalam format JSON
echo json_encode($data);
?>
