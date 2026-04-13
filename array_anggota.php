<?php
// ==== DATA ANGGOTA ====
$anggota_list = [
    [
        "id" => "AGT-001",
        "nama" => "Budi Santoso",
        "email" => "budi@email.com",
        "telepon" => "081234567890",
        "alamat" => "Jakarta",
        "tanggal_daftar" => "2024-01-15",
        "status" => "Aktif",
        "total_pinjaman" => 5
    ],
    [
        "id" => "AGT-002",
        "nama" => "Siti Aminah",
        "email" => "siti@email.com",
        "telepon" => "082345678901",
        "alamat" => "Bandung",
        "tanggal_daftar" => "2024-02-10",
        "status" => "Non-Aktif",
        "total_pinjaman" => 2
    ],
    [
        "id" => "AGT-003",
        "nama" => "Andi Saputra",
        "email" => "andi@email.com",
        "telepon" => "083456789012",
        "alamat" => "Surabaya",
        "tanggal_daftar" => "2024-03-05",
        "status" => "Aktif",
        "total_pinjaman" => 8
    ],
    [
        "id" => "AGT-004",
        "nama" => "Dewi Lestari",
        "email" => "dewi@email.com",
        "telepon" => "084567890123",
        "alamat" => "Yogyakarta",
        "tanggal_daftar" => "2024-01-20",
        "status" => "Aktif",
        "total_pinjaman" => 4
    ],
    [
        "id" => "AGT-005",
        "nama" => "Rudi Hartono",
        "email" => "rudi@email.com",
        "telepon" => "085678901234",
        "alamat" => "Semarang",
        "tanggal_daftar" => "2024-02-25",
        "status" => "Non-Aktif",
        "total_pinjaman" => 1
    ]
];

// ==== PERHITUNGAN ====
$total_anggota = count($anggota_list);

$aktif = 0;
$nonaktif = 0;
$total_pinjaman = 0;
$teraktif = $anggota_list[0];

foreach ($anggota_list as $anggota) {
    if ($anggota['status'] == "Aktif") {
        $aktif++;
    } else {
        $nonaktif++;
    }

    $total_pinjaman += $anggota['total_pinjaman'];

    if ($anggota['total_pinjaman'] > $teraktif['total_pinjaman']) {
        $teraktif = $anggota;
    }
}

$persen_aktif = ($aktif / $total_anggota) * 100;
$persen_nonaktif = ($nonaktif / $total_anggota) * 100;
$rata_pinjaman = $total_pinjaman / $total_anggota;

// FILTER STATUS
$filter_status = $_GET['status'] ?? "Semua";
$filtered_data = [];

foreach ($anggota_list as $anggota) {
    if ($filter_status == "Semua" || $anggota['status'] == $filter_status) {
        $filtered_data[] = $anggota;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Array Anggota Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2 class="mb-4 text-center">Data Anggota Perpustakaan</h2>

    <!-- ==== CARDS ==== -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white p-3">
                <h5>Total Anggota</h5>
                <h3><?= $total_anggota ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white p-3">
                <h5>Aktif (%)</h5>
                <h3><?= number_format($persen_aktif, 1) ?>%</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white p-3">
                <h5>Non-Aktif (%)</h5>
                <h3><?= number_format($persen_nonaktif, 1) ?>%</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-dark p-3">
                <h5>Rata Pinjaman</h5>
                <h3><?= number_format($rata_pinjaman, 1) ?></h3>
            </div>
        </div>
    </div>

    <!-- ==== TERAKTIF ==== -->
    <div class="alert alert-info">
        <strong>Anggota Teraktif:</strong> 
        <?= $teraktif['nama'] ?> (<?= $teraktif['total_pinjaman'] ?> pinjaman)
    </div>

    <!-- ==== FILTER ==== -->
    <form method="GET" class="mb-3">
        <select name="status" class="form-select w-25 d-inline">
            <option value="Semua">Semua</option>
            <option value="Aktif">Aktif</option>
            <option value="Non-Aktif">Non-Aktif</option>
        </select>
        <button class="btn btn-primary">Filter</button>
    </form>

    <!-- ==== TABEL ==== -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Tanggal Daftar</th>
                <th>Status</th>
                <th>Total Pinjaman</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filtered_data as $a): ?>
            <tr>
                <td><?= $a['id'] ?></td>
                <td><?= $a['nama'] ?></td>
                <td><?= $a['email'] ?></td>
                <td><?= $a['telepon'] ?></td>
                <td><?= $a['alamat'] ?></td>
                <td><?= $a['tanggal_daftar'] ?></td>
                <td>
                    <span class="badge bg-<?= $a['status'] == 'Aktif' ? 'success' : 'danger' ?>">
                        <?= $a['status'] ?>
                    </span>
                </td>
                <td><?= $a['total_pinjaman'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>