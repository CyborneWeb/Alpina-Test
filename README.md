# Alpina-Test

Alpina-Test je projekt napisan v PHP, ki uporablja MySQL podatkovno bazo za shranjevanje podatkov.

## Zahteve

- PHP (priporočeno 7.4 ali novejši)
- MySQL strežnik
- PHP razširitev `mysqli`

## Namestitev

### 1. Namestitev PHP mysqli razširitve

Če uporabljate Linux (npr. Ubuntu), za namestitev zaženite:
```bash
sudo apt-get install php-mysqli
```
Po namestitvi ponovno zaženite spletni strežnik:
```bash
sudo systemctl restart apache2
```

### 2. Nastavitev MySQL podatkovne baze

#### a) Ustvarite podatkovno bazo in tabele

V projektni mapi poiščite SQL skripte (npr. `database.sql`). Zaženite naslednji ukaz v MySQL terminalu:
```sql
SOURCE /pot/do/database.sql;
```

#### b) Uvoz podatkov

Če obstaja skripta za uvoz podatkov (npr. `import.sql`), jo zaženite podobno:
```sql
SOURCE /pot/do/import.sql;
```

### 3. Prilagoditev MySQL nastavitev v PHP kodi

Odprite PHP datoteko, kjer se vzpostavi povezava z bazo (pogosto `config.php` ali `db_connect.php`), in uredite naslednje spremenljivke:
```php
$host = 'localhost'; // ali naslov vašega MySQL strežnika
$user = 'uporabniško_ime';
$password = 'geslo';
$database = 'ime_podatkovne_baze';
```

### 4. Zagon PHP kode

Če uporabljate lokalni strežnik (npr. XAMPP, WAMP ali Apache):

1. Skopirajte projektne datoteke v mapo `htdocs` ali `www`.
2. Odprite brskalnik in obiščite:  
   ```
   http://localhost/Alpina-Test/
   ```
3. Sledite navodilom na spletni strani.

## Pogosta vprašanja

**Napaka: "Call to undefined function mysqli_connect()"**  
Preverite, če je nameščena razširitev `mysqli` in da je omogočena v `php.ini`.

**Napaka pri povezavi z bazo**  
Preverite, če so podatki za povezavo (host, uporabnik, geslo, baza) pravilni in če ima uporabnik ustrezne pravice.

## Kontakt

Za vprašanja ali prijavo napak se obrnite na [vaš email ali GitHub profil].
