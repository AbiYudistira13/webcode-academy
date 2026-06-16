CREATE DATABASE db_prototype_gamfikasi;

USE db_media_pembelajaran;

CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    username VARCHAR(50),
    password VARCHAR(100),
    role VARCHAR(20),
    kelas VARCHAR(20)
);

CREATE TABLE materi (
    id_materi INT AUTO_INCREMENT PRIMARY KEY,
    judul_materi VARCHAR(200),
    isi_materi TEXT,
    video VARCHAR(255),
    kategori VARCHAR(100),
    tanggal_upload DATE
);

CREATE TABLE kuis (
    id_kuis INT AUTO_INCREMENT PRIMARY KEY,
    pertanyaan TEXT,
    pilihan_a VARCHAR(100),
    pilihan_b VARCHAR(100),
    pilihan_c VARCHAR(100),
    pilihan_d VARCHAR(100),
    jawaban_benar VARCHAR(10),
    skor INT
);

CREATE TABLE poin (
    id_poin INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    jumlah_poin INT,
    level_user VARCHAR(50),
    badge VARCHAR(100)
);