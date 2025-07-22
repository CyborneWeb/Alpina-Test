# Alpina-Test

Alpina-Test je dokončana naloga za študentsko delo programerja v Alpini

## Zahteve

- PHP (priporočeno 7.4 ali novejši)
- MySQL strežnik
- PHP razširitev `mysqli`

## Namestitev

### 1. Namestitev PHP mysqli razširitve

V primeru uporabe sistema z Linux Distribucijo (npr. Ubuntu, Mint, Debian itd.)
```bash
sudo apt-get install php-mysqli
```
Po namestitvi ponovno zaženite spletni strežnik:
```bash
sudo systemctl restart apache2
```

### 2. Nastavitev MySQL podatkovne baze

#### a) Ustvarite podatkovno bazo in tabele

V projektni mapi poiščite SQL skripto `ustvari_tabele.sql`, ter ga zaženite z pomočjo različnih orodij (npr. Heidi ali pa kar v terminalu)
- skripta bo ustvarila podatkovno bazo, ter tabele z stolpci za podatke

#### b) Uvoz podatkov

Na vaš sistem naložite csv datoteke podatkov v mapi datoteke, ter jih shranite na dosegljivo mesto na vašem računalniku
Pridobite poti do csv datotek, ter spremenite poti v `uvoz_podatkov.sql` v pravilne poti, ki ustrezajo vašem sistemu
Zaženite skripto, ki bo v primeru da so csv datoteke na pravilnem mestu, ter da so bile tabele in podatkovna baza ustvarjena pravilno, uvozila potrebne podatke za testiranje php kode.

### 3. Prilagoditev MySQL nastavitev v PHP kodi

Odprite PHP datoteko, ki vsebuje vso kodo projekta, ter spremenite podatke za povezavo z podatkovno bazo
```php
$servername = 'localhost'; // ali naslov vašega MySQL strežnika
$username = 'uporabniško_ime';
$password = 'geslo';
$dbname = 'ime_podatkovne_baze';
```

### 4. Zagon PHP kode

Če uporabljate lokalni strežnik (npr. XAMPP, WAMP ali Apache):

1. Skopirajte projektne datoteke v mapo `htdocs` ali `www`.
2. Odprite brskalnik in obiščite:  
   ```
   http://localhost/Alpina-Test/
   ```
3. kodo lahko zaženete tudi v terminalu z ukazom
```bash
php ime_datoteke.php
```

## Pogoste Napake

**Napaka: "Call to undefined function mysqli_connect()"**  
Preverite, če je nameščena razširitev `mysqli` in da je omogočena v `php.ini`.

**Napaka pri povezavi z bazo**  
Preverite, če so podatki za povezavo (host, uporabnik, geslo, baza) pravilni in če ima uporabnik ustrezne pravice.

