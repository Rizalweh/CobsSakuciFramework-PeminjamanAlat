
-- create_pengembalian_table

CREATE TABLE IF NOT EXISTS `pengembalian` (
    id_pengembalian INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_peminjaman INT UNSIGNED NOT NULL UNIQUE,
    id_petugas INT UNSIGNED NOT NULL,
    tanggal_kembali_aktual DATE NOT NULL,
    kondisi_alat ENUM('baik', 'rusak_ringan', 'rusak_berat') NOT NULL DEFAULT 'baik',
    hari_telat INT NOT NULL DEFAULT 0,
    denda DECIMAL(10,2) NOT NULL DEFAULT 0,
    catatan TEXT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,

    CONSTRAINT fk_pengembalian_peminjaman
        FOREIGN KEY (id_peminjaman) REFERENCES peminjaman(id_peminjaman)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_pengembalian_petugas
        FOREIGN KEY (id_petugas) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
