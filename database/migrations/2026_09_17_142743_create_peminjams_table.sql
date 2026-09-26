-- create_peminjams_table

CREATE TABLE IF NOT EXISTS `peminjam` (
    id_peminjam         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user     INT UNSIGNED NOT NULL,
    nama_peminjam       VARCHAR(255) NOT NULL,
    nis_peminjam       VARCHAR(20) NOT NULL,
    kelas_peminjam       VARCHAR(10) NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,

    CONSTRAINT fk_peminjam_user FOREIGN KEY (id_user) 
    REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


