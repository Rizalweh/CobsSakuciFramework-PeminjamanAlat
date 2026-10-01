ALTER TABLE `alat`
ADD COLUMN `harga_alat` DECIMAL(12,2) NOT NULL DEFAULT 0 AFTER `stok`;

ALTER TABLE `pengembalian`
MODIFY COLUMN `kondisi_alat` ENUM('baik','rusak_ringan','rusak_berat','hilang') NOT NULL DEFAULT 'baik',
ADD COLUMN `denda_telat` DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER `hari_telat`,
ADD COLUMN `denda_kerusakan` DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER `denda_telat`,
ADD COLUMN `status_denda` ENUM('tidak_ada','belum_lunas','lunas') NOT NULL DEFAULT 'tidak_ada' AFTER `denda`,
ADD COLUMN `tanggal_bayar` DATETIME NULL AFTER `status_denda`,
ADD COLUMN `id_penerima_bayar` INT UNSIGNED NULL AFTER `tanggal_bayar`,
ADD CONSTRAINT `fk_pengembalian_penerima`
    FOREIGN KEY (`id_penerima_bayar`) REFERENCES `users`(`id`)
    ON UPDATE CASCADE ON DELETE SET NULL;

-- data lama yang sudah punya denda
UPDATE `pengembalian` SET denda_telat = denda,
    status_denda = IF(denda > 0, 'belum_lunas', 'tidak_ada');