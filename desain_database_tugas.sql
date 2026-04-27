-- Tabel Kategori --
CREATE TABLE kategori_buku (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Penerbit --
CREATE TABLE penerbit (
    id_penerbit INT AUTO_INCREMENT PRIMARY KEY,
    nama_penerbit VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(15),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Buku --
CREATE TABLE buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150) NOT NULL,
    penulis VARCHAR(100),
    tahun_terbit YEAR,
    harga DECIMAL(10,2),
    stok INT,

    id_kategori INT,
    id_penerbit INT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_kategori) REFERENCES kategori_buku(id_kategori),
    FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit)
);

-- Insert Data --
INSERT INTO kategori_buku (nama_kategori, deskripsi) VALUES
('Novel', 'Buku cerita fiksi'),
('Teknologi', 'Buku tentang IT dan komputer'),
('Pendidikan', 'Buku pelajaran'),
('Sejarah', 'Buku sejarah dunia'),
('Agama', 'Buku keagamaan');

INSERT INTO penerbit (nama_penerbit, alamat, telepon, email) VALUES
('Gramedia', 'Jakarta', '0811111111', 'gramedia@email.com'),
('Erlangga', 'Bandung', '0822222222', 'erlangga@email.com'),
('Mizan', 'Yogyakarta', '0833333333', 'mizan@email.com'),
('Andi Offset', 'Yogyakarta', '0844444444', 'andi@email.com'),
('Deepublish', 'Sleman', '0855555555', 'deepublish@email.com');

INSERT INTO buku (judul, penulis, tahun_terbit, harga, stok, id_kategori, id_penerbit) VALUES
('Laskar Pelangi', 'Andrea Hirata', 2005, 85000, 10, 1, 1),
('Negeri 5 Menara', 'Ahmad Fuadi', 2009, 90000, 8, 1, 2),
('Belajar SQL', 'Budi Raharjo', 2020, 120000, 5, 2, 4),
('Pemrograman PHP', 'Rudi Hartono', 2019, 110000, 7, 2, 4),
('Matematika SMA', 'Slamet', 2018, 75000, 15, 3, 2),
('Fisika Dasar', 'Sutrisno', 2017, 80000, 12, 3, 2),
('Sejarah Dunia', 'Herodotus', 2010, 95000, 6, 4, 3),
('Sejarah Indonesia', 'Sartono', 2012, 88000, 9, 4, 3),
('Fiqih Islam', 'Ustadz Ahmad', 2015, 70000, 10, 5, 3),
('Tafsir Al-Quran', 'Quraish Shihab', 2016, 150000, 4, 5, 3),
('Algoritma', 'Suryo', 2021, 130000, 6, 2, 5),
('Basis Data', 'Indra', 2022, 125000, 5, 2, 5),
('Cerita Rakyat', 'Anonim', 2000, 60000, 20, 1, 1),
('Kimia SMA', 'Bambang', 2019, 78000, 14, 3, 2),
('Hadits Arbain', 'Imam Nawawi', 1995, 50000, 11, 5, 3);

-- Query Wajib --
SELECT 
    b.judul,
    b.penulis,
    k.nama_kategori,
    p.nama_penerbit
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;

-- Jumlah Buku Per Kategori --
SELECT 
    k.nama_kategori,
    COUNT(b.id_buku) AS jumlah_buku
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
GROUP BY k.nama_kategori;

-- Jumlah Buku Per Penerbit --
SELECT 
    p.nama_penerbit,
    COUNT(b.id_buku) AS jumlah_buku
FROM buku b
JOIN penerbit p ON b.id_penerbit = p.id_penerbit
GROUP BY p.nama_penerbit;

-- Detail Buku --
SELECT 
    b.*,
    k.nama_kategori,
    p.nama_penerbit,
    p.alamat
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;

CREATE TABLE rak (
    id_rak INT AUTO_INCREMENT PRIMARY KEY,
    nama_rak VARCHAR(50)
);

-- Tabel Rak --
ALTER TABLE buku ADD id_rak INT;
ALTER TABLE buku ADD FOREIGN KEY (id_rak) REFERENCES rak(id_rak);

-- Soft Delete --
ALTER TABLE buku ADD deleted_at TIMESTAMP NULL;

-- Stored Procedure --
DELIMITER $$

CREATE PROCEDURE tambah_buku(
    IN p_judul VARCHAR(150),
    IN p_penulis VARCHAR(100),
    IN p_kategori INT,
    IN p_penerbit INT
)
BEGIN
    INSERT INTO buku (judul, penulis, id_kategori, id_penerbit)
    VALUES (p_judul, p_penulis, p_kategori, p_penerbit);
END$$

DELIMITER ;