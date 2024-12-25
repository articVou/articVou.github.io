<?php
// Import file koneksi database
require_once 'koneksi.php';

// Ambil data dari request
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode([
        'success' => false,
        'message' => 'Data tidak valid!',
    ]);
    exit;
}

// Ambil data input dari pengguna
$username = $data['username'];
$email = $data['email'];
$password = $data['password'];
$role = $data['role'];

// Validasi data input
if (empty($username) || empty($email) || empty($password) || empty($role)) {
    echo json_encode([
        'success' => false,
        'message' => 'Semua field harus diisi!',
    ]);
    exit;
}

// Hash password menggunakan password_hash untuk keamanan
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    // Query untuk menambahkan data pengguna ke tabel `users`
    $query = "INSERT INTO users (username, password_user, email, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $username, $hashedPassword, $email, $role);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Registrasi berhasil!',
            'role' => $role, // Kirim role untuk pengalihan
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Registrasi gagal. Error: ' . $stmt->error,
        ]);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
    ]);
}

// Tutup koneksi database
$conn->close();
?>
