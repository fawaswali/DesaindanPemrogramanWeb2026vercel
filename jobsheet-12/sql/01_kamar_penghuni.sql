-- Jobsheet 12: Skema Kamar dan Penghuni Kost Papa
CREATE TABLE IF NOT EXISTS kamar_12 (
    id SERIAL PRIMARY KEY,
    nomor_kamar VARCHAR(50) NOT NULL UNIQUE,
    tipe_kamar VARCHAR(50) NOT NULL,
    harga_bulanan NUMERIC(12, 2) NOT NULL DEFAULT 0,
    fasilitas TEXT,
    stok INTEGER NOT NULL DEFAULT 1,
    status VARCHAR(20) DEFAULT 'Tersedia'
);

CREATE TABLE IF NOT EXISTS penghuni_12 (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    nik VARCHAR(50) NOT NULL UNIQUE,
    alamat TEXT,
    no_hp VARCHAR(30)
);