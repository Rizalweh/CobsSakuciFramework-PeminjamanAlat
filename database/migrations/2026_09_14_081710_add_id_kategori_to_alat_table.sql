-- add_id_kategori_to_alat_table

ALTER TABLE `alat`
ADD COLUMN `id_kategori` INT UNSIGNED NULL AFTER `kondisi`,
ADD CONSTRAINT `fk_alat_kategori`
    FOREIGN KEY (`id_kategori`) REFERENCES `kategori`(`id_kategori`)
    ON DELETE SET NULL
    ON UPDATE CASCADE;