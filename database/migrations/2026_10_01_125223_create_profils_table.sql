-- create_profil_table

CREATE TABLE IF NOT EXISTS `profil` (
    id_profil INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL UNIQUE,
    nama_lengkap VARCHAR(255) NOT NULL,
    no_hp VARCHAR(20) NULL,
    nis VARCHAR(20) NOT NULL,
    alamat TEXT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,

    CONSTRAINT fk_profil_user
        FOREIGN KEY (id_user) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;