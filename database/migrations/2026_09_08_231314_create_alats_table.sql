-- create_alats_table

CREATE TABLE IF NOT EXISTS `alat` (
    id_alat         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_alat       VARCHAR(10) NOT NULL UNIQUE,
    nama_alat       VARCHAR(255) NOT NULL,
    stok            INT NOT NULL DEFAULT 0,
    kondisi         ENUM('Baik', 'Rusak Ringan', 'Rusak Berat') NOT NULL DEFAULT 'Baik',
    foto_alat       VARCHAR(255) NULL,

    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
