<?php
session_start();
require_once 'koneksi.php';

// Periksa apakah pengguna telah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Pengguna tidak login.']);
    exit;
}

// Ambil user_id dari sesi
$user_id = $_SESSION['user_id'];

// Query untuk mendapatkan nama pengguna
$sql = "SELECT username FROM users WHERE id_users = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Periksa apakah pengguna ditemukan
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode(['success' => true, 'username' => $user['username']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Pengguna tidak ditemukan.']);
}

$stmt->close();
$conn->close();
?>
