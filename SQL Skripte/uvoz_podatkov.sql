
-- NAVODILA ZA UPORABO:
-- ustvari podatkovno bazo ter potrebne tabele (s pomočjo create_tables.sql)
-- Prenesi csv datoteke iz mape "Podatki" v želeno mapo na tvojemračunalniku, ter zamenjaj poti do datotek na tebi ustrezne poti
-- zaženi skript v testnem MySQL strežniku


USE spletna_trgovina_test; -- uporaba podatkovne baze, če še ni izbrana
--SET GLOBAL local_infile = 1; -- omogoči uvoz podatkov iz datotek, odvisno od sistema ter nastavitev strežnika


-- praznjenje tabel, za namene debugginga 
TRUNCATE TABLE podatki_spletna_trgovina;
TRUNCATE TABLE seznam_ean_kod;
TRUNCATE TABLE podatki_crm;

-- UVOZ PODATKOV -- 1. TABELA 

LOAD DATA INFILE '/var/lib/mysql-files/podatki_spletna_trgovina.csv'
INTO TABLE podatki_spletna_trgovina
FIELDS TERMINATED BY ';'
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(id, firstname, lastname, street, zipcode, city, email, phone, birthdate, interest, gender, sizes, status, mailing, sms, date);


-- UVOZ PODATKOV -- 2. TABELA 

LOAD DATA INFILE '/var/lib/mysql-files/kode_ean.csv'
INTO TABLE seznam_ean_kod
FIELDS TERMINATED BY ';'
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 0 LINES
(ean, status, dzs)
-- UVOZ PODATKOV -- 3. TABELA 

LOAD DATA INFILE '/var/lib/mysql-files/crm_podatki.csv'
INTO TABLE podatki_crm
FIELDS TERMINATED BY ';'
ENCLOSED BY ''
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(CK_SIF, CK_PRII, CK_IME, CK_ULIC, CK_POST, CK_KRAJ, CK_PODR, CK_TEL1, CK_TEL2, CK_TEL3, 
 CK_EMAIL, CK_EMAILIN, CK_ROJD, CK_LETNIK, CK_SPOL, CK_IZOB, CK_REKL, CK_DAV, CK_POS, CK_GESL, 
 CK_DSPR, CK_USPR, CK_OPOM, CK_KOMEN, CK_UPOR, CK_INTRS, CK_EANST, CK_ZAUP13, CK_ZAUPAKT, 
 CK_IZPIS, CK_IZPDAT, CK_POD);


