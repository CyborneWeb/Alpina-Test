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
    //echo("Naslednja prosta ck_sif: $nextSif" . PHP_EOL);


    $eanResult = $conn->query("SELECT ean FROM seznam_ean_kod WHERE status = 'vnesen' LIMIT 1");
    if (!$eanResult || $eanResult->num_rows == 0) {
        echo "Ni več prostih ean kod...preskok vrstice\n"; // v primeru, da zmanjka ean kod, preskoči vrstico v podatkih
        continue;
    }
    $ean = $eanResult->fetch_assoc()['ean'];
    //echo("Uporabljen ean: $ean" . PHP_EOL);

    // izrez letnika iz datuma rojstva (mm/dd/yyyy)
    $birthdate = $row['birthdate'];
    $year = substr($birthdate, -4);

    // sprememba spola iz M/Z v 1/2 (moški - 2, ženski - 1)
    $gender = strtoupper($row['gender']);
    if ($gender == 'M') {
        $gender = 2;
    } elseif ($gender == 'Z') {
        $gender = 1;
    } else {
        $gender = 0; // napaka oz. neznan spol
    }

    // preverjanje nastavitev za oglaševanje
    $mailing = $row['mailing'] ? 1 : 0;
    $sms = $row['sms'] ? 1 : 0;
    // če je kateri izmed načinov označen z 1 nastavi vrednost ck_rekl na 1, sicer na 0
    $ck_rekl = ($mailing || $sms) ? 1 : 0;


    // pretvorba značilnost v ck_intrs
    $ck_intrs = '';
    $interests = explode(',', $row['interest']);
    //print_r($interests);
    $mapiranjeInterestov = [
        'zm' => 0,
        'mm' => 1,
        'pc' => 2,
        'ph' => 3,
        'sm' => 4,
        'tk' => 5
    ];

    $ck_intrs = str_repeat(' ', 6);

    // zanka za pretvorbo interesov (oz. značilnosti) v ck_intrs
    foreach ($interests as $interest) {
        $interest = trim($interest);
        if (isset($mapiranjeInterestov[$interest])) {
            $index = $mapiranjeInterestov[$interest];
            $ck_intrs[$index] = 'X'; // nastavi znak na pravilnem indeksu na 'X'
        }
    }

    //echo ($ck_intrs . PHP_EOL);





    // priprava podatkov za prenost v tabelo podatki_crm
    $PodatkiVnos = [
        'ck_sif' => $nextSif,
        'ck_prii' => strtoupper($row['lastname']),
        'ck_ime' => strtoupper($row['firstname']),
        'ck_ulic' => strtoupper($row['street']),
        'ck_post' => strtoupper($row['zipcode']),
        'ck_kraj' => $row['city'],
        'ck_podr' => $ck_podr, // Področje Slovenije
        'ck_tel1' => $row['phone'],
        'ck_email' => strtoupper($row['email']),
        'ck_rojd' => $row['birthdate'],
        'ck_letnik' => $year,
        'ck_spol' => $gender,
        'ck_rekl' => $ck_rekl,
        'ck_dspr' => $ck_dspr, // datum prenosa v tabelo
        'ck_uspr' => $ck_uspr, // uporabnik, ki je izvedel prenos
        'ck_intrs' => $ck_intrs, // značilnosti
        'ck_zaup13' => $ean, // izbrana ean koda
        'ck_pod' => "SLO" // Področje Slovenije
    ];


    // pripraba imen stolpcev 
    $stolpci = implode(', ', array_keys($PodatkiVnos));


    // priprava vrednosti v formatu pravilnem za INSERT stavek
    $vrednosti = [];

    foreach ($PodatkiVnos as $key => $value) {
        if ($key === 'ck_sif') {
            // Trenutno je samo ck_sif nastavljen kot INT, ostali podatki pa so VARCHAR
            $vrednosti[] = $value;
        } else {
            $vrednosti[] = "'" . $conn->real_escape_string($value) . "'";
        }
    }
    $valuesString = implode(', ', $vrednosti);

    $insertStavek = "INSERT INTO podatki_crm ($stolpci) VALUES ($valuesString)";


    // preverjanje če je vnos uspel, ter spreminjanje statusov v seznam_ean_kod in podatki_spletna_trgovina

    if ($conn->query($insertSql) === TRUE) {
        echo "Uspešno vnešen zapis: " . $PodatkiVnos['ck_ime'] . " " . $PodatkiVnos['ck_prii'] . PHP_EOL;

        // Update EAN and source table status
        $conn->query("UPDATE seznam_ean_kod SET status = 'uporabljen' WHERE ean = '$ean'");
        $conn->query("UPDATE podatki_spletna_trgovina SET status = 1 WHERE id = {$row['id']}");
    } else {
        echo "Napaka pri vstavljanju: " . $conn->error . PHP_EOL;
    }



    echo ($valuesString . PHP_EOL);
}





// zaključi povezavo z MySQL strežnikom
$conn->close();
