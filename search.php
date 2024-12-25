<?php
// Sambungkan ke database
$connection = new mysqli("localhost", "root", "", "db_artiva");

// Tangkap query dari form
$query = $_GET['query'] ?? '';

// SQL untuk mencari data
$sql = "SELECT * FROM artworks WHERE title LIKE '%$query%' OR artist LIKE '%$query%'";
$result = $connection->query($sql);

// Tampilkan hasil pencarian
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<img src='assets/" . $row['image'] . "' alt='" . $row['title'] . "'>";
        echo "<p>" . $row['title'] . " oleh " . $row['artist'] . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>Hasil tidak ditemukan!</p>";
}
?>
