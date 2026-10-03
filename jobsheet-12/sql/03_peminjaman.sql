-- Jobsheet 12: Tabel transaksi peminjaman/sewa
CREATE TABLE IF NOT EXISTS peminjaman_12 (
    id SERIAL PRIMARY KEY,
    buku_id INTEGER NOT NULL REFERENCES kamar_12(id) ON DELETE CASCADE,
    anggota_id INTEGER NOT NULL REFERENCES penghuni_12(id) ON DELETE CASCADE,
    tanggal_pinjam DATE NOT NULL DEFAULT CURRENT_DATE,
    tanggal_kembali DATE,
    status VARCHAR(20) NOT NULL DEFAULT 'dipinjam'
);

CREATE INDEX IF NOT EXISTS idx_peminjaman12_buku ON peminjaman_12(buku_id);
CREATE INDEX IF NOT EXISTS idx_peminjaman12_anggota ON peminjaman_12(anggota_id);
CREATE INDEX IF NOT EXISTS idx_peminjaman12_status ON peminjaman_12(status);