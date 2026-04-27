<?php
// Inisialisasi variabel
$errors = [];
$success = false;

// Ambil data lama (biar form keep value)
$nama = $_POST['nama'] ?? '';
$email = $_POST['email'] ?? '';
$telepon = $_POST['telepon'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$jk = $_POST['jk'] ?? '';
$tgl_lahir = $_POST['tgl_lahir'] ?? '';
$pekerjaan = $_POST['pekerjaan'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // VALIDASI NAMA
    if (empty($nama)) {
        $errors['nama'] = "Nama wajib diisi";
    } elseif (strlen($nama) < 3) {
        $errors['nama'] = "Nama minimal 3 karakter";
    }

    // VALIDASI EMAIL
    if (empty($email)) {
        $errors['email'] = "Email wajib diisi";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format email tidak valid";
    }

    // VALIDASI TELEPON
    if (empty($telepon)) {
        $errors['telepon'] = "Telepon wajib diisi";
    } elseif (!preg_match('/^08[0-9]{8,11}$/', $telepon)) {
        $errors['telepon'] = "Format telepon harus 08xxxxxxxxxx (10-13 digit)";
    }

    // VALIDASI ALAMAT
    if (empty($alamat)) {
        $errors['alamat'] = "Alamat wajib diisi";
    } elseif (strlen($alamat) < 10) {
        $errors['alamat'] = "Alamat minimal 10 karakter";
    }

    // VALIDASI JENIS KELAMIN
    if (empty($jk)) {
        $errors['jk'] = "Pilih jenis kelamin";
    }

    // VALIDASI TANGGAL LAHIR
    if (empty($tgl_lahir)) {
        $errors['tgl_lahir'] = "Tanggal lahir wajib diisi";
    } else {
        $today = new DateTime();
        $birth = new DateTime($tgl_lahir);
        $age = $today->diff($birth)->y;

        if ($age < 10) {
            $errors['tgl_lahir'] = "Umur minimal 10 tahun";
        }
    }

    // VALIDASI PEKERJAAN
    if (empty($pekerjaan)) {
        $errors['pekerjaan'] = "Pilih pekerjaan";
    }

    // Jika tidak ada error
    if (empty($errors)) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Registrasi Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h3 class="mb-4">Form Registrasi Anggota</h3>

        <form method="POST">

            <!-- NAMA -->
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($nama) ?>">
                <div class="invalid-feedback"><?= $errors['nama'] ?? '' ?></div>
            </div>

            <!-- EMAIL -->
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($email) ?>">
                <div class="invalid-feedback"><?= $errors['email'] ?? '' ?></div>
            </div>

            <!-- TELEPON -->
            <div class="mb-3">
                <label class="form-label">Telepon</label>
                <input type="text" name="telepon" class="form-control <?= isset($errors['telepon']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($telepon) ?>">
                <div class="invalid-feedback"><?= $errors['telepon'] ?? '' ?></div>
            </div>

            <!-- ALAMAT -->
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>"><?= htmlspecialchars($alamat) ?></textarea>
                <div class="invalid-feedback"><?= $errors['alamat'] ?? '' ?></div>
            </div>

            <!-- JENIS KELAMIN -->
            <div class="mb-3">
                <label class="form-label d-block">Jenis Kelamin</label>
                <input type="radio" name="jk" value="Laki-laki" <?= $jk == 'Laki-laki' ? 'checked' : '' ?>> Laki-laki
                <input type="radio" name="jk" value="Perempuan" <?= $jk == 'Perempuan' ? 'checked' : '' ?>> Perempuan
                <div class="text-danger"><?= $errors['jk'] ?? '' ?></div>
            </div>

            <!-- TANGGAL LAHIR -->
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control <?= isset($errors['tgl_lahir']) ? 'is-invalid' : '' ?>" value="<?= $tgl_lahir ?>">
                <div class="invalid-feedback"><?= $errors['tgl_lahir'] ?? '' ?></div>
            </div>

            <!-- PEKERJAAN -->
            <div class="mb-3">
                <label class="form-label">Pekerjaan</label>
                <select name="pekerjaan" class="form-control <?= isset($errors['pekerjaan']) ? 'is-invalid' : '' ?>">
                    <option value="">-- Pilih --</option>
                    <option value="Pelajar" <?= $pekerjaan == 'Pelajar' ? 'selected' : '' ?>>Pelajar</option>
                    <option value="Mahasiswa" <?= $pekerjaan == 'Mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
                    <option value="Pegawai" <?= $pekerjaan == 'Pegawai' ? 'selected' : '' ?>>Pegawai</option>
                    <option value="Lainnya" <?= $pekerjaan == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                </select>
                <div class="invalid-feedback"><?= $errors['pekerjaan'] ?? '' ?></div>
            </div>

            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
    </div>

    <?php if ($success): ?>
        <div class="card mt-4 p-4 shadow bg-success text-white">
            <h4>Registrasi Berhasil!</h4>
            <p><strong>Nama:</strong> <?= htmlspecialchars($nama) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
            <p><strong>Telepon:</strong> <?= htmlspecialchars($telepon) ?></p>
            <p><strong>Alamat:</strong> <?= htmlspecialchars($alamat) ?></p>
            <p><strong>Jenis Kelamin:</strong> <?= $jk ?></p>
            <p><strong>Tanggal Lahir:</strong> <?= $tgl_lahir ?></p>
            <p><strong>Pekerjaan:</strong> <?= $pekerjaan ?></p>
        </div>
    <?php endif; ?>

</div>

</body>
</html>