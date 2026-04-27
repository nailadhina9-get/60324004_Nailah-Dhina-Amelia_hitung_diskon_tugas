<?php

// 1. Hitung total anggota
function hitung_total_anggota($anggota_list) {
    return count($anggota_list);
}

// 2. Hitung anggota aktif
function hitung_anggota_aktif($anggota_list) {
    $count = 0;
    foreach ($anggota_list as $anggota) {
        if ($anggota['status'] == "Aktif") {
            $count++;
        }
    }
    return $count;
}

// 3. Rata-rata pinjaman
function hitung_rata_rata_pinjaman($anggota_list) {
    $total = 0;
    foreach ($anggota_list as $anggota) {
        $total += $anggota['total_pinjaman'];
    }
    return count($anggota_list) > 0 ? $total / count($anggota_list) : 0;
}

// 4. Cari anggota by ID
function cari_anggota_by_id($anggota_list, $id) {
    foreach ($anggota_list as $anggota) {
        if ($anggota['id'] == $id) {
            return $anggota;
        }
    }
    return null;
}

// 5. Cari anggota teraktif
function cari_anggota_teraktif($anggota_list) {
    $max = null;
    foreach ($anggota_list as $anggota) {
        if ($max == null || $anggota['total_pinjaman'] > $max['total_pinjaman']) {
            $max = $anggota;
        }
    }
    return $max;
}

// 6. Filter by status
function filter_by_status($anggota_list, $status) {
    $result = [];
    foreach ($anggota_list as $anggota) {
        if ($anggota['status'] == $status) {
            $result[] = $anggota;
        }
    }
    return $result;
}

// 7. Validasi email
function validasi_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// 8. Format tanggal
function format_tanggal_indo($tanggal) {
    $bulan = [
        1 => "Januari","Februari","Maret","April","Mei","Juni",
        "Juli","Agustus","September","Oktober","November","Desember"
    ];
    
    $pecah = explode('-', $tanggal);
    return $pecah[2] . " " . $bulan[(int)$pecah[1]] . " " . $pecah[0];
}

// Sort nama A-Z
function sort_nama($anggota_list) {
    usort($anggota_list, function($a, $b) {
        return strcmp($a['nama'], $b['nama']);
    });
    return $anggota_list;
}

// Search nama
function search_nama($anggota_list, $keyword) {
    $result = [];
    foreach ($anggota_list as $anggota) {
        if (stripos($anggota['nama'], $keyword) !== false) {
            $result[] = $anggota;
        }
    }
    return $result;
}

?>