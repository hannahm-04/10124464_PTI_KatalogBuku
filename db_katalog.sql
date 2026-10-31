CREATE DATABASE IF NOT EXISTS db_katalog;
USE db_katalog;

CREATE TABLE IF NOT EXISTS buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_buku VARCHAR(20) NOT NULL UNIQUE,
    judul VARCHAR(150) NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    tahun INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO buku (kode_buku, judul, penulis, kategori, tahun) VALUES
('BK-KMK01', 'Detective Conan Vol. 100', 'Gosho Aoyama', 'Komik', 2021),
('BK-SJR01', 'Sejarah Nasional Indonesia', 'Sartono Kartodirdjo', 'Sejarah', 2019),
('BK-SNS01', 'Kosmos: Menjelajah Semesta', 'Carl Sagan', 'Sains', 2020);