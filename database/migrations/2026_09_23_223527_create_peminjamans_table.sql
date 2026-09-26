-- create_peminjaman_table

CREATE TABLE IF NOT EXISTS `peminjaman` (
    id_peminjaman INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_peminjaman VARCHAR(255) NOT NULL UNIQUE,
    id_peminjam INT UNSIGNED NOT NULL,
    id_alat INT UNSIGNED NOT NULL,
    jumlah_pinjam INT NOT NULL,
    tanggal_pengajuan DATE NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali_rencana DATE NOT NULL, -- ini kata "rencana" maksudnya semisal gatau kapan kembali nya, jadi ada kata"rencana"
    status_peminjaman ENUM('pending', 'disetujui', 'ditolak', 'dikembalikan') NOT NULL DEFAULT 'pending',
    catatan TEXT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,

    CONSTRAINT fk_peminjaman_peminjam
        FOREIGN KEY (id_peminjam) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_peminjaman_alat
        FOREIGN KEY (id_alat) REFERENCES alat(id_alat)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;