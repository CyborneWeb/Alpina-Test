--- (PO ŽELJI) USTVARJANJE PODATKOVNE BAZE ZA SHRANJEVANJE PODATKOV
CREATE DATABASE IF NOT EXISTS spletna_trgovina_test; -- spremeni ime baze po želji
USE spletna_trgovina_test;


--- USTVARJANJE 1. TABELE : podatki_spletna_trgovina
DROP TABLE IF EXISTS podatki_spletna_trgovina;
CREATE TABLE podatki_spletna_trgovina (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(100),
    priimek VARCHAR(100),
    email VARCHAR(150),
    telefon VARCHAR(50),
    naslov VARCHAR(255),
    posta VARCHAR(20),
    kraj VARCHAR(100),
    spol ENUM('M', 'Z') DEFAULT NULL,
    interest VARCHAR(100),
    status TINYINT(1) DEFAULT 0
);

-- USTVARJANJE 2. TABELE : seznam_ean_kod
DROP TABLE IF EXISTS seznam_ean_kod;
CREATE TABLE seznam_ean_kod (
    id INT AUTO_INCREMENT PRIMARY KEY,
    koda VARCHAR(20) UNIQUE,
    status ENUM('vnesen', 'porabljen') DEFAULT 'vnesen'
);

-- USTVARJANJE 3. TABELE : podatki_crm
DROP TABLE IF EXISTS podatki_crm;
CREATE TABLE podatki_crm (
    ck_sif INT NOT NULL,
    ck_podr VARCHAR(10) NOT NULL,
    ck_uspr VARCHAR(100),           -- sistemski uporabnik
    ck_dspr DATE,                   -- datum spremembe
    ck_zaup13 VARCHAR(20),          -- EAN koda
    ime VARCHAR(100),
    priimek VARCHAR(100),
    email VARCHAR(150),
    telefon VARCHAR(50),
    naslov VARCHAR(255),
    posta VARCHAR(20),
    kraj VARCHAR(100),
    spol ENUM('M', 'Z') DEFAULT NULL,
    interest VARCHAR(100),
    PRIMARY KEY (ck_sif, ck_podr)
);
