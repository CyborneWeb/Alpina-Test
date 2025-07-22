<?php

// podatki za povezavo do MySQL strežnika

$servername = "127.0.0.1"; // localhost povezava, zamenaj z IP-jem strežnika, če podatkovna baza ni lokalna
$username   = "root";
$password   = "geslo123"; // geslo uporabnika MySQL baze
$dbname     = "spletna_trgovina_test";      // ime podatkovne baze za uporabo




// ustvarjanje povezave z MySQL strežnikom z uporabo podatkov za povezavo
$conn = new mysqli($servername, $username, $password, $dbname);

// preverjanje povezave z strežnikom
if ($conn->connect_error) {
    // neuspešna povezava -> izpis napake ter zaključitev izvajanja kode
    die("Povezava neuspešna: " . $conn->connect_error);
}

// Uspešna povezava -> izpis konzolnega sporočila
echo "Uspešna povezava z podatkovno bazo ($dbname) kot uporabnik '$username'!" . PHP_EOL;



// Pridobitev trenutnega datuma in uporabnika, ter shranjevanje v spremenljivki
$ck_uspr = get_current_user();
$ck_dspr = date('Y-m-d');





// pridobi vrstice iz tabele podatki_spletna_trgovina, ki še niso bile prenešene v podatkovno bazo za napredno obdelavo (status = 0)
$sql = "SELECT * FROM podatki_spletna_trgovina WHERE status = 0";
$result = $conn->query($sql);



while ($row = $result->fetch_assoc()) {
    // 3. Pridobi naslednjo prosto ck_sif
    $ck_podr = 10; // Področje Slovenije, 
    $nextSif = 1;
    $sifResult = $conn->query("SELECT MAX(ck_sif) as max_sif FROM podatki_crm WHERE ck_podr = $ck_podr");
    if ($sifRow = $sifResult->fetch_assoc()) {
        $nextSif = $sifRow['max_sif'] + 1;
    }
    echo("Naslednja prosta ck_sif: $nextSif" . PHP_EOL);


    $eanResult = $conn->query("SELECT ean FROM seznam_ean_kod WHERE status = 'vnesen' LIMIT 1");
    if (!$eanResult || $eanResult->num_rows == 0) {
        echo "Ni več prostih ean kod...preskok vrstice\n"; // v primeru, da zmanjka ean kod, preskoči vrstico v podatkih
        continue;
    }
    $ean = $eanResult->fetch_assoc()['koda'];
    echo("Uporabljen ean: $ean" . PHP_EOL);
}


// izpis vrstic iz spremnljivke $result (DEBUG)
// while ($row = $result->fetch_assoc()) {
//     print_r($row);
// }


// zaključi povezavo z MySQL strežnikom
$conn->close();

?>