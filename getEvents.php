<?php
header('Content-Type: application/json');

// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'db_artiva';

$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    echo json_encode(['error' => 'Koneksi gagal: ' . $conn->connect_error]);
    exit();
}

// Query untuk mendapatkan data event
$sql = "SELECT id_events, title, description, DATE_FORMAT(event_date, '%d-%m-%Y') AS event_date, status_event, image 
        FROM EVENTS 
        ORDER BY event_date ASC";

// Menjalankan query
$result = $conn->query($sql);

// Menyimpan data event
$events = [];
if ($result->num_rows > 0) {
    // Mengambil hasil query dan memasukkannya ke dalam array
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
} else {
    // Jika tidak ada event ditemukan
    echo json_encode(['success' => false, 'message' => 'Tidak ada event ditemukan.']);
    $conn->close();
    exit();
}

// Kembalikan data dalam format JSON
echo json_encode($events);

// Menutup koneksi
$conn->close();
?>