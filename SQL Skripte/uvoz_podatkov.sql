
LOAD DATA INFILE '/var/lib/mysql-files/podatki-spletna-trgovina.csv'
INTO TABLE podatki_spletna_trgovina
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(ime, priimek, email, telefon, naslov, posta, kraj, spol, interest, status);

LOAD DATA INFILE '/var/lib/mysql-files/podatki_crm.csv'
INTO TABLE podatki_crm
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(ck_sif, ck_podr, ck_uspr, ck_dspr, ck_zaup13, ime, priimek, email, telefon, naslov, posta, kraj, spol, interest);



