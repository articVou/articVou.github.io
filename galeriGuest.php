<?php
// Include koneksi database
include('koneksi.php');

// Query untuk mengambil data dari tabel artworks
$query_artworks = "SELECT id_artwork AS id, title, image, description, artist, price AS harga_akhir, discount AS diskon, '' AS kontak, 'artwork' AS jenis_artwork 
FROM artworks";

// Query untuk mengambil data dari tabel shop
$query_shop = "SELECT id_shop AS id, title, image, description, artist, harga_akhir, diskon, kontak, jenis_artwork 
FROM shop";

// Gabungkan kedua query dengan UNION
$query = "$query_artworks UNION $query_shop ORDER BY artist, id DESC";
$result = mysqli_query($conn, $query);

// Periksa jika query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - Artiva</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            padding: 20px;
        }

        .gallery-container div {
            position: relative;
            overflow: hidden;
        }

        .gallery-container img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery-container img:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .info-button {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: none;
            background: rgba(255, 255, 255, 0.8);
            color: #333;
            font-size: 14px;
            padding: 5px 15px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }

        .gallery-container div:hover .info-button {
            display: block;
        }

        .description {
            display: none;
            background-color: white;
            border: 1px solid #04AA6D;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">Artiva</div>
        <div class="menu">
            <a href="index.html">Beranda</a>
            <a href="galeri.html">Galeri</a>
            <a href="event.html">Event</a>
            <a href="about.html">Tentang Artiva</a>
        </div>
        <div class="auth">
            <a href="register.html">Daftar Akun</a>
            <a href="login.html">Masuk</a>
        </div>        
    </div>

    <!-- Galeri Foto -->
    <section class="gallery-container">
        <?php
        // Menampilkan data dari database
        while ($row = mysqli_fetch_assoc($result)) {
            // Mendapatkan nama file gambar
            $imagePath = "imageGaleri/" . $row['image'];
        ?>
            <div>
                <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                <button class="info-button" onclick="toggleDescription(<?php echo $row['id']; ?>)">Selengkapnya</button>
                <div class="description" id="description-<?php echo $row['id']; ?>">
                    <p><strong>Judul:</strong> <?php echo htmlspecialchars($row['title']); ?></p>
                    <p><strong>Seniman:</strong> <?php echo htmlspecialchars($row['artist']); ?></p>
                    <p><strong>Harga:</strong> Rp<?php echo number_format($row['harga_akhir'], 0, ',', '.'); ?></p>
                    <p><strong>Diskon:</strong> <?php echo htmlspecialchars($row['diskon']); ?>%</p>
                    <?php if (!empty($row['kontak'])) { ?>
                        <p><strong>Kontak:</strong> <?php echo htmlspecialchars($row['kontak']); ?></p>
                    <?php } ?>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                </div>
            </div>
        <?php
        }
        ?>
    </section>

    <script>
        function toggleDescription(id) {
            const description = document.getElementById('description-' + id);
            if (description.style.display === 'none' || description.style.display === '') {
                description.style.display = 'block';
            } else {
                description.style.display = 'none';
            }
        }
    </script>
</body>
</html>
