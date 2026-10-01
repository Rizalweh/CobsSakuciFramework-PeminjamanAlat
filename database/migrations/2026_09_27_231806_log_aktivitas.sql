-- create_log_aktivitas_table

CREATE TABLE IF NOT EXISTS `log_aktivitas` (
    id_log INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NULL,
    aktivitas VARCHAR(255) NOT NULL,
    waktu DATETIME NOT NULL,

    CONSTRAINT fk_log_user
        FOREIGN KEY (id_user) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;