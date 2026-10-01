-- alter_status_peminjaman_add_menunggu_pengembalian

ALTER TABLE `peminjaman`
MODIFY COLUMN `status_peminjaman`
    ENUM('pending', 'disetujui', 'ditolak', 'menunggu_pengembalian', 'dikembalikan')
    NOT NULL DEFAULT 'pending';