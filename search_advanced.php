<?php
session_start();

// ================= DATA BUKU =================
$buku_list = [
    ["kode"=>"B001","judul"=>"Algoritma Dasar","kategori"=>"Teknologi","pengarang"=>"Andi","penerbit"=>"Informatika","tahun"=>2020,"harga"=>75000,"stok"=>5],
    ["kode"=>"B002","judul"=>"Pemrograman PHP","kategori"=>"Teknologi","pengarang"=>"Budi","penerbit"=>"Elex","tahun"=>2021,"harga"=>85000,"stok"=>0],
    ["kode"=>"B003","judul"=>"Basis Data","kategori"=>"Teknologi","pengarang"=>"Citra","penerbit"=>"Gramedia","tahun"=>2019,"harga"=>90000,"stok"=>3],
    ["kode"=>"B004","judul"=>"Matematika Diskrit","kategori"=>"Pendidikan","pengarang"=>"Dedi","penerbit"=>"Andi","tahun"=>2018,"harga"=>65000,"stok"=>7],
    ["kode"=>"B005","judul"=>"Statistika","kategori"=>"Pendidikan","pengarang"=>"Eka","penerbit"=>"Erlangga","tahun"=>2022,"harga"=>70000,"stok"=>2],
    ["kode"=>"B006","judul"=>"Fisika Dasar","kategori"=>"Sains","pengarang"=>"Fajar","penerbit"=>"Gramedia","tahun"=>2017,"harga"=>60000,"stok"=>0],
    ["kode"=>"B007","judul"=>"Kimia Organik","kategori"=>"Sains","pengarang"=>"Gina","penerbit"=>"Erlangga","tahun"=>2023,"harga"=>95000,"stok"=>4],
    ["kode"=>"B008","judul"=>"Biologi","kategori"=>"Sains","pengarang"=>"Hadi","penerbit"=>"Andi","tahun"=>2016,"harga"=>55000,"stok"=>6],
    ["kode"=>"B009","judul"=>"Manajemen","kategori"=>"Ekonomi","pengarang"=>"Indah","penerbit"=>"Salemba","tahun"=>2020,"harga"=>88000,"stok"=>1],
    ["kode"=>"B010","judul"=>"Akuntansi","kategori"=>"Ekonomi","pengarang"=>"Joko","penerbit"=>"Salemba","tahun"=>2021,"harga"=>92000,"stok"=>0],
];

// ================= GET =================
$keyword = $_GET['keyword'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$min_harga = $_GET['min_harga'] ?? '';
$max_harga = $_GET['max_harga'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$status = $_GET['status'] ?? 'semua';
$sort = $_GET['sort'] ?? 'judul';
$page = $_GET['page'] ?? 1;

// ================= VALIDASI =================
$errors = [];

if (!empty($min_harga) && !empty($max_harga)) {
    if ($min_harga > $max_harga) {
        $errors[] = "Harga minimum tidak boleh lebih besar dari harga maksimum";
    }
}

if (!empty($tahun) && ($tahun < 1900 || $tahun > date("Y"))) {
    $errors[] = "Tahun tidak valid";
}

// ================= FILTER =================
$hasil = array_filter($buku_list, function($buku) use ($keyword,$kategori,$min_harga,$max_harga,$tahun,$status){

    if ($keyword && stripos($buku['judul'],$keyword) === false && stripos($buku['pengarang'],$keyword) === false) return false;

    if ($kategori && $buku['kategori'] != $kategori) return false;

    if ($min_harga && $buku['harga'] < $min_harga) return false;
    if ($max_harga && $buku['harga'] > $max_harga) return false;

    if ($tahun && $buku['tahun'] != $tahun) return false;

    if ($status == "tersedia" && $buku['stok'] <= 0) return false;
    if ($status == "habis" && $buku['stok'] > 0) return false;

    return true;
});

// ================= SORT =================
usort($hasil, function($a,$b) use ($sort){
    return $a[$sort] <=> $b[$sort];
});

// ================= PAGINATION =================
$perPage = 5;
$total = count($hasil);
$totalPage = ceil($total / $perPage);
$start = ($page - 1) * $perPage;
$hasil = array_slice($hasil, $start, $perPage);

// ================= HIGHLIGHT =================
function highlight($text, $keyword){
    if (!$keyword) return $text;
    return preg_replace("/($keyword)/i","<mark>$1</mark>",$text);
}

// ================= EXPORT CSV =================
if(isset($_GET['export'])){
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="hasil.csv"');
    $output = fopen("php://output","w");
    fputcsv($output, array_keys($buku_list[0]));
    foreach($hasil as $row){
        fputcsv($output,$row);
    }
    fclose($output);
    exit;
}

// ================= SAVE SESSION =================
$_SESSION['recent'][] = $_GET;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h3>Pencarian Buku</h3>

<?php if($errors): ?>
<div class="alert alert-danger">
    <?= implode("<br>", $errors) ?>
</div>
<?php endif; ?>

<form method="GET" class="row g-2">
    <input type="text" name="keyword" placeholder="Keyword" class="form-control col" value="<?= $keyword ?>">
    
    <select name="kategori" class="form-control col">
        <option value="">Semua Kategori</option>
        <option <?= $kategori=="Teknologi"?'selected':'' ?>>Teknologi</option>
        <option <?= $kategori=="Pendidikan"?'selected':'' ?>>Pendidikan</option>
        <option <?= $kategori=="Sains"?'selected':'' ?>>Sains</option>
        <option <?= $kategori=="Ekonomi"?'selected':'' ?>>Ekonomi</option>
    </select>

    <input type="number" name="min_harga" placeholder="Min" value="<?= $min_harga ?>" class="form-control col">
    <input type="number" name="max_harga" placeholder="Max" value="<?= $max_harga ?>" class="form-control col">
    <input type="number" name="tahun" placeholder="Tahun" value="<?= $tahun ?>" class="form-control col">

    <select name="status" class="form-control col">
        <option value="semua">Semua</option>
        <option value="tersedia" <?= $status=="tersedia"?'selected':'' ?>>Tersedia</option>
        <option value="habis" <?= $status=="habis"?'selected':'' ?>>Habis</option>
    </select>

    <select name="sort" class="form-control col">
        <option value="judul">Judul</option>
        <option value="harga">Harga</option>
        <option value="tahun">Tahun</option>
    </select>

    <button class="btn btn-primary col">Cari</button>
</form>

<a href="?<?= http_build_query($_GET) ?>&export=1" class="btn btn-success mt-2">Export CSV</a>

<h5 class="mt-3">Total: <?= $total ?> buku</h5>

<table class="table table-bordered mt-2">
<tr>
    <th>Kode</th><th>Judul</th><th>Kategori</th><th>Harga</th><th>Tahun</th><th>Stok</th>
</tr>

<?php foreach($hasil as $b): ?>
<tr>
<td><?= $b['kode'] ?></td>
<td><?= highlight($b['judul'],$keyword) ?></td>
<td><?= $b['kategori'] ?></td>
<td><?= $b['harga'] ?></td>
<td><?= $b['tahun'] ?></td>
<td><?= $b['stok'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<!-- PAGINATION -->
<nav>
<?php for($i=1;$i<=$totalPage;$i++): ?>
    <a href="?<?= http_build_query(array_merge($_GET,['page'=>$i])) ?>" class="btn btn-sm btn-secondary"><?= $i ?></a>
<?php endfor; ?>
</nav>

</body>
</html>