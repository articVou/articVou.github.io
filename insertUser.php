<?php
require_once 'koneksi.php';

$passwords = [
    ['FaishalAgam', 'agam.faishal@gmail.com', '12341234', 'user'],
    ['FaishalAgam', 'agam.faishal1@gmail.com', '12341234', 'editor'],
    ['FaishalAgam', 'agam.faishal2@gmail.com', '12341234', 'admin'],
    ['BintangFadillah', 'bintang.fadillah@gmail.com', '12341234', 'admin'],
    ['ArinFronika', 'arin.fronika@gmail.com', '12341234', 'admin'],
    ['AqnaNajah', 'aqna.najah@gmail.com', '12341234', 'admin'],
    ['NovitaDea', 'novita.dea@gmail.com', '12341234', 'admin']
];

foreach ($passwords as $user) {
    $hashedPassword = password_hash($user[2], PASSWORD_DEFAULT); // Enkripsi password
    $stmt = $conn->prepare("INSERT INTO users (username, email, password_user, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $user[0], $user[1], $hashedPassword, $user[3]);

    if ($stmt->execute()) {
        echo "User {$user[0]} berhasil ditambahkan.<br>";
    } else {
        echo "Error menambahkan user {$user[0]}: " . $stmt->error . "<br>";
    }
}

$stmt->close();
$conn->close();
?>
