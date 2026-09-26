-- Jobsheet 10: Skema Tabel Kamar & Penghuni Kost Papa (PostgreSQL)

CREATE TABLE IF NOT EXISTS kamar_10 (
    id SERIAL PRIMARY KEY,
    nomor_kamar VARCHAR(20) NOT NULL,
    tipe_kamar VARCHAR(50) NOT NULL,
    fasilitas TEXT,
    harga_bulanan INT NOT NULL,
    status VARCHAR(20) DEFAULT 'Tersedia',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS penghuni_10 (
    id SERIAL PRIMARY KEY,
    nik VARCHAR(20) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    no_telepon VARCHAR(20),
    pekerjaan VARCHAR(50),
    tanggal_masuk DATE DEFAULT CURRENT_DATE,
    kamar_id INT REFERENCES kamar_10(id) ON DELETE SET NULL
);