-- Create database
CREATE DATABASE IF NOT EXISTS db_apk_bus;
USE db_apk_bus;

-- Drop tables if they exist
DROP TABLE IF EXISTS pembayaran;
DROP TABLE IF EXISTS kursi;
DROP TABLE IF EXISTS pembelian;
DROP TABLE IF EXISTS jadwal;
DROP TABLE IF EXISTS bus;
DROP TABLE IF EXISTS terminal;
DROP TABLE IF EXISTS agen_bus;
DROP TABLE IF EXISTS user;

-- Create table user
CREATE TABLE user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    no_hp VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create table agen_bus
CREATE TABLE agen_bus (
    id_agen INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    alamat TEXT,
    kontak VARCHAR(50)
);

-- Create table terminal
CREATE TABLE terminal (
    id_terminal INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    lokasi VARCHAR(150)
);

-- Create table bus
CREATE TABLE bus (
    id_bus INT AUTO_INCREMENT PRIMARY KEY,
    id_agen INT NOT NULL,
    nama VARCHAR(100),
    kelas ENUM('Ekonomi', 'Bisnis', 'Eksekutif'),
    jumlah_kursi INT,
    FOREIGN KEY (id_agen) REFERENCES agen_bus(id_agen) ON DELETE CASCADE
);

-- Create table jadwal
CREATE TABLE jadwal (
    id_jadwal INT AUTO_INCREMENT PRIMARY KEY,
    id_bus INT NOT NULL,
    id_terminal_asal INT NOT NULL,
    id_terminal_tujuan INT NOT NULL,
    tanggal_berangkat DATE,
    jam_berangkat TIME,
    harga DECIMAL(10,2),
    FOREIGN KEY (id_bus) REFERENCES bus(id_bus) ON DELETE CASCADE,
    FOREIGN KEY (id_terminal_asal) REFERENCES terminal(id_terminal) ON DELETE CASCADE,
    FOREIGN KEY (id_terminal_tujuan) REFERENCES terminal(id_terminal) ON DELETE CASCADE
);

-- Create table pembelian
CREATE TABLE pembelian (
    id_pembelian INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_jadwal INT NOT NULL,
    tanggal_pesan DATE,
    total_harga DECIMAL(10,2),
    FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_jadwal) REFERENCES jadwal(id_jadwal) ON DELETE CASCADE
);

-- Create table kursi
CREATE TABLE kursi (
    id_kursi INT AUTO_INCREMENT PRIMARY KEY,
    id_jadwal INT NOT NULL,
    nomor_kursi VARCHAR(10),
    status ENUM('tersedia', 'terisi') DEFAULT 'tersedia',
    FOREIGN KEY (id_jadwal) REFERENCES jadwal(id_jadwal) ON DELETE CASCADE
);

-- Create table pembayaran
CREATE TABLE pembayaran (
    id_pembayaran INT AUTO_INCREMENT PRIMARY KEY,
    id_pembelian INT NOT NULL,
    metode VARCHAR(50),
    status ENUM('belum dibayar', 'sudah dibayar') DEFAULT 'belum dibayar',
    waktu_bayar DATETIME,
    FOREIGN KEY (id_pembelian) REFERENCES pembelian(id_pembelian) ON DELETE CASCADE
);

-- Insert sample data for testing
-- Insert sample users
INSERT INTO user (nama, email, password, no_hp) VALUES
('John Doe', 'john@example.com', '$2y$10$xxxxxxxxxxx', '081234567890'),
('Jane Smith', 'jane@example.com', '$2y$10$xxxxxxxxxxx', '082345678901'),
('Bob Johnson', 'bob@example.com', '$2y$10$xxxxxxxxxxx', '083456789012');

-- Insert sample bus agencies
INSERT INTO agen_bus (nama, alamat, kontak) VALUES
('Trans Jaya', 'Jl. Pahlawan No. 123', '021-12345678'),
('Sinar Baru', 'Jl. Merdeka No. 456', '021-23456789'),
('Cahaya Express', 'Jl. Sudirman No. 789', '021-34567890');

-- Insert sample terminals
INSERT INTO terminal (nama, lokasi) VALUES
('Terminal Pulogadung', 'Jakarta Timur'),
('Terminal Kampung Rambutan', 'Jakarta Timur'),
('Terminal Kalideres', 'Jakarta Barat'),
('Terminal Leuwipanjang', 'Bandung'),
('Terminal Bungurasih', 'Surabaya');

-- Insert sample buses
INSERT INTO bus (id_agen, nama, kelas, jumlah_kursi) VALUES
(1, 'Trans Jaya 001', 'Eksekutif', 40),
(1, 'Trans Jaya 002', 'Bisnis', 50),
(2, 'Sinar Baru 001', 'Eksekutif', 36),
(2, 'Sinar Baru 002', 'Ekonomi', 60),
(3, 'Cahaya Express 001', 'Eksekutif', 32);

-- Insert sample schedules
INSERT INTO jadwal (id_bus, id_terminal_asal, id_terminal_tujuan, tanggal_berangkat, jam_berangkat, harga) VALUES
(1, 1, 4, '2025-04-20', '08:00:00', 250000),
(2, 1, 5, '2025-04-20', '09:30:00', 200000),
(3, 2, 4, '2025-04-20', '10:00:00', 275000),
(4, 2, 5, '2025-04-20', '13:00:00', 150000),
(5, 3, 5, '2025-04-20', '15:30:00', 300000);