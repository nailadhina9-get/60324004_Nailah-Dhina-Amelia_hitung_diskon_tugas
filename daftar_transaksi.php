<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Daftar Transaksi Peminjaman</h1>

    <?php
    $total_transaksi = 0;
    $total_dipinjam = 0;
    $total_dikembalikan = 0;

    // LOOP 1: Hitung statistik
    for ($i = 1; $i <= 10; $i++) {

        if ($i % 2 == 0) continue; // skip genap
        if ($i == 8) break; // stop di 8

        $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";

        $total_transaksi++;

        if ($status == "Dipinjam") {
            $total_dipinjam++;
        } else {
            $total_dikembalikan++;
        }
    }
    ?>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white p-3">
                <h5>Total Transaksi</h5>
                <h3><?= $total_transaksi ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark p-3">
                <h5>Masih Dipinjam</h5>
                <h3><?= $total_dipinjam ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white p-3">
                <h5>Sudah Dikembalikan</h5>
                <h3><?= $total_dikembalikan ?></h3>
            </div>
        </div>
    </div>

    <!-- Tabel -->
    <table class="table table-bordered">
        <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>ID Transaksi</th>
            <th>Peminjam</th>
            <th>Buku</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Hari</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // LOOP 2: Tampilkan data
        for ($i = 1; $i <= 10; $i++) {

            if ($i % 2 == 0) continue;
            if ($i == 8) break;

            $id = "TRX-" . str_pad($i, 4, "0", STR_PAD_LEFT);
            $nama = "Anggota " . $i;
            $buku = "Buku Teknologi Vol. " . $i;

            $tgl_pinjam = date("Y-m-d", strtotime("-$i days"));
            $tgl_kembali = date("Y-m-d", strtotime("+7 days", strtotime($tgl_pinjam)));

            $status = ($i % 3 == 0) ? "Dikembalikan" : "Dipinjam";

            // ✅ FIX: hitung hari tanpa koma
            $hari = floor((strtotime(date("Y-m-d")) - strtotime($tgl_pinjam)) / 86400);

            // badge warna
            if ($status == "Dipinjam") {
                $badge = "<span class='badge bg-warning'>Dipinjam</span>";
            } else {
                $badge = "<span class='badge bg-success'>Dikembalikan</span>";
            }

            echo "<tr>
                    <td>$i</td>
                    <td>$id</td>
                    <td>$nama</td>
                    <td>$buku</td>
                    <td>$tgl_pinjam</td>
                    <td>$tgl_kembali</td>
                    <td>$hari hari</td>
                    <td>$badge</td>
                  </tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>