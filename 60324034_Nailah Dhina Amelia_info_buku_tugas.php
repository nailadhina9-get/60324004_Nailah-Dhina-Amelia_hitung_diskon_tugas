<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Informasi Buku</h1>

        <?php
        // Data semua buku
        $buku = [
            [
                "judul" => "Pemrograman Web dengan PHP",
                "pengarang" => "Budi Raharjo",
                "penerbit" => "Informatika",
                "tahun_terbit" => 2023,
                "harga" => 85000,
                "stok" => 15,
                "isbn" => "978-602-1234-56-7",
                "kategori" => "Programming",
                "bahasa" => "Indonesia",
                "halaman" => 320,
                "berat" => 500,
            ],
            [
                "judul" => "Dasar-dasar Database",
                "pengarang" => "Budiono Setyawan",
                "penerbit" => "Terbit Media",
                "tahun_terbit" => 2022,
                "harga" => 85000,
                "stok" => 20,
                "isbn" => "978-602-1111-22-3",
                "kategori" => "Database",
                "bahasa" => "Indonesia",
                "halaman" => 280,
                "berat" => 459,
            ],  
            [
                "judul" => "Web Design Fundamental",
                "pengarang" => "John Smith",
                "penerbit" => "TechPress",
                "tahun_terbit" => 2021,
                "harga" => 99000,
                "stok" => 19,
                "isbn" => "978-602-9999-21-7",
                "kategori" => "Web Design",
                "bahasa" => "Inggris",
                "halaman" => 360,
                "berat" => 550,
            ],
            [
                "judul" => "Advanced PHP Programming",
                "pengarang" => "Michael Redy",
                "penerbit" => "Code Publisher",
                "tahun_terbit" => 2024,
                "harga" => 125000,
                "stok" => 6,
                "isbn" => "978-602-7777-24-1",
                "kategori" => "Programming",
                "bahasa" => "Inggris",
                "halaman" => 500,
                "berat" => 700,
            ]
        ];

        //Fungsi warna badge
        function badgeWarna($kategori) {
            if ($kategori == "Programming") return "primary";
            if ($kategori== "Database") return "success";
            if ($kategori== "Web Design") return "warning";
            return "secondary";
        }
        ?>

        <div class="row">
            <?php foreach ($buku as $b) { ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"><?php echo $b['judul']; ?></h5>
                        </div>
                        <div class="card-body">
                            <span class="badge bg-<?php echo badgeWarna($b['kategori']); ?>">
                                <?php echo $b['kategori']; ?>
                            </span> 

                            <table class="table table-borderless mt-2">
                                <tr>
                                    <th width="200">Pengarang</th>
                                    <td>: <?php echo $b['pengarang']; ?></td>
                                </tr>
                                <tr>
                                    <th>Penerbit</th>
                                    <td>: <?php echo $b['penerbit']; ?></td>
                                </tr>
                                <tr>
                                    <th>Tahun Terbit</th>
                                    <td>: <?php echo $b['tahun_terbit']; ?></td>
                                </tr>
                                <tr>
                                    <th>ISBN</th>
                                    <td>: <?php echo $b['isbn']; ?></td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    <td>: Rp <?php echo number_format($b['harga'], 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td>: <?php echo $b['stok']; ?> buku</td>
                                </tr>
                                <tr>
                                    <th>Bahasa</th>
                                    <td>: <?php echo $b['bahasa']; ?></td>
                                </tr>
                                <tr>
                                    <th>Jumlah Halaman</th>
                                    <td>: <?php echo $b['halaman']; ?> halaman</td>
                                </tr>
                                <tr>
                                    <th>Berat</th>
                                    <td>: <?php echo $b['berat']; ?> gram</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>