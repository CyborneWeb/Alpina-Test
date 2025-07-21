
LOAD DATA INFILE '/var/lib/mysql-files/podatki-spletna-trgovina.csv'
INTO TABLE podatki_spletna_trgovina
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(ime, priimek, email, telefon, naslov, posta, kraj, spol, interest, status);




