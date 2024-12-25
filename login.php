<?php
require_once 'koneksi.php'; // Memuat file koneksi database

// Ambil data JSON dari permintaan
$data = json_decode(file_get_contents('php://input'), true);

// Validasi data input
if (!$data || empty($data['email']) || empty($data['password'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Email dan Password harus diisi!',
    ]);
    exit;
}

// Bersihkan dan ambil data
$email = trim($data['email']);
$password = trim($data['password']);

try {
    // Query untuk mencari user berdasarkan email
    $query = "SELECT id_users, password_user, role, username FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Debugging log
        error_log("User ditemukan: " . json_encode($user));

        // Verifikasi password
        if (password_verify($password, $user['password_user'])) {
            echo json_encode([
                'success' => true,
                'message' => 'Login berhasil! Selamat datang, ' . $user['username'] . '.',
                'role' => $user['role'],
                'user_id' => $user['id_users'],
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Password salah!',
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Email tidak ditemukan!',
        ]);
    }

    $stmt->close();
} catch (Exception $e) {
    // Log error untuk debugging
    error_log("Error: " . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan pada server: ' . htmlspecialchars($e->getMessage()),
    ]);
}

$conn->close();
?>
