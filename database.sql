CREATE DATABASE IF NOT EXISTS crud;
USE crud;

CREATE TABLE peserta (
  id_peserta INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(50) NOT NULL,
  sekolah VARCHAR(50) NOT NULL,
  jurusan VARCHAR(50) NOT NULL,
  no_hp VARCHAR(13) NOT NULL,
  alamat TEXT NOT NULL
);

INSERT INTO peserta (nama, sekolah, jurusan, no_hp, alamat) VALUES
('Contoh Peserta 1', 'SMKN 1 Contoh', 'TKJ', '081234567890', 'Jl. Contoh No. 123'),
('Contoh Peserta 2', 'SMKN 2 Contoh', 'Multimedia', '081298765432', 'Jl. Sample No. 456');