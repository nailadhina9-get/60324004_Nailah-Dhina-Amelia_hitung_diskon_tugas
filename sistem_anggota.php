<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>

<?php
require_once 'functions_anggota.php';

// DATA ANGGOTA
$anggota_list = [
    ["id"=>1,"nama"=>"Santoso","email"=>"santoso@gmail.com","status"=>"Aktif","total_pinjaman"=>5,"tanggal_daftar"=>"2025-01-10"],
    ["id"=>2,"nama"=>"Sigit","email"=>"sigit@gmail.com","status"=>"Non-Aktif","total_pinjaman"=>2,"tanggal_daftar"=>"2025-07-15"],
    ["id"=>3,"nama"=>"Tin","email"=>"tin@gmail.com","status"=>"Aktif","total_pinjaman"=>8,"tanggal_daftar"=>"2025-03-20"],
    ["id"=>4,"nama"=>"Murni","email"=>"murni@gmail.com","status"=>"Aktif","total_pinjaman"=>3,"tanggal_daftar"=>"2025-04-09"],
    ["id"=>5,"nama"=>"Rafi","email"=>"rafi@gmail.com","status"=>"Non-Aktif","total_pinjaman"=>1,"tanggal_daftar"=>"2025-02-12"],
];

// STATISTIK
$total = hitung_total_anggota($anggota_list);
$aktif = hitung_anggota_aktif($anggota_list);
$nonaktif = $total - $aktif;
$rata = hitung_rata_rata_pinjaman($anggota_list);
$teraktif = cari_anggota_teraktif($anggota_list);
?>

<div class="container mt-5">
    <h1 class="mb-4"><i class="bi bi-people"></i> Sistem Anggota</h1>

    <!-- STATISTIK -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <h5>Total</h5>
                    <h3><?= $total ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5>Aktif</h5>
                    <h3><?= $aktif ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-danger">
                <div class="card-body">
                    <h5>Non-Aktif</h5>
                    <h3><?= $nonaktif ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <h5>Rata Pinjaman</h5>
                    <h3><?= number_format($rata,1) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Daftar Anggota
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th><th>Nama</th><th>Email</th><th>Status</th><th>Pinjaman</th><th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($anggota_list as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= $a['nama'] ?></td>
                        <td><?= $a['email'] ?></td>
                        <td><?= $a['status'] ?></td>
                        <td><?= $a['total_pinjaman'] ?></td>
                        <td><?= format_tanggal_indo($a['tanggal_daftar']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- TERAKTIF -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            Anggota Teraktif
        </div>
        <div class="card-body">
            <h5><?= $teraktif['nama'] ?></h5>
            <p>Total Pinjaman: <?= $teraktif['total_pinjaman'] ?></p>
        </div>
    </div>

    <!-- LIST AKTIF & NON -->
    <div class="row">
        <div class="col-md-6">
            <h5>Anggota Aktif</h5>
            <ul class="list-group">
                <?php foreach (filter_by_status($anggota_list,"Aktif") as $a): ?>
                    <li class="list-group-item"><?= $a['nama'] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="col-md-6">
            <h5>Non-Aktif</h5>
            <ul class="list-group">
                <?php foreach (filter_by_status($anggota_list,"Non-Aktif") as $a): ?>
                    <li class="list-group-item"><?= $a['nama'] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

</div>

</body>
</html>