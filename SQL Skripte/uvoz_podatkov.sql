
--NAVODILA ZA UPORABO:
-- ustvari podatkovno bazo ter potrebne tabele (s pomočjo create_tables.sql)
-- zamenjaj poti do CSV datotek v skladu z lokacijami na svojem sistemu
-- zaženi skript v testnem MySQL strežniku




-- UVOZ PODATKOV -- 1. TABELA 

LOAD DATA INFILE '/var/lib/mysql-files/podatki-spletna-trgovina.csv'
INTO TABLE podatki_spletna_trgovina
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(ime, priimek, email, telefon, naslov, posta, kraj, spol, interest, status);


-- UVOZ PODATKOV -- 2. TABELA 

LOAD DATA INFILE '/var/lib/mysql-files/podatki_crm.csv'
INTO TABLE podatki_crm
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(ck_sif, ck_podr, ck_uspr, ck_dspr, ck_zaup13, ime, priimek, email, telefon, naslov, posta, kraj, spol, interest);

-- UVOZ PODATKOV -- 3. TABELA 

LOAD DATA INFILE '/var/lib/mysql-files/ean_seznam.csv'
INTO TABLE seznam_ean_kod
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(koda, status);


